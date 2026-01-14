<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Handle Midtrans webhook callback.
     */
    public function midtransCallback(Request $request)
    {
        $payload = $request->all();

        // Basic signature validation when provided
        $signature = $payload['signature_key'] ?? null;
        $serverKey = config('services.midtrans.server_key');
        if ($signature && $serverKey) {
            $check = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);
            if (! hash_equals($check, $signature)) {
                Log::warning('Midtrans signature mismatch', $payload);
                return response()->json(['message' => 'Invalid signature'], 400);
            }
        }

        $orderId = $payload['order_id'] ?? null;
        if (! $orderId) {
            return response()->json(['message' => 'Missing order_id'], 400);
        }

        $fee = StudentFee::where('INVOICE_CODE', $orderId)->first();
        if (! $fee) {
            Log::warning('Midtrans callback invoice not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? 'pending';
        $paymentType = $payload['payment_type'] ?? null;
        $grossAmount = (float) ($payload['gross_amount'] ?? 0);
        $midtransTxnId = $payload['transaction_id'] ?? ($payload['fraud_status'] ?? Str::uuid()->toString());

        $statusMap = [
            'capture' => 'Paid',
            'settlement' => 'Paid',
            'pending' => 'Unpaid',
            'deny' => 'Failed',
            'expire' => 'Overdue',
            'cancel' => 'Cancelled',
        ];
        $fee->STATUS = $statusMap[$transactionStatus] ?? 'Unpaid';
        $fee->MIDTRANS_ORDER_ID = $payload['order_id'];
        $fee->save();

        Payment::create([
            'ID_STUDENT_FEE' => $fee->ID_STUDENT_FEE,
            'PAID_AMOUNT' => $grossAmount,
            'PAID_AT' => now(),
            'METHOD' => $paymentType,
            'MIDTRANS_TXN_ID' => $midtransTxnId,
            'STATUS' => $fee->STATUS,
            'RAW_PAYLOAD' => $payload,
        ]);

        return response()->json(['message' => 'ok']);
    }
}
