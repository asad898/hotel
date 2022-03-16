<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Institution;
use App\Models\BillDeta;
use App\Models\LaBills;
use App\Models\ReBill;
use App\Models\RoomPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $bills = Bill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->with(['room','guest','partner', 'details'])
            ->orderBy("created_at", "desc")
            ->get();
        return view('bills.index', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }
    public function edit($id)
    {
        $bill = Bill::withTrashed()->find($id);
        $institutions = Institution::latest()->get();
        $guests = Guest::latest()->with(['room'])->get();
        $rooms = Room::latest()->get();
        return view('bills.edit')->with('bill', $bill)->with('institutions', $institutions)->with('guests', $guests)
        ->with('rooms', $rooms);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'guest_id' => 'required',
            'room_id' => 'required',
            'statment' => 'required',
            'price' => 'required',
            'partner_id' => '',
            'institution_id' => 'required',
            'created_at' => 'required',
        ]);
    
        $bill = Bill::withTrashed()->find($id);
        if(Guest::where('id', '=', $request->input('guest_id'))->exists()){
            $bill->guest_id = $request->input('guest_id');
        }else{
            return redirect()->back()->with('error', 'رقم النزيل غير صحيح');
        }
        if(Room::where('id', '=', $request->input('room_id'))->exists()){
            $bill->room_id = $request->input('room_id');
        }else{
            return redirect()->back()->with('error', 'رقم الغرقة غير صحيح');
        }
        if(Guest::where('id', '=', $request->input('partner_id'))->exists() or $request->input('partner_id') == null){
            $bill->partner_id = $request->input('partner_id');
        }else{
            return redirect()->back()->with('error', 'رقم المرافق غير صحيح');
        }
        $bill->statment = $request->input('statment');
        $bill->price = $request->input('price');
        if(Institution::where('id', '=', $request->input('institution_id'))->exists()){
            $bill->institution_id = $request->input('institution_id');
        }else{
            return redirect()->back()->with('error', 'رقم جهة العمل غير صحيح');
        }
        $bill->created_at = $request->input('created_at');
        $bill->deleted_at = $request->input('deleted_at');
        $bill->save();

        return redirect()->back()->with('success', 'تم تحديث البيانات');
    }
    
    public function trashedBill(Request $request)
    {
        $bills = Bill::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->with(['room','guest','partner', 'details'])
            ->orderBy("id", "desc")
            ->onlyTrashed()
            ->get();
        return view('bills.trashedBill', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $s = 0;
        $bill = Bill::find($id);
        $details = BillDeta::where('bill_id', '=', $id)
        ->with('room')
        ->get();
        $dres = ReBill::where('bill_id', '=', $bill->id)
        ->orderBy("created_at", "asc")
        ->get();
        $dlan = LaBills::where('bill_id', '=', $bill->id)
        ->orderBy("created_at", "asc")
        ->get();
        return view('bills.show')->with('bill', $bill)->with('s', $s)->with('details', $details)->with('dres', $dres)->with('dlan', $dlan);
    }

    public function showTrashed($id)
    {
        $s = 0;
        $bill = Bill::onlyTrashed()->find($id);
        $details = BillDeta::onlyTrashed()
            ->where('bill_id', '=', $id)
            ->orderBy("created_at", "asc")
            ->with('room')
            ->get();
            $guests = Guest::latest()->with(['room'])->get();
            $rooms = Room::latest()->get();
            $roomprices = RoomPrice::latest()->get();
            $dres = ReBill::where('bill_id', '=', $bill->id)
            ->orderBy("created_at", "asc")
            ->get();
        $dlan = LaBills::where('bill_id', '=', $bill->id)
        ->orderBy("created_at", "asc")
        ->get();
        return view('bills.showTrashed')
        ->with('s', $s)
        ->with('bill', $bill)
        ->with('details', $details)
        ->with('dres', $dres)
        ->with('guests', $guests)
        ->with('rooms', $rooms)
        ->with('roomprices', $roomprices)
        ->with('dlan', $dlan);
    }

    public function destroy(Bill $bill)
    {
        //Check if post exists before deleting
        if (!isset($bill)){
            return redirect('/bills')->with('error', 'الفاتورة غير موجودة');
        }
        $bill->details->delete();
        $bill->delete();
        return redirect('/bills')->with('success', 'تم حذف الفاتورة');
    }
}