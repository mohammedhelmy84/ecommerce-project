<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;


class CustomerController extends Controller
{


    public function index()
    {
        $customers = User::where('role','customer')->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
      //
    }



    public function show(User $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }


    public function edit(User $customer)
    {
        //
    }


    public function update(Request $request, User $customer)
    {
       //
    }


    public function destroy(User $customer)
    {
       //
    }

    public function print(User $customer)
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'amiri',
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        $html = view('admin.customers.pdf', compact('customer'))->render();

        $mpdf->WriteHTML($html);
       // $mpdf->Output('customer.pdf', 'I'); // عرض مباشر
        // تحميل مباشر
        return $mpdf->Output('customer_' . $customer->id . '.pdf', Destination::DOWNLOAD);

        // حفظ على السيرفر
       // $mpdf->Output(storage_path('app/public/customer.pdf'), Destination::FILE);

    }


}
