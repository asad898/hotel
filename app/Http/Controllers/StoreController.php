<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOption\Some;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::where([
            ['name', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->orderBy("id", "asc")
        ->get();
        return view('stores.index', compact('stores'))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'quantity' => '',
            'measure' => 'required',
        ]);

        // New store
        $store = new Store();
        $store->name = $request->input('name');
        $store->quantity = $request->input('quantity');
        $store->price = $request->input('price');
        $store->measure = $request->input('measure');
        $store->save();
        
        return redirect('/stores')->with('success', 'تم حفظ عنصر جديد');
    }

    public function update(Request $request, Store $store)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'measure' => 'required',
        ]);

        // edit store
        $store->name = $request->input('name');
        $store->price = $request->input('price');
        $store->measure = $request->input('measure');
        $store->save();
        
        return redirect('/stores')->with('success', 'تم تعديل السلعة');
    }

    public function payItem(Request $request, Store $store)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'measure' => 'required',
        ]);

        // edit store
        $store->name = $request->input('name');
        $store->quantity = $store->quantity + $request->input('quantity');
        $store->price = $request->input('price');
        $store->measure = $request->input('measure');
        $store->save();
        
        return redirect('/stores')->with('success', 'تم تعديل إضافة سلعة جديدة');
    }
    
}
