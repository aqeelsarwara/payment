<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Payment; // Import the Payment model


class PaymentController extends Controller
{
    //
    public function createPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment Description',
            ]);

            return $this->storePayment($charge);
            // return response()->json(['success' => 'Payment successful!', 'charge' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
// new function

public function storePayment(Charge $charge)
{
    $payment = Payment::create([
        'charge_id' => $charge->id,
        'amount' => $charge->amount/100,
        'currency' => $charge->currency,
        'status' => $charge->status,
        'payment_method' => $charge->payment_method,
        'receipt_url' => $charge->receipt_url,
        'postal_code' => $charge->billing_details->address->postal_code,
    ]);

    return response()->json(['success' => 'Payment stored successfully!', 'payment' => $payment], 200);
}

}
