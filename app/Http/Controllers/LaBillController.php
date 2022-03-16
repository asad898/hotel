<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Clothe;
use App\Models\LaBills;
use App\Models\LaDeta;
use App\Models\LaundryTax;
use App\Models\Ledger;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaBillController extends Controller
{
    public function index(Request $request)
    {
        $bills = LaBills::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])->where('room_id', '!=', 300)
            ->orderBy("id", "asc")
            ->paginate(20);
        return view('laundries.newbills.index', compact(['bills']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function index1(Request $request)
    {
        $bills = LaBills::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])->where('room_id', '=', 300)
            ->orderBy("id", "asc")
            ->paginate(20);
        return view('laundries.newbills.index1', compact(['bills']))
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
        $tax = LaundryTax::find(1);

        // Create bill
        $bill = new LaBills();
        $bill->total = $request->input('total');
        $bill->done = $request->input('done');
        $bill->stamp = $tax->stamp;
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

        return redirect('/labill/'. $bill->id)->with('success', 'تم إنشاء فاتورة مغسلة جديدة');
    }

    public function show($id)
    {
        $clothes = Clothe::latest()->get();
        $labill = LaBills::find($id);
        $detas = LaDeta::where('La_bill_id', '=', $id)->get();
        $sp =0;
        $stax =0;
        return view('laundries.newbills.show')
            ->with('labill', $labill)
            ->with('detas', $detas)
            ->with('sp', $sp)
            ->with('stax', $stax)
            ->with('clothes', $clothes);
    }
    
    public function saveLabill($id)
    {
        $labill = LaBills::find($id);
        $labill->done = 1;
        $labill->save();
        $room_bill = Bill::find($labill->bill_id);
        $tot = $labill->tax + $labill->stamp + $labill->total;
        $room_bill->price = $room_bill->price + $tot;
        $room_bill->save();
        return redirect()->back()->with('success', 'تم حفظ الفاتورة');
    }

    public function saveCash($id)
    {
        $labill = LaBills::find($id);
        $labill->done = 1;
        $labill->save();
        // Create Pay
        $tot = $labill->tax + $labill->stamp + $labill->total;
        $pay = new Ledger();
        $pay->debit = 21;
        $pay->credit = 32;
        $pay->c_amount = $tot;
        $pay->d_amount = $tot;
        $pay->statement = "فاتورة مغسلة نقداً";
        $pay->user_id = Auth::user()->id;
        $pay->save();
        return redirect()->back()->with('success', 'تم حفظ الفاتورة');
    }

    public function destroy($id)
    {
        $bill = LaBills::find($id);
        //Check if post exists before deleting
        if (!isset($bill)){
            return redirect('/bills')->with('error', 'الفاتورة غير موجودة');
        }
        $bill->billde->each->delete();
        $bill->delete();
        return redirect('/clothes')->with('success', 'تم حذف الفاتورة');
    }
}
