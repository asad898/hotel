<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Clothe;
use App\Models\Guest;
use App\Models\Institution;
use App\Models\Laundry;
use App\Models\Meal;
use App\Models\RestBill;
use App\Models\Room;
use App\Models\RoomPrice;
use App\Models\Store;
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
        $guests = Guest::latest()->with(['room'])->get();
        $guests2 = Guest::latest()->paginate(6);
        $meals = Meal::latest()->get();
        $roomall = Room::latest()->get();
        $clothes = Clothe::latest()->get();
        $roomprices = RoomPrice::latest()->get();
        $institutions = Institution::latest()->get();
        $guests1 = count(Guest::get());
        $rooms1 = count(Room::where('status', '=', 'جاهزة')->get());
        $bill = count(Bill::withTrashed()->get());
        $lbill = count(Laundry::get());
        $store = count(Store::get());
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
        return view('home', compact(['rooms', 'guests', 'roomprices', 'institutions', 'meals', 'clothes', 'roomall']))
            ->with('guests1', $guests1)
            ->with('guests2', $guests2)
            ->with('rooms', $rooms)
            ->with('rooms1', $rooms1)
            ->with('bill', $bill)
            ->with('lbill', $lbill)
            ->with('store', $store);
    }
}
