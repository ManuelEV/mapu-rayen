<?php

namespace App\Http\Controllers;

use App\Enterprise;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function index(Request $request)
    {


        $filter = $request->filter;

        if ($filter == '') {
            $enterprises = Enterprise::select('enterprises.id', 'enterprises.name', 'enterprises.description', 'enterprises.email')
                ->orderBy('enterprises.id', 'desc')->paginate(5);
        } else {
            $enterprises = Enterprise::select('enterprises.id', 'enterprises.name', 'enterprises.description', 'enterprises.email')
                ->where('enterprises.name', 'like', "%$filter%")
                ->orWhere('enterprises.description', 'like', "%$filter%")
                ->orWhere('enterprises.id', 'like', "%$filter%")
                ->orderBy('enterprises.id', 'desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total' => $enterprises->total(),
                'current_page' => $enterprises->currentPage(),
                'per_page' => $enterprises->perPage(),
                'last_page' => $enterprises->lastPage(),
                'from' => $enterprises->firstItem(),
                'to' => $enterprises->lastItem(),
            ],
            'enterprises' => $enterprises
        ];
    }


    public function store(Request $request)
    {


        $enterprise = new Enterprise();
        $enterprise->name = $request->name;
        $enterprise->description = $request->description;
        $enterprise->email = 'hola@adios.cl';

        $enterprise->save();
        return ['status' => 'OK'];
    }

    public function update(Request $request)
    {

        $enterprise = Enterprise::findOrFail($request->id);
        $enterprise->name = $request->name;
        $enterprise->description = $request->description;

        $enterprise->save();
        return ['status' => 'OK'];
    }

    public function delete(Request $request, $id)
    {

        $enterprise = Enterprise::findOrFail($id)->delete();
        return ['status' => 'OK'];
    }



    public function getEnterprises()
    {

        $enterprises = Enterprise::select('enterprises.id', 'enterprises.name')
        ->orderBy('enterprises.id', 'desc')->get();
        return [
            'enterprises' => $enterprises
        ];

    }
}
