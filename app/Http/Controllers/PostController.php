<?php

namespace App\Http\Controllers;
use App\Mail\ObavijestONovomPostu;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function addPost(Request $request)
    {

        $data = $request->validate(
            [
                'group_id' => 'required',
                'tema' => 'required',
                'sadrzaj' => 'required',


            ],
            [
                'ime.required' => "Ime je obavezno",
                'tema.required' => "Prezime je obavezno ",
                'sadrzaj.required' => 'Email je obavezan',


            ]
        );


        $post = new Post();
        $data['user_id'] = auth()->id();
        $post->create($data);
        $recipients = ['marinzilic507@gmail.com'];
        foreach ($recipients as $recipient) {
            Mail::mailer('smtp')->to($recipient)->send(new ObavijestONovomPostu($post));
        }
        return response()->json(['poruka' => 'Uspjesno']);
    }
}
