<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemSale;
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

        $now = Carbon::now();
        $now->toTimeString();

        $sale->sale_date = $now;
        $sale->save();

        //$id_list = array();
        $id_list = $request->ids;
        foreach ($id_list as $id){
            $item_sale = new ItemSale();
            $item_sale->sale_id = $sale->id;
            $item_sale->item_id = $id;
            $item_sale->sale_date = $now;
            $item_sale->save();

            //Update stock
            $item = Item::findOrFail($id);
            $item->stock = $item->stock-1;
            $item->save();
        }

        return ['status' => 'OK'];
    }
}
