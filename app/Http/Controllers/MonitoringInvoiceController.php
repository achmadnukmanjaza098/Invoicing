<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringInvoiceController extends Controller
{
    public function monitoringInvoice()
    {
        return view('monitoring-invoice.list');
    }
}
