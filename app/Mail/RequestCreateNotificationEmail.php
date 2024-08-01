<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestCreateNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $modelRequest;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param $ingredientRequest
     * @param $statusName
     * @param $user
     */
    public function __construct($type, $modelRequest, $user)
    {
        $this->type = ($type == 'request_product' ? 'Request Produk' : 'Request Bahan Baku');
        $this->modelRequest = $modelRequest;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terdapat ' . $this->type .' Baru',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.requestCreateEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
