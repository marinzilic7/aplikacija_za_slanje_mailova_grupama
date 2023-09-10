<?php

namespace App\Http\Controllers;

use App\Models\Group;
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

        $existMember = Member::where('user_id', $data['user_id'])->where('group_id',$data['group_id'])->exists();
        if($existMember){
            return response()->json(['poruka' => 'Korisnik je clan grupe']);
        }

        $clan = new Member();
        $clan->create($data);
        return response()->json(['poruka' => 'Uspjesno']);
    }

    public function getMember(){

        $group = Member::with('user','group')->get();
        return response()->json($group);
    }

    public function getClan($id)
    {
        $member = Member::with('user')->where('group_id',$id)->get();
        return response()->json($member);
    }
}
