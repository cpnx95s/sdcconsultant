<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class contactus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contact = DB::table('tb_contact')->Where('id', 1)->first();
        $this->subject($this->data['subject'])
       ->from('test@cw.co.th') 
       ->to($contact->email)
       ->markdown('emails.contactus')->with([
           'name' => $this->data['name'],
           'email' => $this->data['email'],
           'phone' => $this->data['phone'],
           'message' => $this->data['message'],
          
       ]);
  
    }
}
