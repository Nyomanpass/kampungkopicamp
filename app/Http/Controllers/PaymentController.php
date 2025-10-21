<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function show($token, Request $request){
        $booking = Booking::where('booking_token', $token)->firstOrFail();
        $snapToken = $request->get('snap_token');

        return view('payment.show', compact('booking', 'snapToken'));
    }

    public function webhook(Request $request)
    {
        $notification = $request->all();
        $result = $this->paymentService->handleNotification($notification);

        return response()->json($result);
    }

    public function finish($token)
    {
        $booking = Booking::where('booking_token', $token)->firstOrFail();

        return view('payment.finish', compact('booking'));
    }
}
