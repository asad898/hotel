<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Models\LaBills;
use App\Models\LaDeta;
use App\Models\LaundryTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaDetacontroller extends Controller
{
    public function store(Request $request)
    {
        // dd($request->input('la_bill_id'));
        $this->validate($request, [
            'clothe_id' => 'required',
            'la_bill_id' => 'required',
            'price' => '',
            'tax' => '',
            'amount' => 'required',
            'user_id' => '',
        ]);
        $tax = LaundryTax::find(1);
        $mprice = Clothe::find($request->input('clothe_id'));
        
        $tot = $mprice->price * (int)$request->input('amount');
        $billde = new LaDeta();
        $billde->clothe_id = $request->input('clothe_id');
        $billde->la_bill_id = $request->input('la_bill_id');
        $billde->amount = $request->input('amount');
        $billde->price = $tot;
        $billde->user_id = Auth::user()->id;
        $billde->tax = $tax->tax / 100 * $tot;

        $labill = LaBills::find($billde->la_bill_id);
        $labill->total = $labill->total + $tot;
        $labill->tax = $labill->tax + $billde->tax;
        $labill->save();
        
        $billde->save();
        return redirect()->back()->with('success', 'تم إضافة عنصر');
    }

    public function destroy($id)
    {
        $billde = LaDeta::find($id);
        $labill = LaBills::find($billde->la_bill_id);
        $mprice = Clothe::find($billde->clothe_id);
        $tot = $mprice->price * (int)$billde->amount;
        $labill->total = $labill->total - $tot;
        $labill->save();
        //Check if post exists before deleting
        if (!isset($billde)) {
            return redirect()->back()->with('error', 'العنصر غير موجودة');
        }
        $billde->delete();
        return redirect()->back()->with('success', 'تم حذف العنصر');
    }
    
}
