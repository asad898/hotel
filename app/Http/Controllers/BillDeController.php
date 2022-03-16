<?php

namespace App\Http\Controllers;

use App\Models\BillDe;
use App\Models\Meal;
use App\Models\ReBill;
use App\Models\RestTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillDeController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->input('re_bills_id'));
        $this->validate($request, [
            'meal_id' => 'required',
            're_bills_id' => 'required',
            'price' => '',
            'tax' => '',
            'amount' => 'required',
            'user_id' => '',
        ]);
        $tax = RestTax::find(1);
        $mprice = Meal::find($request->input('meal_id'));
        
        $tot = $mprice->price * (int)$request->input('amount');
        $billde = new BillDe();
        $billde->meal_id = $request->input('meal_id');
        $billde->re_bills_id = $request->input('re_bills_id');
        $billde->amount = $request->input('amount');
        $billde->price = $tot;
        $billde->user_id = Auth::user()->id;
        $billde->tax = $tax->tax / 100 * $tot;

        $rebill = ReBill::find($billde->re_bills_id);
        $rebill->total = $rebill->total + $tot;
        $rebill->tax = $rebill->tax + $billde->tax;
        $rebill->save();
        
        $billde->save();
        return redirect()->back()->with('success', 'تم إضافة عنصر');
    }

    public function destroy($id)
    {
        $tax = RestTax::find(1);
        $billde = BillDe::find($id);
        $rebill = ReBill::find($billde->re_bills_id);
        $mprice = Meal::find($billde->meal_id);
        $tot = $mprice->price * (int)$billde->amount;
        $rebill->total = $rebill->total - $tot;
        $tax1 = $tax->tax / 100 * $tot;
        $rebill->tax = $rebill->tax - $tax1;
        $rebill->save();
        //Check if post exists before deleting
        if (!isset($billde)) {
            return redirect()->back()->with('error', 'العنصر غير موجودة');
        }
        $billde->delete();
        return redirect()->back()->with('success', 'تم حذف العنصر');
    }
}
