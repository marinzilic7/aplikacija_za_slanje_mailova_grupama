<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function regUser(Request $request)
    {

        $data = $request->validate(
            [
                'ime' => 'required',
                'prezime' => 'required',
                'email' => 'required',
                'password' => 'required'

            ],
            [
                'ime.required' => "Ime je obavezno",
                'prezime.required' => "Prezime je obavezno ",
                'email.required' => 'Email je obavezan',
                'password.required' => 'Lozinka je obavezna',
                'passwordConf.required' => 'Potvrda lozinke je obavezna',

            ]
        );

        $data['password'] = Hash::make($data['password']);

        $user = new User();
        $user->create($data);
        return response()->json(['poruka' => 'Uspjesna registracija']);
    }

    public function logUser(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',

            ],
            [

                'email.required' => 'Niste unijeli vas email',
                'password.required' => 'Niste unijeli vasu lozinku'
            ]
        );


        if (Auth::attempt($data)) {
            $user = Auth::user();
            return response()->json(['poruka' => 'Uspješna prijava', 'user' => $user]);
        } else {
            return response()->json(['poruka' => 'Neuspješna prijava']);
        }
    }

    public function isLogged()
    {

        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(null);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['redirect' => '/login']);
    }

    public function getUser(){

        $user = User::get();
        return response()->json($user);
    }
}
