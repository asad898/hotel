<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\Guest;
use App\Models\Institution;
use App\Models\Meal;
use App\Models\Room;
use App\Models\RoomPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $guests = Guest::latest()->get();
        $meals = Meal::latest()->get();
        $roomprices = RoomPrice::latest()->get();
        $institutions = Institution::latest()->get();
        $rooms = Room::where([
            ['number', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('number', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->with(['guest', 'roomprice', 'partner', 'institution', 'user', 'bill'])
        ->orderBy("id", "asc")
        ->get();
        return view('rooms.index', compact(['rooms', 'guests', 'roomprices', 'institutions', 'meals']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'status' => 'required',
            'user_id' => '',
        ]);

        // Create Room
        $room = new Room;
        $room->number = $request->input('number');
        $room->status = $request->input('status');
        $room->user_id = Auth::user()->id;
        $room->save();
        
        return redirect('/rooms')->with('success', 'تم إضافة غرفة جديدة');
    }

    public function update(Request $request , room $room)
    {
        
        $this->validate($request, [
            'number' => 'required',
            'status' => 'required',
            'guest_id' => '',
            'partner_id' => '',
            'roomprice_id' => '',
            'institution_id' => '',
            'user_id' => '',
        ]);

        // Update Room
        $room->number = $request->input('number');
        $room->status = $request->input('status');
        $room->guest_id = $request->input('guest_id');
        $room->roomprice_id = $request->input('roomprice_id');
        $room->partner_id = $request->input('partner_id');
        $room->institution_id = $request->input('institution_id');
        $room->user_id = Auth::user()->id;

        // check if the partner id is = to guest id
        if($request->input('partner_id')){ 
            if($request->input('partner_id') == $request->input('guest_id')){
                return redirect('/rooms')->with('warning', 'لا يمكن اختيار النزيل كمرافق');
            }
        }

        $room->save();
        // check if the opration is rent room or not
        if($request->input('guest_id')){
            $bill = new Bill;
            $bill->guest_id = $request->input('guest_id');
            $bill->room_id = $room->id;
            $bill->statment = "إيجار غرفة";
            $bill->partner_id = $request->input('partner_id');
            $bill->price = $room->roomprice->price;
            $bill->user_id = Auth::user()->id;
            $bill->institution_id = $request->input('institution_id');
            $bill->save();

            // Create Detail
            $detail = new BillDeta;
            $detail->user_id = Auth::user()->id;
            $detail->guest_id = $request->input('guest_id');
            $detail->room_id = $request->input('room_id');
            $detail->statment = $request->input('statment');
            $detail->price = $room->roomprice->price;
            $detail->bill_id = $bill->id;
            $detail->save();

            return redirect('/rooms')->with('success', 'تم تسكين النزيل ');
        }
        // To leaving room
        if($request->input('roomprice_id') == null && $request->input('guest_id') == null && $request->input('status') == "تحت التنظيف" ){ 
            //Leaving room by soft deleting bill and bill details
            //Check if post exists before soft deleting
            if (!isset($room->bill)){
                return redirect('/rooms')->with('error', 'الفاتورة غير موجودة');
            }
            $room->bill->details->each->delete();
            $room->bill->delete();
            return redirect('/rooms')->with('warning', 'لقد قمت بمغادرة نزيل'); // To check if room is empty or not
        }
        return redirect('/rooms')->with('success', 'تم تحديث الغرفة ');
    }

    public function destroy(room $room)
    {
        //Check if post exists before deleting
        if (!isset($room)){
            return redirect('/rooms')->with('error', 'الغرفة غير موجودة');
        }

        $room->delete();
        return redirect('/rooms')->with('success', 'تم حذف الغرفة');
    }

}
