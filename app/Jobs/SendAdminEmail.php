<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from_mail;
    protected $body;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from_mail, $body)
    {
       $this->from_mail=$from_mail;
       $this->body=$body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $from_mail = $this->from_mail;
        Mail::send("admin_email",['Body'=> $this->body], function($message) use($from_mail)
        {
            $message->from($from_mail, 'Easymoveeurope');
            $message->subject("Confirm Email");
            $message->to('info@easymoveeurope.com');
        }); 
     }

}
