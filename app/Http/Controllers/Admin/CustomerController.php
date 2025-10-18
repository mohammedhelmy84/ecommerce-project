<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
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
        $customers = Customer::latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'تم إضافة العميل بنجاح');
    }



    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }


    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }


    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('customers.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'تم حذف العميل بنجاح');
    }

    public function print(Customer $customer)
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
