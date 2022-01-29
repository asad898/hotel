<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreBillController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'statement' => 'required',
            'user_id' => ''
        ]);

        // New store bill
        $store = new StoreBill();
        $store->statement = $request->input('statement');
        $store->user_id = Auth::user()->id;
        $store->save();
        
        return redirect('/store/'.$store->id)->with('success', 'تم إنشاء فاتورة جديد قم بإضافة السلع');
    }

    public function show(StoreBill $storeBill)
    {
        $sum = 0;
        $items = Store::orderBy('created_at', 'asc')->get();
        return view('stores.bills.show')
        ->with('storeBill', $storeBill)
        ->with('storeBill1', $storeBill->storeDetas)
        ->with('items', $items)
        ->with('sum', $sum);
    }

    public function destroy(StoreBill $storeBill)
    {
        //Check if bill exists before deleting
        if (!isset($storeBill)) {
            return redirect('/store/show/unsaved/'.$storeBill->id)->with('error', 'هناك خطاء في الترحيل');
        }
        if(!count($storeBill->storeDetas)){
            return redirect('/store/show/unsaved/'.$storeBill->id)->with('error', 'لا يمكنك ترحيل فاتورة فارغة');
        }
        $storeBill->storeDetas->each->delete();
        $storeBill->delete();
        return redirect('/stores')->with('success', 'تم ترحيل الفاتورة');
    }

    public function trashed()
    {
        $bills = StoreBill::orderBy("id", "desc")->onlyTrashed()->get();
        return view('stores.bills.trashed')->with('bills', $bills);
    }

    public function trashedShow($id)
    {
        $sum = 0;
        $storeBill = StoreBill::onlyTrashed()->find($id);
        $detas = $storeBill->storeDetas;
        return view('stores.bills.trashedShow')->with('detas', $detas)->with('storeBill', $storeBill)->with('sum', $sum);
    }

    public function unsaved()
    {
        $bills = StoreBill::orderBy("id", "desc")->get();
        return view('stores.bills.unsaved')->with('bills', $bills);
    }

    public function unsavedShow($id)
    {
        $sum = 0;
        $items = Store::orderBy('created_at', 'asc')->get();
        $storeBill = StoreBill::find($id);
        $detas = $storeBill->storeDetas;
        return view('stores.bills.unsavedShow')
        ->with('detas', $detas)
        ->with('storeBill', $storeBill)
        ->with('items', $items)
        ->with('sum', $sum);
    }
}
