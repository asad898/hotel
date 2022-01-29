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
        $store->user_id = Auth::user()->id;
        $store->save();

        $storem = Store::find($store->store_id);
        $storem->quantity = $storem->quantity - $store->quantity;
        $storem->save();
        
        return redirect('/store/'.$store->bill_id)->with('success', 'تم حفظ عنصر جديد');
    }
}
