<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
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
            ->with(['room','guest','partner', 'details'])
            ->orderBy("created_at", "desc")
            ->get();
        return view('bills.index', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }
    
    public function trashedBill(Request $request)
    {
        $bills = Bill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->with(['room','guest','partner', 'details'])
            ->orderBy("id", "desc")
            ->onlyTrashed()
            ->get();
        return view('bills.trashedBill', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $bill = Bill::find($id);
        $details = BillDeta::where('bill_id', '=', $id)
        ->with('room')
        ->get();
        return view('bills.show')->with('bill', $bill)->with('details', $details);
    }

    public function showTrashed($id)
    {
        $bill = Bill::onlyTrashed()->find($id);
        $details = BillDeta::onlyTrashed()
            ->where('bill_id', '=', $id)
            ->with('room')
            ->get();
        return view('bills.showTrashed')->with('bill', $bill)->with('details', $details);
    }

    public function destroy(Bill $bill)
    {
        //Check if post exists before deleting
        if (!isset($bill)){
            return redirect('/bills')->with('error', 'الفاتورة غير موجودة');
        }
        $bill->details->delete();
        $bill->delete();
        return redirect('/bills')->with('success', 'تم حذف الفاتورة');
    }
}