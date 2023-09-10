<?php

namespace App\Http\Controllers;

use App\Mail\ObavijestONovomPostu;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function addPost(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required',
            'tema' => 'required',
            'sadrzaj' => 'required',
        ]);


        $post = new Post();
        $post->group_id = $data['group_id'];
        $post->tema = $data['tema'];
        $post->sadrzaj = $data['sadrzaj'];
        $post->user_id = auth()->id();
        $post->save();
        $recipients = User::pluck('email')->toArray();



        foreach ($recipients as $recipient) {
            Mail::mailer('smtp')->to($recipient)->send(new ObavijestONovomPostu($post));
        }

        return response()->json(['poruka' => 'Uspješno dodan post']);
    }

    public function getPost($id){

        $post = Post::with('user','group')->where('group_id',$id)->get();

        return response()->json($post);
    }

    public function izbrisiPost($id){

        $grupa = Post::findorFail($id);
        $grupa->delete();
        return response()->json(['poruka' => 'Uspjesno']);
    }
}
