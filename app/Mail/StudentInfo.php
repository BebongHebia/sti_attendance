<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentInfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $student_data;
    public function __construct($student_data)
    {
        $this->student_data = $student_data;
    }

    /**
     * Get the message envelope.
     */

     public function build()
     {
         return $this->subject('STI MALAYBALAY STUDENT EVENT ATTENDANCE SYSTEM')
                     ->view('mails.student_info')
                     ->with('student_data', $this->student_data);
     }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Student Information',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.student_info',
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
