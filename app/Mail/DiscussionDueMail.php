<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiscussionDueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $viewName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($viewName, array $data)
    {
        $this->viewName = $viewName;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'])
                    ->view($this->viewName)
                    ->with($this->data);
    }
}
