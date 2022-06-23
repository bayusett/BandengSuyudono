<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Product;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        //save user data
        $user = Auth::guard('customer')->user();
        $user->update($request->except('total_price'));

        //proses checkout
        $length = 5;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(
                ord('a'),
                ord('z')
            ));
        }
        $now = Carbon::now();
        $monthyear = $now->year . $now->month;
        $cek = Transaction::count();
        $order = TransactionDetail::count();
        //penomoran otomatis pembayaran
        if ($cek == 0 || date('l', strtotime(date('Y-01-01')))) {
            $urut = 0000001;
            $code = 'INV-' . Str::upper($random) . $monthyear . $urut;
        } else {
            $get = Transaction::all()->last();
            $urut = (int)substr($get->code, -7) + 1;
            $code = 'INV-' . Str::upper($random) . $monthyear . $urut;
        }
        //penomoran otomatis pemesanan
        if ($order == 0 || date('l', strtotime(date('Y-01-01')))) {
            $urut = 0000001;
            $trx = 'TRX-' . Str::upper($random) . $monthyear . $urut;
        } else {
            $get = TransactionDetail::all()->last();
            $urut = (int)substr($get->code, -7) + 1;
            $trx = 'TRX-' . Str::upper($random) . $monthyear . $urut;
        }

        $payment = Transaction::create([
            'customers_id' => Auth::guard('customer')->user()->id,
            'no_invoice' => $code,
            'total_price' => $request->total_price,
            'payment_status' => 'PENDING',
            'transaction_status' => 'PENDING',
        ]);

        //penyimpanan data order
        $item = Cart::where('customers_id', Auth::guard('customer')->user()->id)->get();
        foreach ($item as $carts) {
            $payment->TransactionDetails()->create([
                'transactions_id' => $payment->id,
                'products_id' => $carts->products_id,
                'qty' => $carts->qty,
                'code' => $trx,
                'notes' => $request->notes,
            ]);
            //update data stock produk
            $stock = Product::where('id', $carts->products_id)->first();
            if ($stock) {
                $update = $stock->qty - (int) $carts->qty;
                $stock->update(['qty' => $update]);
            }
        }



        //hapus setelah checkout
        Cart::where('customers_id', Auth::guard('customer')->user()->id)->delete();
        //konfigurasi midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('services.midtrans.is3ds');

        //buat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
                'biaya admin' => 5000,
            ],
            'customer_details' => [
                'first_name' => Auth::guard('customer')->user()->name,
                'email' => Auth::guard('customer')->user()->email,
            ],
            'enabled_payments' => [
                "credit_card",
                "cimb_clicks",
                "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
                "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret",
                "danamon_online", "akulaku", "shopeepay"
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        // $snapToken = Snap::getSnapToken($midtrans);
    }
    public function callback(Request $request)
    {
        //set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //instance midtrans notofication
        $notification  = new Notification();

        //asign ke variable untuk memudahkan

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //cari transksi berdasarkan id

        $transaction = Transaction::where('no_invoice', $order_id)->first();


        //handle notification status
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->update([
                        'payment_status' => 'PENDING'
                    ]);
                } else {
                    $transaction->update([
                        'payment_status' => 'SUCCESS'
                    ]);
                }
            }
        } else if ($status == 'settlement') {
            $transaction->update([
                'payment_status' => 'SUCCESS'
            ]);
        } else if ($status == 'pending') {
            $transaction->update([
                'payment_status' => 'PENDING'
            ]);
        } else if ($status == 'deny') {
            $transaction->update([
                'payment_status' => 'FAILED'
            ]);
        } else if ($status == 'expire') {
            $transaction->update([
                'payment_status' => 'EXPIRED'
            ]);
        } else if ($status == 'cancel') {
            $transaction->update([
                'payment_status' => 'CANCEL'
            ]);
        }

        // Simpan transaksi
        $transaction->save();

        // Kirimkan email
        if ($transaction) {
            if ($status == 'capture' && $fraud == 'accept') {
                //
            } else if ($status == 'settlement') {
                //
            } else if ($status == 'success') {
                //
            } else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }
}
