<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\WhatsAppService;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    private $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    // Show verification form
    public function showVerifyForm()
    {
        return view('whatsapp.verify');
    }

    //Send otp
    public function sendOtp(Request $request)
    {
        $request->validate([
            'country_code' => ['required', 'regex:/^\+\d{1,4}$/'],
            'local_number' => ['required', 'regex:/^\d{6,15}$/'],
        ]);

        // Clean up the phone number
        $formattedNumber = preg_replace('/[\s()-]/', '', $request->whatsapp_number); // remove spaces, dashes, brackets

        // Remove extra zero after country code (e.g., +880017... => +88017...)
        $formattedNumber = preg_replace('/^(\+\d{1,4})0/', '$1', $formattedNumber);

        dd($formattedNumber);

        $otp = rand(100000, 999999);
        Session::put('whatsapp_otp', $otp);
        Session::put('whatsapp_number', $formattedNumber);

        $whatsappService = new WhatsAppService();
        $response = $whatsappService->sendMessage($formattedNumber, "Your OTP is: $otp");

        if ($response && isset($response['status']) && $response['status'] == 'success') {
            return back()->with('success', 'OTP sent successfully.');
        } else {
            return back()->with('error', 'Failed to send OTP. Response: ' . json_encode($response));
        }
    }



    // Verify OTP

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if ($request->otp == Session::get('whatsapp_otp')) {
            $user = auth()->user();

            // Update the existing phone record or create a new one
            $user->phone()->updateOrCreate(
                [], // No condition needed, since each user should have only one phone record
                [
                    'phone' => Session::get('whatsapp_number'),
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            );

            Session::forget(['whatsapp_otp', 'whatsapp_number']);

            return redirect()->back()->with('success', 'WhatsApp verified successfully.');
        } else {
            return back()->with('error', 'Invalid OTP. Try again.');
        }
    }

    // Send message from Mikrotik
    public function sendFromMikrotik(Request $request)
    {
        $request->validate([
            //  'phone' => 'required|regex:/^\+\d{1,4}\d{6,15}$/', // Adjust regex as per your requirements
            'message' => 'required|string|max:4096',
            '_token' => 'required|string',
        ]);

        //  $phone = $request->input('phone');
        $message = $request->input('message');
        $token = $request->input('_token');
        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $phone = '+8801717050046'; // Replace with the actual phone number you want to send the message to
        if (!$phone) {
            return response()->json(['error' => 'Phone number not found.'], 404);
        }
        $whatsappService = new WhatsAppService();

        $response = $whatsappService->sendMessage($phone, $message);

        if ($response && isset($response['status']) && $response['status'] == 'success') {
            return response()->json(['success' => 'Message sent successfully.']);
        } else {
            return response()->json(['error' => 'Failed to send message. Response: ' . json_encode($response)], 500);
        }
    }
}
