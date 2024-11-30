<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $code;
    /**
     * Create a new message instance.
     */
    public function __construct( $code)
    {
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reset_password',
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

    public function build()
    {
        return $this->subject('รหัสยืนยันสำหรับแก้ไขรหัสผ่าน')
            ->from('sskru_loan@gmail.com', 'SSKRU-Loan')
            ->view('emails.reset_password')
            ->with([
                'code' => $this->code,
                'companyName' => 'SSKRU-Loan',
                'supportEmail' => 'chawalit1907@gmail.com',
            ]);
    }
}
