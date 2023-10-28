<?php
namespace App\Http\Controllers;
use App\Mail\ThankYouMessage;
use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;

class MailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('contact');
    }
    public function contact(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'message' => 'required|string',
            'CaptchaCode' => 'required|valid_captcha'
        ]);
        if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        \Illuminate\Support\Facades\Mail::to($email)->send(new ThankYouMessage($name, $email));
        \Illuminate\Support\Facades\Mail::to('info@easymoveeurope.com')->send(new ThankYouMessage($name, config('mail.mailers.smtp.username'), ['email' => $email, 'subject' => $request->subject, 'message' => $request->message]));
        $request->flush();
        return redirect()->route('contact')->with('success', 'Thank you for your message!');
    } 
}
