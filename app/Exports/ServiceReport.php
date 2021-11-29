<?php

namespace App\Exports;

use App\Models\OrderDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ServiceReport implements FromView
{
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    public function view(): View
    {
        $orderdetails = OrderDetail::with(['order', 'service',])
        ->where('status_order_detail', 'done')
        ->whereHas('service', function ($query) {
            $query->whereNotIn('service_category_id', [2, 7]);
        });
        if ($this->request->has('start_date') && $this->request->has('end_date')) {
            $orderdetails->where('created_at', '>=', $this->request->start_date . ' 00:00:00')
            ->where('created_at', '<=', $this->request->end_date . ' 23:59:59');
        }
        $orderdetails= $orderdetails->latest()->get();
        return view('exports.report_consumen', [
            'orderdetails' => $orderdetails,
        ]);
    }
   
}
