<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Cliente;
use App\Models\Fotografo;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:fotografo');
    }


    public function showFotografoRegisterForm()
    {
        return view('auth.register', ['url' => 'fotografo']);
    }
    protected function validatorFotografo(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clientes'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function createFotografo(Request $request)
    {
        $this->validatorFotografo($request->all())->validate();
        Fotografo::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->intended('login/fotografo');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clientes'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $cliente = Cliente::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $img = $data['avatar'];
        $path = Storage::disk('s3')->put('avatars/' . $cliente->id, $img);


        $client = new RekognitionClient(
            [
                'region' => env('AWS_DEFAULT_REGION', 'us-west-2'),
                'version' => 'latest'
            ]
        );
        $split = explode("/", $path);
        $result = $client->indexFaces([
            'CollectionId' => 'avatar',
            'DetectionAttributes' => [],
            'ExternalImageId' => end($split),
            "MaxFaces" => 1,
            'Image' => [
                'S3Object' => [
                    'Bucket' => 'sw-evento',
                    'Name' => $path,
                ],
            ],
        ]);



        foreach ($result["FaceRecords"] as $face) {
            $avatar = new Avatar();
            $avatar->face_id = $face["Face"]["FaceId"];
            $avatar->image_id = $face["Face"]["ImageId"];
            $avatar->url = $path;
            $avatar->external_id = $face["Face"]["ExternalImageId"];
            $avatar->cliente_id = $cliente->id;
            $avatar->save();
        }


        return $cliente;

        /*return Cliente::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/
    }
}
