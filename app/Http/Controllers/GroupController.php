<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function dodajGrupu(Request $request)
    {

        $data = $request->validate(
            [
                'ime' => 'required',
                'opis' => 'required',


            ],
            [
                'ime.required' => "Obavezno",
                'opis.required' => "Obavezno ",


            ]
        );



        $grupa = new Group();
        $data['user_id'] = auth()->id();
        $grupa->create($data);
        return response()->json(['poruka' => 'Uspjesno']);
    }

    public function getGroup(){

        $group = Group::with('user')->get();
        return response()->json($group);
    }
}
