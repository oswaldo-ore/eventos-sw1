<?php

namespace App\Http\Controllers\Fotografo;

use App\Events\EventoEvent;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Evento;
use App\Models\Foto;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadPhotos extends Controller
{
    public $aws;
    public $endPoint;

    public function __construct()
    {
        $this->aws = new RekognitionClient(
            [
                'region' => env('AWS_DEFAULT_REGION', 'us-west-2'),
                'version' => 'latest'
            ]
        );
        $this->endPoint = "https://sw-evento.s3.us-west-2.amazonaws.com/";
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function savePhotos(Evento $evento, Request $request)
    {
        $this->validate($request, [
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,jpeg,png'
        ]);
        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $file) {
                $fileName = $file->getClientOriginalName();
                //$file->storeAs('evento/' . $evento->id, $fileName, 's3');
                $path = Storage::disk('s3')->put('eventos/' . $evento->id, $file, "public");
                $paths[] = $path;
            }
            $imageExternal = $this->saveFotos($paths, $evento);

            $avatars = Avatar::whereIn("external_id", $imageExternal)->with("cliente:id")->get();
            $clientesId = [];
            foreach ($avatars as $avatar) {
                $clientesId[] = $avatar->cliente->id;
            }
            $evento->asistenUsuarios()->syncWithoutDetaching($clientesId);
            event(new EventoEvent($evento));
        }

        return back()->with('success', 'Data Your files has been successfully added');
    }

    private function saveFotos($paths, $evento)
    {
        $results = $this->getFaces($paths, $evento);

        $fotografo = Auth::guard('fotografo')->user();
        $imageExternal = [];
        foreach ($results as $result) {
            $path = $result["path"];
            $facesImage = $result["faces"];

            $foto = new Foto();
            $foto->url = $this->endPoint . $path;
            $foto->fotografo_id =  $fotografo->id;
            $foto->evento_id = $evento->id;
            $foto->save();

            foreach ($facesImage as $faceImage) {
                $faces = $this->aws->searchFaces([
                    "CollectionId" => 'avatar',
                    "FaceId" => $faceImage["face_id"],
                ]);

                foreach ($faces["FaceMatches"] as $face) {
                    $imageExternal[] = $face["Face"]["ExternalImageId"];
                }
            }
        }
        return $imageExternal;
    }

    private function getFaces($paths, $evento)
    {
        foreach ($paths as $path) {
            $result = $this->getIndexFaces($path);
            $caras = array();
            foreach ($result["FaceRecords"] as $face) {
                array_push($caras, array(
                    "face_id" => $face["Face"]["FaceId"],
                    "image_id" => $face["Face"]["ImageId"]
                ));
            }
            $fotos[] = [
                "path" => $path,
                "faces" => $caras
            ];
        }
        return $fotos;
    }

    private function getIndexFaces($path)
    {
        $split = explode("/", $path);
        return $this->aws->indexFaces([
            'CollectionId' => 'avatar',
            'DetectionAttributes' => [],
            'ExternalImageId' => end($split),
            'Image' => [
                'S3Object' => [
                    'Bucket' => 'sw-evento',
                    'Name' => $path,
                ],
            ],
        ]);
    }
}
