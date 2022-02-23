<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
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
                $path = Storage::disk('s3')->put('eventos/' . $evento->id . "/" . $fileName, $file);
                $paths[] = $path;
            }
        }

        return back()->with('success', 'Data Your files has been successfully added');
    }
}
