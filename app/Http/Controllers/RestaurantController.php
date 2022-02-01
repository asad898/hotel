<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'statement' => 'required',
            'user_id' => ''
        ]);

        // New store bill
        $store = new RestaurantBill();
        $store->statement = $request->input('statement');
        $store->user_id = Auth::user()->id;
        $store->save();
        
        return redirect('/store/show/unsaved/'.$store->id)->with('success', 'تم إنشاء فاتورة جديد قم بإضافة السلع');
    }
}