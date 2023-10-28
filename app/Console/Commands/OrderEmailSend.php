<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Price;
use Illuminate\Support\Str;
use App\Mail\OrderPlaceMail;
use App\Mail\InvoiceMail;
use App\Mail\SendAdminEmail;
use File;
use App;
use Mail;

class OrderEmailSend extends Command
{

    protected $signature = 'order:email';

    protected $description = 'Send order create email notification for admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $orders = DB::table('requests')->where('admin_email_sent', 'no')->orwhere('order_email_sent', 'no')->get();
        $record_id = 0;
        $html="";

        foreach($orders as $order){

            if($order->order_email_sent == 'no')
            {
                if($order->status == 'DEFERRED PAYMENT')
                {
                    Mail::to($p->contact_email)->send(new InvoiceMail(base64_decode($id),'defferd'));
                }
                else{
                    if($order->payment_method == 'Credit Card'){
                        Mail::to($request->email)->send(new OrderPlaceMail($request->order_number, 'stripe'));
                    }
                    else{
                        Mail::to($order->contact_email)->send(new OrderPlaceMail($order->order_number));
                    }
                }
            }
            
            if($order->admin_email_sent == 'no')
            {
                $html = '<p>Hello,</p><p> More one order was placed, please check it out.</p><p>Order number: ' . $order->order_number;
                $job = (new \App\Jobs\SendAdminEmail(config('mail.mailers.smtp.username'), $html));
                
                dispatch($job);
            }

            $cur_order = Price::find($order->id);
            $cur_order->order_email_sent = 'yes';
            $cur_order->admin_email_sent = 'yes';
            $cur_order->save();
        }
       
    }

}

