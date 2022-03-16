<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBill;
use App\Models\StoreDeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreBillDetaController extends Controller
{
    public function store(Request $request) // بيع منتج من المخزن
    {
        $this->validate($request, [
            'quantity' => 'required',
            'store_id' => 'required',
            'user_id' => '',
            'bill_id' => '',
            'price' => '',
            'one_p' => '',
            'type' => '',
        ]);

        
        // New store bill detial
        $store = new StoreDeta();
        $store->quantity = $request->input('quantity');
        $store->bill_id = $request->input('bill_id');
        if ($request->input('store_id')) {
            if(Store::where('id', '=', $request->input('store_id'))->exists()){
                $store->store_id = $request->input('store_id');
            }else{
                return redirect('/store/show/unsaved/'.$request->input('bill_id'))->with('error', 'لا توجد سلعة بهذا الرقم');
            }
        }
        $bill = StoreBill::find($request->input('bill_id'));
        $storem = Store::find($store->store_id);
        $store->user_id = Auth::user()->id;
        $store->price = $request->input('quantity') * $storem->price;
        $store->one_p = $storem->price;
        if($bill->type == "pay"){
            $store->type = "pay";
        }
        $store->save();


        // لحذف او إضافة الكمية للمخزن
        // if($bill->type == "pay"){
        //     $storem->quantity = $storem->quantity + $store->quantity;
        //     $storem->save();
        // }else{
        //     $storem->quantity = $storem->quantity - $store->quantity;
        //     $storem->save();
        // }
        
        return redirect('/store/show/unsaved/'.$store->bill_id)->with('success', 'تم حفظ عنصر جديد');
    }

    public function destroy(StoreDeta $storeDeta)
    {
        $storem = Store::find($storeDeta->store_id);
        $bill = StoreBill::find($storeDeta->bill_id);
        // لحذف او إضافة الكمية للمخزن
        // if($bill->type == "pay"){
        //     $storem->quantity = $storem->quantity - $storeDeta->quantity;
        //     $storem->save();
        // }else{
        //     $storem->quantity = $storem->quantity + $storeDeta->quantity;
        //     $storem->save();
        // }
        //Check if item exists before deleting
        if (!isset($storeDeta)) {
            return redirect()->back()->with('error', 'العنصر غير موجود');
        }
        $storeDeta->forceDelete();
        return redirect()->back()->with('success', 'تم الحذف');
    }
}
