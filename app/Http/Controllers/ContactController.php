<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendEmailRequest;
use App\Mail\UserSendEmail;
use App\User;
use App\Helpers\Helper;

class ContactController extends Controller
{
    public function contact() 
    {
        return view('contact');
    }

    public function postContact(SendEmailRequest $request)
    {
        Helper::handleRecaptchaVerification($request);

        $data = $request->only(['your-name', 'your-email', 'your-subject', 'your-message']);
        
        $user = User::role('admin')->get();
        
        $response = [
            'status' => 'success', 
            'message' => 'Your email has successfully been send.'
        ];

        try {
            Mail::to($user)->send(new UserSendEmail($data));
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        return redirect()->route('contact')->with($response['status'], $response['message']);
    }

}
