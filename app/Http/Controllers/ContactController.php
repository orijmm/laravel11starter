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
        $msg = 'Tu mensaje fue enviado correctamente.';
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'email' => 'required|email:rfc,dns',
            'message'    => 'required|string',
            'phone'    => 'required|string',
            'company'    => 'required|string',
        ]);

        // Guardamos en la base de datos
        $emailRecord = SentEmail::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'subject' => 'Formulario de contacto: ' . $request->type
        ]);

        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))
                ->cc($validated['email'])
                ->send(new ContactFormMail($validated));
        } catch (\Exception $e) {
            $emailRecord->update(['was_sent' => false]);
            $msg = 'Ocurrió un error al intentar enviar el correo, intente nuevamente.';
        }

        return $this->responseSuccess($msg);
    }
}
