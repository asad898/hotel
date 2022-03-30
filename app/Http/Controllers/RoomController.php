<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDeta;
use App\Models\Clothe;
use App\Models\Guest;
use App\Models\Institution;
use App\Models\LaBills;
use App\Models\Ledger;
use App\Models\Meal;
use App\Models\ReBill;
use App\Models\Room;
use App\Models\RoomPrice;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $myRoom = array();
        $guests = Guest::latest()->with(['room'])->get();
        $meals = Meal::latest()->get();
        $roomall = Room::latest()->get();
        $clothes = Clothe::latest()->get();
        $roomprices = RoomPrice::latest()->get();
        $institutions = Institution::latest()->get();
        $accounts = SubAccount::latest()->get();
        $rooms = Room::where([
            ['number', '!=', Null],
            [function ($query) use ($request) {
                if (($term = $request->term)) {
                    $query->orWhere('number', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->with(['guest', 'roomprice', 'partner', 'institution', 'user', 'bill'])
            ->orderBy("id", "asc")
            ->paginate(8);
        $rooms1 = Room::where('status', '=', 'ساكنة')->get();
        foreach ($rooms1 as $room) {
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
        return view('rooms.index', compact(['rooms', 'accounts', 'guests', 'roomprices', 'institutions', 'meals', 'clothes', 'roomall', 'myRoom']))
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

        return redirect()->back()->with('success', 'تم إضافة غرفة جديدة');
    }

    public function update(Request $request, room $room)
    {

        $this->validate($request, [
            'number' => 'required',
            'status' => 'required',
            'guest_id' => '',
            'partner_id' => '',
            'roomprice_id' => '',
            'institution_id' => '',
            'user_id' => '',
            'leaving' => '',
        ]);



        // check if the partner id is = to guest id
        if ($request->input('partner_id')) {
            if ($request->input('partner_id') == $request->input('guest_id')) {
                return redirect()->back()->with('warning', 'لا يمكن اختيار النزيل كمرافق');
            }
        }


        // Rent Room

        // check if the opration is rent room or not
        if ($request->input('guest_id')) {
            if ($request->input('guest_id') == null or $request->input('roomprice_id') == null or $request->input('institution_id') == null) {
                return redirect()->back()->with('error1', 'هناك بعض الحقول الخالية ');
            }
            // Make sure that guest number is exist in guest tabel
            if (
                Guest::where('id', '=', $request->input('guest_id'))->exists() and
                RoomPrice::where('id', '=', $request->input('roomprice_id'))->exists() and
                Institution::where('id', '=', $request->input('institution_id'))->exists()

            ) {

                // dd(Room::where('guest_id', '=', $request->input('guest_id'))->exists());
                // Update Room

                if (!Room::where('guest_id', '=', $request->input('guest_id'))->exists()) {
                    if (!Room::where('partner_id', '=', $request->input('guest_id'))->exists()) {
                        $room->guest_id = $request->input('guest_id');
                    } else {
                        return redirect()->back()->with('error1', 'هذا النزيل مرافق في غرفة اخرى ');
                    }
                } else {
                    return redirect()->back()->with('error1', 'هذا النزيل ساكن في غرفة اخرى ');
                }

                if ($request->input('partner_id')) {
                    if (Guest::where('id', '=', $request->input('partner_id'))->exists()) {
                        if (!Room::where('partner_id', '=', $request->input('partner_id'))->exists()) {
                            if (!Room::where('guest_id', '=', $request->input('partner_id'))->exists()) {
                                $room->partner_id = $request->input('partner_id');
                            } else {
                                return redirect()->back()->with('error1', 'هذا المرافق ساكن في غرفة اخرى ');
                            }
                        } else {
                            return redirect()->back()->with('error1', 'هذا النزيل مرافق في غرفة اخرى ');
                        }
                    } else {
                        return redirect()->back()->with('error1', 'رقم المرافق غير موجود ');
                    }
                }
                if (Institution::where('id', '=', $request->input('institution_id'))->exists()) {
                    $room->institution_id = $request->input('institution_id');
                } else {
                    return redirect()->back()->with('error1', 'لا توجد مؤسسة بهذا الرقم ');
                }
                $room->user_id = Auth::user()->id;
                $room->roomprice_id = $request->input('roomprice_id');
                $room->number = $request->input('number');
                $room->status = $request->input('status');
                $room->leaving = 1;

                // Bill section
                $bill = new Bill;
                $bill->guest_id = $request->input('guest_id');
                $bill->room_id = $room->id;
                $bill->statment = "إيجار غرفة";
                $bill->partner_id = $request->input('partner_id');
                $bill->price = $room->roomprice->rent;
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
                $detail->tax = $room->roomprice->tax;
                $detail->tourism = $room->roomprice->tourism;
                $detail->bill_id = $bill->id;
                $detail->save();

                $room->save();

                return redirect()->back()->with('success', 'تم تسكين النزيل ');
            } else {
                return redirect()->back()->with('error1', 'هناك خطاء في البيانات المدخلة ');
            }
        }

        // Update Room
        $room->number = $request->input('number');
        if ($request->input('status') == "ساكنة") {
            return redirect()->back()->with('error1', 'هناك بعض الحقول الخالية ');
        } else {
            $room->status = $request->input('status');
        }
        $room->guest_id = $request->input('guest_id');
        $room->roomprice_id = $request->input('roomprice_id');
        $room->partner_id = $request->input('partner_id');
        $room->institution_id = $request->input('institution_id');
        $room->user_id = Auth::user()->id;

        // To leaving room
        if ($request->input('leaving') == 1 && $request->input('roomprice_id') == null && $request->input('guest_id') == null && $request->input('status') == "تحت التنظيف") {


            //Leaving room by soft deleting bill and bill details
            //Check if post exists before soft deleting
            $price = 0;
            $tax = 0;
            $tourism = 0;
            $tot = 0;
            $tot1 = 0;
            $detas = BillDeta::where('bill_id', '=', $room->bill->id)->get();
            $redetas = ReBill::where('bill_id', '=', $room->bill->id)->get();
            $ladetas = LaBills::where('bill_id', '=', $room->bill->id)->get();
            if (count($detas)) {
                foreach ($detas as $deta) {
                    $tax += $deta->tax;
                    $tourism += $deta->tourism;
                    if ($deta->type != "pay") {
                        $price += $deta->price;
                    }
                    if ($deta->type == "pay") {
                        $tot1 += $deta->price;
                    }
                    $tot += $tax + $tourism + $price;
                    $price = 0;
                    $tax = 0;
                    $tourism = 0;
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
                        $price = 0;
                        $tax = 0;
                        $tourism = 0;
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
                        $price = 0;
                        $tax = 0;
                        $tourism = 0;
                    }
                }
            }
            if (!($tot <= $tot1)) {
                return redirect()->back()->with('error1', 'لا يمكنك مغادرة الغرفة, لم يتم سداد الفاتورة');
            } else {
                if (!isset($room->bill)) {
                    return redirect()->back()->with('error', 'الفاتورة غير موجودة');
                }
                $room->leaving = 0;
                $room->save();
                $room->bill->details->each->delete();
                $room->bill->delete();
                return redirect()->back()->with('warning', 'لقد قمت بمغادرة نزيل'); // To check if room is empty or not
            }
        }
        $room->save();
        return redirect()->back()->with('success', 'تم تحديث الغرفة ');
    }

    # Change Room
    public function changeRoom(Request $request, Room $room)
    {
        $this->validate($request, [
            'id' => 'required',
            'bill_id' => '',
            'status' => '',
            'guest_id' => '',
            'partner_id' => '',
            'roomprice_id' => '',
            'institution_id' => '',
            'user_id' => '',
            'leaving' => '',
        ]);

        $gole = Room::find($request->input('id'));
        $bill = Bill::find($request->input('bill_id'));

        if ($gole->status == 'جاهزة') {
            // Change Room

            $gole->status = $request->input('status');
            $gole->guest_id = $request->input('guest_id');
            $gole->roomprice_id = $request->input('roomprice_id');
            $gole->partner_id = $request->input('partner_id');
            $gole->institution_id = $request->input('institution_id');
            $gole->user_id = Auth::user()->id;
            $gole->leaving = 1;

            $gole->save();

            $bill->room_id = $request->input('id');
            $bill->save();

            $room->status = 'تحت التنظيف';
            $room->guest_id = null;
            $room->roomprice_id = null;
            $room->partner_id = null;
            $room->institution_id = null;
            $room->user_id = Auth::user()->id;
            $room->leaving = 0;

            $room->save();


            return redirect()->back()->with('success', ' تم تغير الغرفة للنزيل');
        } elseif ($gole->status == 'ساكنة') {
            return redirect()->back()->with('error1', 'الغرفة المراد النقل اليها ساكنة ');
        } else {
            return redirect()->back()->with('error1', 'الغرفة غير جاهزة ');
        }
    }

    public function changePrice(Request $request, Room $room)
    {
        $this->validate($request, [
            'id' => 'required',
            'inst' => 'required'
        ]);
        if (RoomPrice::where('id', '=', $request->input('id'))->exists()) {
            $room->roomprice_id = $request->input('id');
        } else {
            return redirect()->back()->with('error1', 'هناك خطأ في سعر الغرفة ');
        }
        $bill = Bill::find($room->bill->id);
        if (Institution::where('id', '=', $request->input('inst'))->exists()) {
            $room->institution_id = $request->input('inst');
            $bill->institution_id = $request->input('inst');
        } else {
            return redirect()->back()->with('error1', 'هناك خطأ في اسم جهة ');
        }
        $bill->save();
        $room->save();

        return redirect()->back()->with('success', 'تم تغير سعر الغرفة');
    }

    public function payment(Request $request, Room $room)
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
            'type' => '',
        ]);

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $request->input('guest_id');
        $detail->room_id = $request->input('room_id');
        $room = Room::find($request->input('room_id'));
        $detail->statment = $request->input('statment');
        $detail->bill_id = $request->input('bill_id');
        $detail->price = $request->input('price');
        $detail->tax = 0;
        $detail->tourism = 0;
        $detail->type = "pay";

        $bill = Bill::find($request->input('bill_id'));

        $this->validate($request, [
            'statement' => '',
            'credit' => '', # دائن
            'debit' => 'required', # مدين
            'c_amount' => '',
            'd_amount' => '',
            'user_id' => '',

        ]);

        // Create Pay
        if (SubAccount::where('id', '=', $request->input('debit'))->exists()) {
            $pay = new Ledger();
            $pay->statement = $request->input('statment') . "رقم الفاتورة " . $room->bill->id;
            if ($request->input('debit') == 26) {
                $pay->credit = $request->input('debit');
                $pay->debit = 21; // حساب الصندوق
            } elseif ($request->input('debit') == 32) {
                $pay->credit = $request->input('debit');
                $pay->debit = 21; // حساب الصندوق
            } elseif ($request->input('debit') == 31) {
                $pay->credit = $request->input('debit');
                $pay->debit = 21; // حساب الصندوق
            } else {
                $pay->debit = $request->input('debit');
                $pay->credit = 26; // حساب إيرادات الغرف
            }
        } else {
            return redirect()->back()->with('error1', 'رقم الحساب غير صحيح ');
        }
        $pay->c_amount = $request->input('price');
        $pay->d_amount = $request->input('price');
        $pay->user_id = Auth::user()->id;

        // if($room->institution->id != 1 and $request->input('debit') == 26)
        // {
        //     return redirect()->back()->with('error1', 'لا يمكنك الدفع كاش في هذه الغرفة');
        // }
        // elseif($room->institution->id == 1 and $request->input('debit') != 26)
        // {
        //     return redirect()->back()->with('error1', 'لا يمكنك الدفع الدفع على الحساب في هذه الغرفة');
        // }
        // if ($bill->price < $request->input('price')) {
        //     return redirect()->back()->with('error1', 'المبلغ المدخل اكبر من مطالبة الفاتورة');
        // } else {
        $bill->price = $bill->price - $detail->price;
        $detail->save();
        $bill->save();
        $pay->save();
        // }

        return redirect()->back()->with('success', 'تم ' . $detail->statment);
    }

    public function addPartner(Request $request, Room $room)
    {
        $this->validate($request, [
            'partner_id' => 'required',
        ]);
        $p = Guest::find($request->input('partner_id'));
        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $room->guest->id;
        $detail->room_id = $room->id;
        $detail->statment = "تم إضافة مرافق ".$p->name;
        $detail->bill_id = $room->bill->id;
        $detail->price = 0;
        $detail->tax = 0;
        $detail->tourism = 0;
        $detail->type = "guest";
        $detail->save();

        $bill = Bill::find($room->bill->id);
        $room->partner_id = $request->input('partner_id');
        $room->save();
        $bill->partner_id = $request->input('partner_id');
        $bill->save();
        return redirect()->back()->with('success', 'تم إضافة مرافق');
    }

    public function removePartner(Request $request, Room $room)
    {
        $this->validate($request, [
            'partner_id' => '',
        ]);

        // Create Detail
        $detail = new BillDeta;
        $detail->user_id = Auth::user()->id;
        $detail->guest_id = $room->guest->id;
        $detail->room_id = $room->id;
        $detail->statment = "تم مغادرة المرافق ".$room->partner->name;
        $detail->bill_id = $room->bill->id;
        $detail->price = 0;
        $detail->tax = 0;
        $detail->tourism = 0;
        $detail->type = "guest";
        $detail->save();

        $room->partner_id = null;
        $room->save();

        $bill = Bill::find($room->bill->id);
        $bill->partner_id = null;
        $bill->save();

        return redirect()->back()->with('success', 'تمت مغادرة المرافق');
    }

    public function pchange(Request $request, Room $room)
    {
        $this->validate($request, [
            'partner_id' => 'required',
            'guest_id' => 'required',
            'bill_id' => 'required',
        ]);

        $bill = Bill::find($room->bill->id);
        $room->partner_id = $request->input('guest_id');
        $room->guest_id = $request->input('partner_id');
        $room->save();
        $room->partner_id = $request->input('guest_id');
        $bill->guest_id = $request->input('partner_id');
        $bill->save();
        return redirect()->back()->with('success', 'تم تغير النزيل مع المرافق');
    }

    public function updateAll()
    {
        $rooms = Room::where('status', '=', 'ساكنة')->get();
        foreach ($rooms as $room) {
            $room1 = new BillDeta;
            $room1->guest_id = $room->guest->id;
            $room1->room_id = $room->id;
            $room1->statment = "إيجار الغرفة رقم $room->number";
            $room1->price = $room->roomprice->price;
            $room1->tax = $room->roomprice->tax;
            $room1->tourism = $room->roomprice->tourism;
            $room1->bill_id = $room->bill->id;
            $room1->user_id = Auth::user()->id;

            $bill = Bill::find($room1->bill_id);
            $bill->price = $bill->price + $room->roomprice->rent;
            $bill->save();

            $room1->save();
        }
        return redirect()->back()->with('success', 'تم تحديث كل الغرف');
    }

    public function destroy(room $room)
    {
        //Check if post exists before deleting
        if (!isset($room)) {
            return redirect()->back()->with('error', 'الغرفة غير موجودة');
        }

        $room->delete();
        return redirect()->back()->with('success', 'تم حذف الغرفة');
    }
}
