<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\RestBill;
use Illuminate\Http\Request;

class RestBillController extends Controller
{
    public function index(Request $request)
    {
        $bills = Bill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "asc")
            ->with(['guest', 'room', 'partner'])
            ->get();
        return view('restaurants.index', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function trashed(Request $request)
    {
        $bills = Bill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "asc")
            ->onlyTrashed()
            ->with(['guest', 'room', 'partner'])
            ->get();
        return view('restaurants.trashedIndex', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $bill = Bill::find($id);
        $details = RestBill::where('bill_id', '=', $id)
        ->get();
        return view('restaurants.show')->with('bill', $bill)->with('details', $details);
    }

    public function showTrashed($id)
    {
        $bill = Bill::onlyTrashed()->find($id);
        $details = RestBill::where('bill_id', '=', $id)
        ->get();
        return view('restaurants.trashedShow')->with('bill', $bill)->with('details', $details);
    }
}
