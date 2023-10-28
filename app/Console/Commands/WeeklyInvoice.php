<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\ExtraCharges;
use Illuminate\Support\Str;
use File;
use App;
use PDF;
use Mail;

class WeeklyInvoice extends Command
{

    protected $signature = 'weekly:invoice';

    protected $description = 'Send per week invoices';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $customers = DB::table('users')->where('invoice_type', 'Per Week')->get();

        $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));

       
        foreach($customers as $customer)
        {
            $orders = DB::table('requests')->where('status', 'PAID')->whereNull('invoice_id')->orwhere('invoice_id',0)->where('user_id', $customer->id)->get();
    
            $record_id = 0;
            $html="";
            $vat = "0%";
            $vat_amount = "0.00";
            $to_email = $customer->email;

          //  $html .= "<p>Dears,</p><p>We would like to confirm the following invoice(s) is pending.</p>";
            
            foreach($orders as $order)
            {
                $struid = Str::uuid();
                $invoice = new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Invoice';
                $invoice->order_id= $order->id;
                $invoice->extra_charge_id= 0;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $order->price??0;
                $invoice->status = 'Waiting Payment';
                $invoice->save();

                $invoice_id = $invoice->id;

                $cur_order = Price::find($order->id);
                $cur_order->invoice_id = $invoice_id;
                $cur_order->save();

                if($customer->valid_vat == 0){
                    $vat = "19%";
                    $vat_amount = number_format(($order->price - ($order->price/1.19)), 2 , ".");
                }
                
                $str_invoice_no = $invoice_id;

                if($invoice_id < 10){
                    $str_invoice_no = "0000" . $invoice_id;
                }
                if($invoice_id >= 10 && $invoice_id < 100){
                    $str_invoice_no = "000" . $invoice_id;
                }
                if($invoice_id >= 100 && $invoice_id < 1000){
                    $str_invoice_no = "00" . $invoice_id;
                }
                if($invoice_id >= 1000 && $invoice_id < 10000){
                    $str_invoice_no = "0" . $invoice_id;
                }

                if($record_id > 0){
                    $html .= '<div style="width: 100%; height:2px; page-break-before: always;"></div>';
                }

                $html .= '<div style="width: 100%;">
                <div style="max-width: 630px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="' . $logoimage . '" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;"><td style="width:65%; padding:4px;">
                                Strada Feleacu 3,<br />
                                077190 Bucharest,<br />
                                Romania.<br />
                                VAT: RO47795949<br />
                                </td>
                                <td style="width:55%; padding:4px; font-weight:600;"><span style=" font-weight:600;">' . $customer->company_name . '</span><br />' . $customer->location . "<br />" . $customer->city . '<br />' . $customer->company_country . '<br />' . $customer->vat_name . '</td>
                            </tr>
                        </table>
                        
                        <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:50px;">
                            <tr>
                                <td style="padding:4px; background-color:#000;"></td>
                                <td colspan="5" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">INV-'. $str_invoice_no .'</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Invoice/Bill Date:</td>
                                <td style="padding:4px;">Due Date:</td>
                                <td colspan="2" style="padding:4px;">Service date:</td>
                                <td colspan="2" style="padding:4px;">Payment type:</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td colspan="2" style="padding:4px;">'. date("d/m/Y", strtotime($order->collection_day)) .'</td>
                                <td colspan="2" style="padding:4px;">Deferred payment</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service ' . $order->pickup_country . ' - ' . $order->desti_country . '</td>
                                <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . ($order->price - $vat_amount) . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:center;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $order->price . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; border-bottom:1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">Sub Total</td>
                                <td style="padding:4px; text-align:right;">' . ($order->price - $vat_amount) . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                                <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                                <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">' . $order->price .' &euro;</td>
                             </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV- ' . $str_invoice_no . ' / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';

            $record_id++;
        }
               if($record_id > 0)
                {

                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML($html);
                    $file_name = 'invoice_' . $customer->id . '_' .  date('dmY') . '.pdf';

                    $path = storage_path('invoices/') . $file_name;
            
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                   
                    $pdf->save($path);

                    
                    $fileContents = base64_encode(File::get($path));

                    $html2 = "<p>Dears, </p><p>Your weekly invoices attached with this email</p>";
                    $html2 .= "<p style='padding:15px 5px;'>If you have any questions or need to make any changes, do not hesitate to contact us.</p>";
                    $html2 .= "<p style='padding:15px 5px;'>Phone: +40 317 801 214 || <a href='mailto:info@easymoveeurope.com'>info@easymoveeurope.com</a></p>";

                    Mail::html($html2, function($message) use($to_email, $fileContents, $file_name){
                        $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                        $message->to($to_email);
                        $message->subject('Weekly Invoices');
                        $message->attachData(base64_decode($fileContents), $file_name);
                    });
                }

        }
    }

}

