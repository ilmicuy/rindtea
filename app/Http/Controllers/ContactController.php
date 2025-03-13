<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function submitForm(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        // Send email
        Mail::to('rindteasemarang@gmail.com')->send(new ContactFormMail($validated));

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim!'
        ]);
    }
}
