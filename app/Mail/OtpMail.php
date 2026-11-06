<?php

namespace App\Mail;

use App\Models\Pengguna;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OtpMail extends Mailable
{
    public function __construct(
        public Pengguna $user,
        public string $kode,
        public string $tujuan,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->tujuan === 'reset_password'
                ? 'Kode OTP Reset Password SCP'
                : 'Kode Verifikasi Email SCP',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp');
    }
}
