<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(ContactRequest $request)
    {
        Mail::to('cepharmusta@gmail.com')->send(new ContactMessage(
            $request->nom,
            $request->email,
            $request->sujet,
            $request->message
        ));

        session()->flash('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
        return redirect()->route('contact');
    }
}
