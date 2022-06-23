<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use PDF;

class GenerateLaporanController extends Controller
{
    public function laporandates()
    {
        $from = Request()->input('from');
        $until = Request()->input('until');
        $result = TransactionDetail::whereBetween('created_at', [$from, $until])->get();


        $pdf = PDF::loadview('pdf.viewlaporanpenjualan', [
            'penjualan' => $result,
            'from' => $from,
            'until' => $until,
        ]);
        return $pdf->stream('transaction.pdf');
    }

    public function alllaporan()
    {
        $result = TransactionDetail::all();


        $pdf = PDF::loadview('pdf.viewlaporan', [
            'penjualan' => $result,
        ]);
        return $pdf->stream('laporantakeall.pdf');
    }

    public function pesananrequest()
    {
        $from = Request()->input('from');
        $until = Request()->input('until');
        $result = Transaction::whereBetween('created_at', [$from, $until])->get();


        $pdf = PDF::loadview('pdf.viewlaporanpesanan', [
            'penjualan' => $result,
            'from' => $from,
            'until' => $until,
        ]);
        return $pdf->stream('pesanan.pdf');
    }


    public function pesananall()
    {
        $result = Transaction::all();


        $pdf = PDF::loadview('pdf.viewlaporanall', [
            'penjualan' => $result,
        ]);
        return $pdf->stream('laporantakeall.pdf');
    }

    public function productrequest()
    {
        $from = Request()->input('from');
        $until = Request()->input('until');
        $result = Product::whereBetween('created_at', [$from, $until])->get();

        return view('pages.laporanpdf', [
            'from' => $from,
            'until' => $until,
            'product' => $result,
        ]);
    }
    public function productall()
    {
        $result = Product::all();

        return view('pages.laporanpdfall', [
            'product' => $result,
        ]);
    }

    public function customerrequest()
    {
        $from = Request()->input('from');
        $until = Request()->input('until');
        $result = Customer::whereBetween('created_at', [$from, $until])->get();


        $pdf = PDF::loadview('pdf.viewlaporancustomerrequest', [
            'customer' => $result,
            'from' => $from,
            'until' => $until,
        ])->setpaper('A4', 'landscape');
        return $pdf->stream('reportcustomer.pdf');
    }

    public function customerall()
    {
        $result = Customer::all();


        $pdf = PDF::loadview('pdf.viewlaporancustomerall', [
            'customer' => $result,
        ])->setpaper('A4', 'landscape');
        return $pdf->stream('laporantakecustomerall.pdf');
    }
}
