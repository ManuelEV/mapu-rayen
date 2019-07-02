<?php

namespace App\Http\Controllers;

use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {

        $sales = Sale::select('sales.id', 'sales.subtotal', 'sales.total', 'sales.discount', 'sales.sale_date','sales.product_list')
            ->orderBy('sales.id', 'desc')->get();

        return [
            'sales' => $sales,
        ];
    }


    public function store(Request $request)
    {
        $sale = new Sale();
        $sale->subtotal = $request->subtotal;
        $sale->total = $request->total;
        $sale->discount = $request->discount;

        $product_list = $request->selectedItems;
        $sale->product_list = $product_list;

        $now = Carbon::now();
        $now->toTimeString();

        $sale->sale_date = $now;
        $sale->save();

        return ['status' => 'OK'];
    }
}
