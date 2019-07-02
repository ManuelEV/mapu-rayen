<?php

namespace App\Http\Controllers;

use App\Item_log;
use Illuminate\Http\Request;

class ItemLogController extends Controller
{
    public function getItemLogs(Request $request)
    {

        $item_logs = Item_log::select('item_logs.id', 'item_logs.item_id', 'item_logs.description', 'item_logs.emision')
            ->where('item_logs.item_id', $request->id)
            ->orderBy('item_logs.id', 'desc')
            ->get();
        return [
            'item_logs' => $item_logs
        ];

    }
}
