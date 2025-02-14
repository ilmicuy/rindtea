<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use App\Services\FonnteService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        // Send Welcome Email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        // Prepare the WhatsApp message
        $message = "*Selamat Datang di Rind Tea!*" . "\n\n" .
            "Selamat Datang, " . $user->name . "!" . "\n\n" .
            "Terimakasih sudah melakukan registrasi di website Rind Tea. Kini anda dapat melakukan pemesanan produk Rind Tea melalui website: https://rindtea.biz.id/." . "\n\n" .
            "Hormat Kami,\n" .
            "*Tim Rind Tea*";

        // Send the WhatsApp message using FonnteService (or your preferred service)
        $fonnteService = new FonnteService();
        $fonnteService->sendMessage($user->phone_number, $message);
    }
}
