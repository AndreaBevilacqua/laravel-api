<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function message(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'sender' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required|string',
        ], [
            'sender.required' => 'L\'indirizzo email è obbligatorio',
            'sender.email' => 'L\'indirizzo email non è valido',
            'subject.required' => 'Il titolo è obbligatorio',
            'content.required' => 'Il contenuto è obbligatorio'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mail = new ContactMessageMail(
            subject: $data['subject'],
            sender: $data['sender'],
            content: $data['content']
        );
        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);

        return response()->json(null, 204);
    }
}
