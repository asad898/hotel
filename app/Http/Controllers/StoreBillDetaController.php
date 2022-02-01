<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreDeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreBillDetaController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'store_id' => 'required',
            'user_id' => '',
            'bill_id' => '',
            'price' => '',
            'one_p' => '',
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
        $storem = Store::find($store->store_id);
        $store->user_id = Auth::user()->id;
        $store->price = $request->input('quantity') * $storem->price;
        $store->one_p = $storem->price;
        $store->save();

        // لحذف الكمية من المخزن
        $storem->quantity = $storem->quantity - $store->quantity;
        $storem->save();
        
        return redirect('/store/show/unsaved/'.$store->bill_id)->with('success', 'تم حفظ عنصر جديد');
    }
}
