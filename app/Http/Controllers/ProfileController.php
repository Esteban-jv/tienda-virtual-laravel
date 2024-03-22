<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        return view('profile.edit')
            ->with([
                'user' => $request->user()
            ]);
    }

    public function update(ProfileRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();

            $user->fill(array_filter($request->validated()));

            if($user->isDirty('email'))
            {
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
            }

            // password setPasswordAttribute (leccion 92)
            $user->save();

            // después de crear el entorno de imagenes (clase 93)
            if($request->hasFile('image'))
            {
                if(!is_null($user->image)) // Si ya tenía una imagen antes, se elimina la anterior de la bd y del servidor
                {
                    Storage::disk('images')->delete($user->image->path);
                    $user->image->delete();
                }

                $user->image()->create([
                    'path' => $request->image->store('users','images'),
                ]);
            }


            //TODO: fix bad redirect
            return redirect()
                ->route('profile.edit')
                ->withSuccess('Perfil editado correctamente');
        }, 5);
    }
}
