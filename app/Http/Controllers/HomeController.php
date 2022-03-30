<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\Clothe;
use App\Models\Guest;
use App\Models\Institution;
use App\Models\LaBills;
use App\Models\Laundry;
use App\Models\Meal;
use App\Models\ReBill;
use App\Models\RestBill;
use App\Models\Room;
use App\Models\RoomPrice;
use App\Models\Store;
use App\Models\SubAccount;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $myRoom = array();
        $guests = Guest::latest()->with(['room'])->get();
        $guests2 = Guest::latest()->paginate(6);
        $meals = Meal::latest()->get();
        $roomall = Room::latest()->get();
        $clothes = Clothe::latest()->get();
        $roomprices = RoomPrice::latest()->get();
        $institutions = Institution::latest()->get();
        $guests1 = count(Guest::get());
        $rooms1 = count(Room::where('status', '=', 'جاهزة')->get());
        $rooms2 = count(Room::where('status', '=', 'ساكنة')->get());
        $rooms3 = count(Room::where('status', '=', 'خارج الخدمة')->get());
        $rooms4 = count(Room::where('status', '=', 'تحت التنظيف')->get());
        $bill = count(Bill::withTrashed()->get());
        $lbill = count(Laundry::get());
        $store = count(Store::get());
        $accounts = SubAccount::latest()->get();
        $rooms = Room::where([
            ['status', '=', 'ساكنة'],
            [function ($query) use ($request) {
                if (($term = $request->term)) {
                    $query->orWhere('number', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->with(['guest', 'roomprice', 'partner', 'institution', 'user', 'bill'])
            ->orderBy("id", "asc")
            ->paginate(8);
        $rooms12 = Room::where('status', '=', 'ساكنة')->orderBy("id", "asc")->get();
        foreach ($rooms12 as $room) {
            $tot = 0;
            $bill = Bill::where('room_id', '=', $room->id)->firstOrFail();
            $detas = BillDeta::where('bill_id', '=', $bill->id)->get();
            $redetas = ReBill::where('bill_id', '=', $bill->id)->get();
            $ladetas = LaBills::where('bill_id', '=', $bill->id)->get();
            if (count($detas)) {
                foreach ($detas as $deta) {

                    if ($deta->type != "pay") {
                        $tot += $deta->tax + $deta->tourism + $deta->price;
                    }
                    if ($deta->type == "pay") {
                        $tot -= $deta->tax + $deta->tourism + $deta->price;
                    }
                }
            }
            if (count($redetas)) {
                foreach ($redetas as $deta) {
                    if ($deta->done == 1) {
                        if ($deta->type != "pay") {
                            $tot += $deta->tax + $deta->stamp + $deta->total;
                        }
                        if ($deta->type == "pay") {
                            $tot -= $deta->tax + $deta->stamp + $deta->total;
                        }
                    }
                }
            }
            if (count($ladetas)) {
                foreach ($ladetas as $deta) {
                    if ($deta->done == 1) {
                        if ($deta->type != "pay") {
                            $tot += $deta->tax + $deta->stamp + $deta->total;
                        }
                        if ($deta->type == "pay") {
                            $tot -= $deta->tax + $deta->stamp + $deta->total;
                        }
                    }
                }
            }
            $myRoom[$room->id]["roomId"] = $room->id;
            $myRoom[$room->id]["billId"] = $room->bill->id;
            $myRoom[$room->id]["total"] = $tot;
        }
        return view('home', compact(['rooms', 'guests', 'roomprices', 'institutions', 'meals', 'clothes', 'roomall', 'accounts', 'myRoom']))
            ->with('guests1', $guests1)
            ->with('guests2', $guests2)
            ->with('rooms', $rooms)
            ->with('rooms1', $rooms1)
            ->with('rooms2', $rooms2)
            ->with('rooms3', $rooms3)
            ->with('rooms4', $rooms4)
            ->with('bill', $bill)
            ->with('lbill', $lbill)
            ->with('store', $store);
    }
}
