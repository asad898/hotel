<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
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
            ->get();
        return view('laundries.index', compact(['bills']))
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
        return view('laundries.trashedIndex', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $bill = Bill::find($id);
        $details = Laundry::where('bill_id', '=', $id)
        ->get();
        return view('laundries.show')->with('bill', $bill)->with('details', $details);
    }

    public function showTrashed($id)
    {
        $bill = Bill::onlyTrashed()->find($id);
        $details = Laundry::where('bill_id', '=', $id)
        ->get();
        return view('laundries.trashedShow')->with('bill', $bill)->with('details', $details);
    }
}
