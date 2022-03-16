<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Store;
use App\Models\StoreBill;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreBillController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'statement' => 'required',
            'type' => 'required',
            'dept' => 'required',
            'user_id' => ''
        ]);

        // New store bill
        $store = new StoreBill();
        $store->statement = $request->input('statement');
        $store->type = $request->input('type');
        $store->dept = $request->input('dept');
        $store->user_id = Auth::user()->id;
        $store->save();

        return redirect('/store/show/unsaved/' . $store->id)->with('success', 'تم إنشاء فاتورة جديد قم بإضافة السلع');
    }

    public function destroy(StoreBill $storeBill)
    {
        //Check if bill exists before deleting
        if (!isset($storeBill)) {
            return redirect('/store/show/unsaved/' . $storeBill->id)->with('error', 'هناك خطاء في الترحيل');
        }
        if (!count($storeBill->storeDetas)) {
            return redirect('/store/show/unsaved/' . $storeBill->id)->with('error', 'لا يمكنك ترحيل فاتورة فارغة');
        }
        // لحذف او إضافة الكمية للمخزن
        foreach ($storeBill->storeDetas as $deta) {
            $store = Store::find($deta->store_id);
            if ($storeBill->type == "إذن شراء") {
                $store->quantity = $store->quantity + $deta->quantity;
                $store->save();
            } else {
                $store->quantity = $store->quantity - $deta->quantity;
                $store->save();
            }
        }
        $storeBill->storeDetas->each->delete();
        $storeBill->delete();
        return redirect('/stores')->with('success', 'تم ترحيل الفاتورة');
    }

    public function destroy1(Request $request, StoreBill $storeBill) // على الحساب
    {
        $this->validate($request, [
            'statement' => '',
            'credit' => '', # دائن
            'debit' => '', # مدين
            'c_amount' => '',
            'd_amount' => '',
            'user_id' => '',
            'type' => '',

        ]);
        if (!$request->input('credit') or $request->input('debit')) {
            return redirect('/stores')->with('error', 'هناك بعض الحقول الفارغة');
        }
        if($request->input('type') == "debit"){
            // Create Pay
        $pay = new Ledger();
        $pay->statement = $request->input('statement');
        $pay->debit = 47;
        $pay->credit = $request->input('credit');
        $pay->c_amount = $request->input('price');
        $pay->d_amount = $request->input('price');
        $pay->user_id = Auth::user()->id;
        $pay->save();
        //Check if bill exists before deleting
        if (!isset($storeBill)) {
            return redirect()->back()->with('error', 'هناك خطاء في الترحيل');
        }
        if (count($storeBill->storeDetas) == 0) {
            return redirect()->back()->with('error', 'لا يمكنك ترحيل فاتورة فارغة');
        }
        $storeBill->storeDetas->each->delete();
        $storeBill->delete();
        return redirect('/stores')->with('success', 'تم ترحيل الفاتورة');
        }

        if($request->input('type') == "credit"){
            // Create Pay
        $pay = new Ledger();
        $pay->statement = $request->input('statement');
        $pay->debit = 47;//من ح المشتريات
        $pay->credit = 21;//الى ح الصندوق
        $pay->c_amount = $request->input('price');
        $pay->d_amount = $request->input('price');
        $pay->user_id = Auth::user()->id;
        $pay->save();
        //Check if bill exists before deleting
        if (!isset($storeBill)) {
            return redirect()->back()->with('error', 'هناك خطاء في الترحيل');
        }
        if (count($storeBill->storeDetas) == 0) {
            return redirect()->back()->with('error', 'لا يمكنك ترحيل فاتورة فارغة');
        }
        $storeBill->storeDetas->each->delete();
        $storeBill->delete();
        return redirect('/stores')->with('success', 'تم ترحيل الفاتورة');
        }
    }

    public function trashed(Request $request)
    {
        $bills = StoreBill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('statement', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('type', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->orderBy("id", "desc")
        ->onlyTrashed()
        ->paginate(16);
        return view('stores.bills.trashed', compact('bills'))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function trashedShow($id)
    {
        $sum = 0;
        $storeBill = StoreBill::onlyTrashed()->find($id);
        $detas = $storeBill->storeDetas;
        return view('stores.bills.trashedShow')->with('detas', $detas)->with('storeBill', $storeBill)->with('sum', $sum);
    }

    public function unsaved(Request $request)
    {
        $bills = StoreBill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('statement', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->orderBy("id", "desc")
        ->paginate(16);
        return view('stores.bills.unsaved', compact('bills'))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function unsavedShow($id)
    {
        $sum = 0;
        $items = Store::orderBy('created_at', 'asc')->get();
        $storeBill = StoreBill::find($id);
        $detas = $storeBill->storeDetas;
        $accounts = SubAccount::latest()->get();
        return view('stores.bills.unsavedShow')
            ->with('detas', $detas)
            ->with('storeBill', $storeBill)
            ->with('items', $items)
            ->with('accounts', $accounts)
            ->with('sum', $sum);
    }

    public function adminConf(Request $request, StoreBill $storeBill)
    {
        $this->validate($request, [
            'admin_conf' => '',
        ]);
        if( $request->input('admin_conf') == false ) {
            $ch = 0;
        } else {
            $ch = 1;
        }
        $storeBill->admin_conf = $ch;
        $storeBill->save();
        if($request->input('admin_conf') == 0){
            return redirect('/stores')->with('success', 'تمت إلغاء الموافقة على السند');
        }
        return redirect('/stores')->with('success', 'تمت الموافقة على السند');
    }

    public function adminindex()
    {
        $bills = StoreBill::orderBy("id", "desc")->get();
        return view('stores.bills.adminindex')->with('bills', $bills);
    }

    public function am()
    {
        $bills = StoreBill::orderBy("id", "desc")->get();
        return view('stores.bills.am')->with('bills', $bills);
    }
}
