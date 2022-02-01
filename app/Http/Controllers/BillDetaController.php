<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\Clothe;
use App\Models\Laundry;
use App\Models\LaundryTax;
use App\Models\Meal;
use App\Models\RestBill;
use App\Models\RestTax;
use App\Models\Room;
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
            'tax' => '',
            'tourism' => '',
        ]);

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = $request->input('statment');
        $detail->bill_id = $request->input('bill_id');
        $room = Room::find($request->input('room_id'));
        $detail->price = $room->roomprice->price;
        $detail->tax = $room->roomprice->tax / 100 * $room->roomprice->rent;
        $detail->tourism = $room->roomprice->tourism / 100 * $room->roomprice->rent;
        $detail->save();

        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + $room->roomprice->rent;
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
            'tax' => '',
            'tourism' => '',

            # restaurant bills
            'amount' => 'required',
            'meal_id' => 'required',
            'bill_id' => '',
            
        ]);
        $tax = RestTax::find(1);
        $mprice = Meal::find($request->input('meal_id'));

        // Restaurant details
        $restBill = new RestBill;
        $restBill->amount = $request->input('amount');
        $restBill->meal_id = $request->input('meal_id');
        $restBill->bill_id = $request->input('bill_id');
        $restBill->tax = $tax->tax / 100 * ($mprice->price * (int)$request->input('amount'));
        $restBill->tourism = ($mprice->price * (int)$request->input('amount')) * $tax->tourism /100;
        $restBill->save();

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = "فاتورة مطعم (".$restBill->amount." ".$restBill->meal->name.")";
        $detail->price = ($restBill->meal->price * $restBill->amount) - $restBill->tax - $restBill->tourism;
        $detail->bill_id = $request->input('bill_id');
        $detail->tax = $tax->tax / 100 * ($mprice->price * (int)$request->input('amount'));
        $detail->tourism = ($mprice->price * (int)$request->input('amount')) * $tax->tourism /100;
        $detail->save();

        // Add Updated Price To Bill
        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + ($restBill->meal->price * $restBill->amount );
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
        
        $tax = LaundryTax::find(1);
        $mprice = Clothe::find($request->input('clothe_id'));

        // Restaurant details
        $laundry = new Laundry;
        $laundry->amount = $request->input('amount');
        $laundry->clothe_id = $request->input('clothe_id');
        $laundry->bill_id = $request->input('bill_id');
        $laundry->tax = $tax->tax / 100 * ($mprice->price * (int)$request->input('amount'));
        $laundry->stamp =  ($mprice->price * (int)$request->input('amount')) * $tax->stamp /100;
        $laundry->save();

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $detail->statment = "فاتورة مغسلة (".$laundry->amount." ".$laundry->clothe->name.")";
        $detail->price = ($laundry->clothe->price * $laundry->amount) - $laundry->tax - $laundry->stamp;
        $detail->bill_id = $request->input('bill_id');
        $detail->tax = $tax->tax / 100 * ($mprice->price * (int)$request->input('amount'));
        $detail->tourism =  ($mprice->price * (int)$request->input('amount')) * $tax->stamp /100;
        $detail->save();

        // Add Updated Price To Bill
        $bill = Bill::find($request->input('bill_id'));
        $bill->price = $bill->price + ($laundry->clothe->price * $laundry->amount);
        $bill->save();
        
        return redirect('/rooms')->with('success', 'تم إضافة فاتورة مغسلة');
    }
}