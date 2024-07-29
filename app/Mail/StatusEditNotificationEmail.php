<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusEditNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $modelRequest;
    public $statusName;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param $ingredientRequest
     * @param $statusName
     * @param $user
     */
    public function __construct($type, $modelRequest, $statusName, $user)
    {
        $this->type = ($type == 'request_product' ? 'Request Produk' : 'Request Bahan Baku');
        $this->modelRequest = $modelRequest;
        $this->statusName = $statusName;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->type .' Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.requestStatusUpdateEmail',
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
