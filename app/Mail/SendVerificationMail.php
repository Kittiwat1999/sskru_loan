<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendVerificationMail extends Mailable
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
            subject: 'Register Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification',
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
        return $this->subject('รหัสยืนยันสำหรับการเข้าสู่ระบบ')
                    ->from('sskru_loan@gmail.com', 'SSKRU-Loan')
                    ->view('emails.verification')
                    ->with([
                        'code' => $this->code,
                        'companyName' => 'SSKRU-Loan',
                        'supportEmail' => 'chawalit1907@gmail.com',
                    ]);
    }
}
