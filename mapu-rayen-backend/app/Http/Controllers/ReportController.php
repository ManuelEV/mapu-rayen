<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemSale;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;


class ReportController extends Controller
{
    public function index()
    {

        $sales = Sale::select('sales.id', 'sales.subtotal', 'sales.total', 'sales.discount', 'sales.sale_date','sales.product_list')
            ->orderBy('sales.id', 'desc')->get();

        return [
            'sales' => $sales,
        ];
    }


    public function dateSetup(){
        $superior = Carbon::now();
        $superior->toTimeString();

        $inferior = Carbon::now();
        //addMonth -> añade n meses
        $inferior = $inferior->subMonth(6);
        $inferior->toTimeString();

        return [
            'dateSetup'=>[
                'inferior' => $inferior,
                'superior' => $superior
            ]
        ];

    }

    public function salesReport(Request $request){

        $from = $request->from;
        $to = $request->to;

        $superior = Carbon::now();
        $superior->toTimeString();

        $inferior = Carbon::now();
        //addMonth -> añade n meses
        //subMonth -> resta n meses
        $inferior = $inferior->subMonth(6);

        $inferior->toTimeString();

        $summary = Sale::selectRaw('sum(total) as total')
            ->selectRaw('sum(subtotal) as subtotal')
            ->selectRaw('avg(total) as average')
            ->selectRaw('count(total) as count')
            ->whereBetween('sale_date', [$from, $to])->get();

        $sales = Sale::select('total','sale_date')
        ->whereBetween('sale_date', [$from, $to])->get();

        $true_discount = Sale::selectRaw('count(discount) as count')
            ->where('discount','=',"1")
            ->whereBetween('sale_date', [$from, $to])
            ->get();
        $false_discount = Sale::selectRaw('count(discount) as count')
            ->where('discount','=',"0")
            ->whereBetween('sale_date', [$from, $to])
            ->get();

        return [
            'report'=>[
                'reportSummary' => $summary,
                'salesDetail' => $sales,
                'discount'=>[
                    'true' => $true_discount,
                    'false' => $false_discount
                ]
            ],
            'dateSetup'=>[
                'inferior' => $inferior,
                'superior' => $superior
            ]
        ];
    }

    public function productReport(Request $request){

        $from = $request->from;
        $to = $request->to;

        $items_id = ItemSale::select('item_sales.item_id')
            ->whereBetween('sale_date', [$from, $to])
            ->get();

        $items = array();

        foreach ($items_id as $id) {
            $item = Item::findOrFail($id);
            array_push($items, $item[0]->id .'-' .$item[0]->name);
        }

        $ocurrencias = array_count_values($items);

        return[
            'items' => $ocurrencias
        ];
    }

    public function salesVersus(){

        $meses = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $ventas = array();

        foreach ($meses as $mes) {
            $venta = Sale::selectRaw('avg(total) as total')
                ->selectRaw('sum(total) as subtotal')
                ->whereMonth('sale_date', '=', $mes)
                ->whereYear('sale_date', '=', '2019')
                ->get();

            array_push($ventas,$venta);
        }


        return [
            'ventas' => $ventas
        ];

    }

    public function reportByMonth(){

        $meses = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $ventas = array();

        foreach ($meses as $mes) {
            $venta = Sale::selectRaw('sum(total) as total')
                ->whereMonth('sale_date', '=', $mes)
                ->whereYear('sale_date', '=', '2019')
                ->get();

            array_push($ventas,$venta);
        }


        return [
            'ventas' => $ventas
        ];

    }

    public function discountByMonth(){
        $meses = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $con_descuento = array();
        $sin_descuento = array();

        foreach ($meses as $mes) {
            $venta_con = Sale::selectRaw('count(total) as con')
                ->where('discount', '=', 1)
                ->whereMonth('sale_date', '=', $mes)
                ->whereYear('sale_date', '=', '2019')
                ->get();

            $venta_sin = Sale::selectRaw('count(total) as sin')
                ->where('discount', '=', 0)
                ->whereMonth('sale_date', '=', $mes)
                ->whereYear('sale_date', '=', '2019')
                ->get();

            array_push($con_descuento,$venta_con);
            array_push($sin_descuento,$venta_sin);
        }


        return [
            'conDescuento' => $con_descuento,
            'sinDescuento' => $sin_descuento
        ];
    }

}
