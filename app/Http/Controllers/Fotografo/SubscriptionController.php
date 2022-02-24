<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Face;
use App\Models\Foto;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{

    public $aws;

    public function __construct()
    {
        $this->aws = new RekognitionClient(
            [
                'region' => env('AWS_DEFAULT_REGION', 'us-west-2'),
                'version' => 'latest'
            ]
        );
    }
    public function index()
    {
        $user = Auth::user();
        $subscriptions = $user->eventos()->where("accepted", true)->get();
        return view('fotografo.suscription.index ', compact('subscriptions'));
    }

    public function uploadPhotoPage(Evento $evento)
    {
        return view('fotografo.suscription.upload-photo', compact('evento'));
    }

    public function savePhotos(Evento $evento, Request $request)
    {
        $this->validate($request, [
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,jpeg,png'
        ]);
        if ($request->hasfile('photos')) {
            /*foreach ($request->file('photos') as $file) {
                $name = time() . '.' . $file->extension();
                $file->move(public_path() . '/files/', $name);
                $data[] = $name;
            }*/
            foreach ($request->file('photos') as $file) {
                $fileName = $file->getClientOriginalName();
                //$file->storeAs('evento/' . $evento->id, $fileName, 's3');
                $path = Storage::disk('s3')->put('eventos/' . $evento->id, $file);
                $paths[] = $path;
            }
            $this->saveFotos($paths, $evento, $request);
        }

        return back()->with('success', 'Data Your files has been successfully added');
    }

    private function saveFotos($paths, $evento, $request)
    {
        $results = $this->getFaces($paths, $evento);
        $fotografo = Auth::guard('fotografo')->user();
        foreach ($results as $result) {
            $path = $result["path"];
            $faces = $result["faces"];
            $foto = new Foto();
            $foto->url = $path;
            $foto->fotografo_id =  $fotografo->id;
            $foto->evento_id = $evento->id;
            $foto->save();
            foreach ($faces as $face) {
                $cara = new Face();
                $cara->face_id = $face["face_id"];
                $cara->image_id = $face["image_id"];
                $cara->foto_id = $foto->id;
                $cara->save();
            }
        }
    }

    private function getFaces($paths, $evento)
    {
        foreach ($paths as $path) {
            $result = $this->getIndexFaces($path);
            foreach ($result["FaceRecords"] as $face) {
                $faces[] = [
                    "face_id" => $face["Face"]["FaceId"],
                    "image_id" => $face["Face"]["ImageId"]
                ];
            }
            $fotos[] = [
                "path" => $path,
                "faces" => $faces
            ];
        }

        return $fotos;
    }

    private function getIndexFaces($path)
    {
        $split = explode("/", $path);
        return $this->aws->indexFaces([
            'CollectionId' => 'avatar',
            'DetectionAttributes' => ["DEFAULT"],
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
