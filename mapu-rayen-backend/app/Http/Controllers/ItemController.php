<?php

namespace App\Http\Controllers;

use App\Category;
use App\Enterprise;
use App\Item;
use App\Item_log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;

class ItemController extends Controller
{
    public function index()
    {

        $items = Item::select('items.id', 'items.name', 'items.value', 'items.stock')
            ->orderBy('items.id', 'desc')->get();

        return [
            'items' => $items,
        ];
    }


    public function store(Request $request)
    {
        $item = new Item();
        $item->name = $request->name;
        $item->value = $request->value;
        $item->stock = $request->stock;
        $item->save();

        return ['status' => 'OK'];
    }

    public function update(Request $request)
    {


        $item = Item::findOrFail($request->id);

        $this->addItemLog($request->id, 'Actualización de artículo');

        $item->name = $request->name;
        $item->value = $request->value;
        $item->inventoriable = $request->inventoriable;
        $item->category_id = $request->category_id;
        $item->enterprise_id = $request->enterprise_id;
        $item->save();
        return ['status' => 'OK'];
    }

    public function delete(Request $request, $id)
    {

        $item = Item::findOrFail($id)->delete();
        return ['status' => 'OK'];
    }


    public function getItems(Request $request)
    {

        $items = Item::select('items.id', 'items.name', 'items.value')
            ->orderBy('items.id', 'desc')->get();

        return $items;
    }

    //Útil para hacer gráficas de resumen
    public function inventorySummary()
    {
        $countItems = Item::get()->count();
        $countCategories = Category::get()->count();
        $countEnterprises = Enterprise::get()->count();
        return [
            'items' => $countItems,
            'categories' => $countCategories,
            'enterprises' => $countEnterprises
        ];
    }

    //de momento no se usa este método
    public function getItemCodes()
    {
        $items = Item::select('items.code')->get();
        $codes = array();

        foreach ($items as &$item) {
            if (!in_array($item->code, $codes)) {
                array_push($codes, $items->code);
            }
        }

        return [
            'item_codes' => $codes
        ];
    }

    public function assignSupervisor(Request $request)
    {

        $item = Item::findOrFail($request->id);

        if ($request->assigned) {
            $this->addItemLog($request->id, 'Salida de artículo');
            $item->supervisor = $request->supervisor;
        } else {
            $this->addItemLog($request->id, 'Llegada de artículo');
            $item->supervisor = null;
        }

        $item->save();
        return ['status' => 'OK'];
    }

    private function addItemLog($id, $description)
    {
        $item_logs = new Item_log();

        $item_logs->item_id = $id;
        $item_logs->description = $description;
        $now = Carbon::now();
        $now->toTimeString();
        $item_logs->emision = $now;
        $item_logs->save();
    }

}
