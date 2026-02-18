<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class BookingApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@labwicida.com', 'Lab WICIDA - Sistem Jadwal'),
            replyTo: [
                new Address($this->booking->user->email, $this->booking->user->name),
            ],
            subject: '✅ Booking Konsultasi DISETUJUI - ' . $this->booking->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.booking-approved',
            with: [
                'booking' => $this->booking,
                'dosen' => $this->booking->user,
                'url' => route('dosen.show', $this->booking->user_id),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
