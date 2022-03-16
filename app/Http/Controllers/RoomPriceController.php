<?php

namespace App\Http\Controllers;

use App\Models\RoomPrice;
use Illuminate\Http\Request;

class RoomPriceController extends Controller
{
    public function index()
    {
        $roomsprices = RoomPrice::orderBy('created_at', 'asc')->get();
        return view('roomsprices.index')->with('roomsprices', $roomsprices);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'desc' => 'required',
            'tax' => 'required',
            'tourism' => 'required',
            'rent' => 'required',
            'price' => '',
            
        ]);

        // New Room Price
        $roomsprices = new RoomPrice();
        $roomsprices->desc = $request->input('desc');
        $roomsprices->rent = $request->input('rent');
        $roomsprices->sNumber = $request->input('sNumber');
        $mainNumber = $request->input('rent')/$request->input('sNumber');
        $tourism = $request->input('tourism') /100 * $mainNumber;
        $touMainNmber = $tourism + $mainNumber;
        $tax = $request->input('tax') /100 * $touMainNmber;
        $roomsprices->tax = $tax;
        $roomsprices->tourism = $tourism;
        $roomsprices->price =  $mainNumber;
        $roomsprices->save();
        
        return redirect('/roomsprices')->with('success', 'تم تسجيل تصنيف جديد');
    }

    public function update(Request $request, RoomPrice $roomprice)
    {
        $this->validate($request, [
            'desc' => 'required',
            'tax' => 'required',
            'tourism' => 'required',
            'rent' => 'required',
            'price' => '',
            
        ]);

        // Update Room Price
        $roomprice->desc = $request->input('desc');
        $roomprice->rent = $request->input('rent');
        $roomprice->sNumber = $request->input('sNumber');
        $mainNumber = $request->input('rent')/$request->input('sNumber');
        $tourism = $request->input('tourism') /100 * $mainNumber;
        $touMainNmber = $tourism + $mainNumber;
        $tax = $request->input('tax') /100 * $touMainNmber;
        $roomprice->tax = $tax;
        $roomprice->tourism = $tourism;
        $roomprice->price =  $mainNumber;
        $roomprice->save();
        
        return redirect('/roomsprices')->with('success', 'تم تسجيل تصنيف جديد');
    }

    public function destroy(RoomPrice $roomprice)
    {
        //Check if post exists before deleting
        if (!isset($roomprice)){
            return redirect('/roomsprices')->with('error', 'النزيل غير موجودة');
        }

        $roomprice->delete();
        return redirect('/roomsprices')->with('success', 'تم حذف النزيل');
    }
}
