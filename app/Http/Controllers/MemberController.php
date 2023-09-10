<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dodajClana(Request $request)
    {

        $data = $request->validate(
            [
                'user_id' => 'required',
                'group_id' => 'required',


            ],
            [
                'user_id.required' => "Obavezno",
                'group_id.required' => "Obavezno ",


            ]
        );

        $existMember = Member::where('user_id', $data['user_id'])->first();
        if($existMember){
            return response()->json(['poruka' => 'Korisnik je clan grupe']);
        }

        $clan = new Member();
        $clan->create($data);
        return response()->json(['poruka' => 'Uspjesno']);
    }
}
