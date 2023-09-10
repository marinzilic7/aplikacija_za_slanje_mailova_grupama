<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\GroupUse;

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

    public function izbrisiGrupu($id){

        $grupa = Group::findorFail($id);
        $grupa->delete();
        return response()->json(['poruka' => 'Uspjesno']);
    }

    public function urediGrupu(Request $request, $id){

        $grupa = Group::findOrFail($id);
        $data = $request->validate([
            'ime' => 'required|string',
            'opis' => 'required|string',

        ]);

        $grupa->ime=$data['ime'];
        $grupa->opis=$data['opis'];
        $grupa->save();
        return response()->json([
            'poruka' => 'Grupa uspjesno uređena',
            'grupa' => $grupa,
        ]);
    }
}
