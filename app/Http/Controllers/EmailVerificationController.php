<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class EmailVerificationController extends Controller
{
    public function verify()
    {
        return view('emails.verify');
    }

    public function sendEmailOTP()
    {
        $user = Auth::user();
        $otp = rand(100000, 999999);

        // Ensure $user is an instance of User before saving
        if ($user instanceof \App\Models\User) {
            $user->email_otp = $otp;
            $user->save();
        }
        // Generate verification URL
        $verifyUrl = url('/verify/email-link?otp=' . $otp);
        // Send email using Mailtrap
        Mail::send('emails.otp-template', ['otp' => $otp, 'verifyUrl' => $verifyUrl], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Khetibook Email Verification OTP');
        });

        return back()->with('success', 'OTP sent to your email.');
    }

    public function verifyEmailOTP(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $user = Auth::user();

    if ($user instanceof \App\Models\User && $user->email_otp == $request->otp) {
        $user->email_verified = true;
        $user->email_otp = null;
        $user->save();

        $this->checkIfFullyVerified($user); // check if both verifications are done

        return back()->with('success', 'Email successfully verified!');
    }

    return back()->with('error', 'Invalid OTP. Please try again.');
}



public function sendNumberOTP(Request $request)
{
    $request->validate([
        'phone_number' => 'required|numeric',
    ]);



    $user = Auth::user();

    if (!$user) {
        return back()->with('error', 'User not authenticated.');
    }

    // Optional: check if entered number matches user record
    if ($user->phone_number != $request->phone_number) {
        return back()->with('error', 'Entered number does not match your registered number.');
    }

    $otp = rand(100000, 999999);
    $user->number_otp = $otp;
    $user->otp_sent_at = now();
    if ($user instanceof \App\Models\User) {
        $user->save();
    }

    $sid    = env('TWILIO_SID');
    $token  = env('TWILIO_AUTH_TOKEN');
    $from   = env('TWILIO_PHONE');

    $to = $request->phone_number;
    if (!str_starts_with($to, '+')) {
        $to = '+91' . ltrim($to, '0');
    }

    // if ($user->otp_sent_at && now()->diffInSeconds(\Carbon\Carbon::parse($user->otp_sent_at)) < 60) {
    //     $elapsed = now()->diffInSeconds(\Carbon\Carbon::parse($user->otp_sent_at));
    //     $remaining = 60 - $elapsed;
    //     return back()->with('error', "Please wait {$remaining} seconds before requesting another OTP.");
    // }

    try {
        $twilio = new Client($sid, $token);
        $twilio->messages->create($to, [
            'from' => $from,
            'body' => "Your OTP for KhetiBook is $otp"
        ]);

        return back()->with(['success' => 'OTP sent to your number.']);
    } catch (\Exception $e) {
        return back()->with(['error' => 'Failed to send OTP.']);
    }
}



   public function verifyNumberOTP(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $user = Auth::user();

    // Check OTP expiration first
    if (now()->diffInMinutes($user->otp_sent_at) > 5) {
        return back()->with('error', 'OTP expired. Please request a new one.');
    }

    if ($user->number_otp == $request->otp) {
        $user->number_verified = true;
        $user->number_otp = null; // clear OTP
        $user->otp_sent_at = null;

        if ($user instanceof \App\Models\User) {
            $user->save();
        }

        // Optional: Check if both email and number are verified
        $this->checkIfFullyVerified($user);

        Flasher::addSuccess('Phone number verified successfully!');
        return redirect()->back();
    }

    Flasher::addError('Invalid OTP. Please try again.');
    return redirect()->back();
    }


    public function verifyEmailByLink(Request $request)
{
    $otp = $request->query('otp');
    $user = Auth::user();

    if ($user && $user->email_otp == $otp) {
        $user->email_verified = true;

        // Check if phone number is already verified
        if ($user->number_verified) {
            $user->user_verified = true; // Now both are verified
        }

        if ($user instanceof \App\Models\User) {
            $user->save();
        }

        return redirect()->back()->with('success', 'Email verified successfully!');
    }

    return redirect()->back()->withInput()->with('error', 'Invalid or expired OTP.');
}



   private function checkIfFullyVerified($user)
{
    if ($user->email_verified && $user->number_verified) {
        $user->user_verified = true;
        $user->save();
    }
}
}
