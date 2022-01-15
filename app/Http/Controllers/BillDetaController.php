<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\Laundry;
use App\Models\RestBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillDetaController extends Controller
{
    public function index()
    {
        $details = BillDeta::latest()->get();
        return view('details.index', [
            'details' => $details
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => '',
            'guest_id' => 'required',
            'room_id' => 'required',
            'statment' => 'required',
            'price' => 'required',
            'bill_id' => 'required',
        ]);

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = $request->input('statment');
        $detail->price = $request->input('price');
        $detail->bill_id = $request->input('bill_id');
        $detail->save();

        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + $request->input('price');
        $bill->save();
        
        return redirect('/rooms')->with('success', 'تم تحديث الغرف');
    }

    public function restBillStore(Request $request)
    {
        $this->validate($request, [
            'guest_id' => '',
            'room_id' => '',
            'statment' => '',
            'bill_id' => '',
            'price' => '',
            'user_id' => '',

            # restaurant bills
            'amount' => 'required',
            'meal_id' => 'required',
            'bill_id' => '',
            
        ]);

        // Restaurant details
        $restBill = new RestBill;
        $restBill->amount = $request->input('amount');
        $restBill->meal_id = $request->input('meal_id');
        $restBill->bill_id = $request->input('bill_id');
        $restBill->save();

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = "فاتورة مطعم (".$restBill->amount." ".$restBill->meal->name.")";
        $detail->price = $restBill->meal->price * $restBill->amount;
        $detail->bill_id = $request->input('bill_id');
        $detail->save();

        // Add Updated Price To Bill
        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + $detail->price;
        $bill->save();
        
        return redirect('/rooms')->with('success', 'تم إضافة فاتورة مطعم');
    }

    public function laundryBill(Request $request)
    {
        $this->validate($request, [
            'guest_id' => '',
            'room_id' => '',
            'statment' => '',
            'bill_id' => '',
            'price' => '',
            'user_id' => '',

            # restaurant bills
            'amount' => 'required',
            'clothe_id' => 'required',
            'bill_id' => '',
            
        ]);

        // Restaurant details
        $laundry = new Laundry;
        $laundry->amount = $request->input('amount');
        $laundry->clothe_id = $request->input('clothe_id');
        $laundry->bill_id = $request->input('bill_id');
        $laundry->save();

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = "فاتورة مغسلة (".$laundry->amount." ".$laundry->clothe->name.")";
        $detail->price = $laundry->clothe->price * $laundry->amount;
        $detail->bill_id = $request->input('bill_id');
        $detail->save();

        // Add Updated Price To Bill
        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + $detail->price;
        $bill->save();
        
        return redirect('/rooms')->with('success', 'تم إضافة فاتورة مغسلة');
    }
}