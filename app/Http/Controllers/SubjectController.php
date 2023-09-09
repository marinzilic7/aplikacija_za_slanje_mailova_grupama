<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function dodajPredmet(Request $request)
    {

        $data = $request->validate(
            [
                'ime' => 'required',
                'studij' => 'required',


            ],
            [
                'ime.required' => "Ime je obavezno",
                'studij.required' => "Prezime je obavezno ",
                'email.required' => 'Email je obavezan',


            ]
        );


        $predmet = new Subject();
        $predmet->create($data);
        return response()->json(['poruka' => 'Uspjesno dodano']);
    }
}
