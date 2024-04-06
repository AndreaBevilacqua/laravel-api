<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function message()
    {

        $mail = new ContactMessageMail();
        Mail::to(env('MAIL_TO_ADDRESS'))->send($mail);

        return response()->json(null, 204);
    }
}
