<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDe;
use App\Models\Meal;
use App\Models\ReBill;
use App\Models\RestTax;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReBillControler extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'done' => 'required',
            'room_id' => 'required',
            'user_id' => '',
            'bill_id' => '',
            'stamp' => ''
        ]);
        $tax = RestTax::find(1);

        // Create bill
        $bill = new ReBill();
        $bill->total = $request->input('total');
        $bill->done = $request->input('done');
        $bill->stamp = $tax->tourism;
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
    
    public function show($id)
    {
        $meals = Meal::latest()->get();
        $rebill = ReBill::find($id);
        $detas = BillDe::where('re_bills_id', '=', $id)->get();
        $sp =0;
        $stax =0;
        return view('restaurants.newbills.show')
            ->with('rebill', $rebill)
            ->with('detas', $detas)
            ->with('sp', $sp)
            ->with('stax', $stax)
            ->with('meals', $meals);
    }
    
    public function storedeta(Request $request)
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
        $rebill->save();
        
        $billde->save();
        return redirect()->back()->with('success', 'تم إضافة عنصر');
    }

    public function saveReBill()
    {
        # code...
    }
}
