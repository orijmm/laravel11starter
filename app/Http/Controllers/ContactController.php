<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submitFormContact(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email',
            'message'    => 'required|string',
            'type'       => 'nullable|string|max:50',
        ]);

        // Guardamos en la base de datos
        $emailRecord = SentEmail::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'subject' => 'Formulario de contacto: '.$request->type
        ]);

        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactFormMail($validated));
        } catch (\Exception $e) {
            $emailRecord->update(['was_sent' => false]);
            // Puedes guardar también el error si deseas
        }

        return back()->with('success', 'Tu mensaje fue enviado correctamente.');
    }
}
