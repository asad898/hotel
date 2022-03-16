<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDe;
use App\Models\Ledger;
use App\Models\Meal;
use App\Models\ReBill;
use App\Models\RestTax;
use App\Models\Room;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReBillControler extends Controller
{
    public function index(Request $request)
    {
        $bills = ReBill::where([
            ['room_id', '!=', 300],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "asc")
            ->paginate(20);
        return view('restaurants.newbills.index', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function index1(Request $request)
    {
        $bills = ReBill::where([
            ['room_id', '=', 300],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "asc")
            ->paginate(20);
        return view('restaurants.newbills.index1', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'done' => 'required',
            'room_id' => 'required',
            'user_id' => '',
            'bill_id' => '',
            'stamp' => '',
            'tax' => '',
        ]);
        $tax = RestTax::find(1);

        // Create bill
        $bill = new ReBill();
        $bill->total = $request->input('total');
        $bill->done = $request->input('done');
        $bill->stamp = $tax->tourism;
        $bill->tax = 0;
        if(Room::where('id', '=', $request->input('room_id'))->exists() or $request->input('room_id') == 300){
            $bill->room_id = $request->input('room_id');
        }else{
            return redirect()->back()->with('error1', 'لا توجد غرفة بهذا الرقم');
        }
        if($bill->room_id == 300){
            $bill->bill_id = null;
        }
        else{
            $room_bill = Room::find($bill->room_id);
            $bill->bill_id = $room_bill->bill->id;
        }
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return redirect('/rebill/'. $bill->id)->with('success', 'تم إنشاء فاتورة مطعم جديدة');
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'created_at' => 'required',
            'room_id' => 'required',
            'bill_id' => '',
        ]);
        // Create bill
        $bill = ReBill::find($id);
        if($request->input('room_id') == 300){
            $bill->bill_id = null;
            $bill->room_id = 300;
        }
        else{
            if(Room::where('id', '=', $request->input('room_id'))->exists() or $request->input('room_id') == 300){
                $bill->room_id = $request->input('room_id');
            }else{
                return redirect()->back()->with('error1', 'لا توجد غرفة بهذا الرقم');
            }
            $bill->bill_id = $request->input('bill_id');
        }
        $bill->created_at = $request->input('created_at');
        $bill->save();

        return redirect()->back()->with('success', 'تم تعديل فاتورة مطعم');
    }
    
    public function show($id)
    {
        $meals = Meal::latest()->get();
        $rebill = ReBill::find($id);
        $rooms = Room::latest()->get();
        $detas = BillDe::where('re_bills_id', '=', $id)->get();
        $sp =0;
        $stax =0;
        return view('restaurants.newbills.show')
            ->with('rebill', $rebill)
            ->with('detas', $detas)
            ->with('sp', $sp)
            ->with('stax', $stax)
            ->with('rooms', $rooms)
            ->with('meals', $meals);
    }
    
    public function saveReBill($id)
    {
        $rebill = ReBill::find($id);
        $rebill->done = 1;
        $rebill->save();
        $room_bill = Bill::find($rebill->bill_id);
        $tot = $rebill->tax + $rebill->stamp + $rebill->total;
        $room_bill->price = $room_bill->price + $tot;
        $room_bill->save();
        return redirect()->back()->with('success', 'تم حفظ الفاتورة');
    }

    public function saveCash($id)
    {
        $rebill = ReBill::find($id);
        $rebill->done = 1;
        $rebill->save();
        // Create Pay
        $tot = $rebill->tax + $rebill->stamp + $rebill->total;
        $pay = new Ledger();
        $pay->debit = 21;
        $pay->credit = 31;
        $pay->c_amount = $tot;
        $pay->d_amount = $tot;
        $pay->statement = "فاتورة مطعم نقداً";
        $pay->user_id = Auth::user()->id;
        $pay->save();
        return redirect()->back()->with('success', 'تم حفظ الفاتورة');
    }

    public function destroy($id)
    {
        $bill = ReBill::find($id);
        //Check if post exists before deleting
        if (!isset($bill)){
            return redirect('/bills')->with('error', 'الفاتورة غير موجودة');
        }
        $bill->billde->each->delete();
        $bill->delete();
        return redirect('/restaurants/bills/new')->with('success', 'تم حذف الفاتورة');
    }
}