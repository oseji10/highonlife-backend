<?php

namespace App\Mail;

use App\Models\LivingRoomRegistration;
use App\Services\TicketService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LivingRoomRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LivingRoomRegistration $registration)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'re Registered — The Living Room Conversation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.living-room-confirmation',
            with: [
                'registration' => $this->registration,
            ],
        );
    }

    public function attachments(): array
    {
        $ticketService = app(TicketService::class);

        $qrDataUri = $ticketService->qrDataUri($this->registration->reference_number);

        $pdfBytes = $ticketService->pdf('tickets.living-room', [
            'registration' => $this->registration,
            'qrDataUri' => $qrDataUri,
        ]);

        return [
            Attachment::fromData(fn () => $pdfBytes, "ticket-{$this->registration->reference_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}