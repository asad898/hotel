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
        $roomsprices->tax = $request->input('tax');
        $roomsprices->tourism = $request->input('tourism');
        $roomsprices->rent = $request->input('rent');
        $tax = $request->input('tax') /100 * $request->input('rent');
        $tourism = $request->input('tourism') /100 * $request->input('rent');
        $roomsprices->price =  $request->input('rent') - $tax - $tourism;
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
        $roomprice->tax = $request->input('tax');
        $roomprice->tourism = $request->input('tourism');
        $roomprice->rent = $request->input('rent');
        $tax = ($request->input('tax') /100) * $request->input('rent');
        $tourism = ($request->input('tourism') /100) * $request->input('rent');
        $roomprice->price = $request->input('rent') - $tax - $tourism;
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
