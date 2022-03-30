<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDe;
use App\Models\BillDeta;
use App\Models\LaBills;
use App\Models\ReBill;
use App\Models\Room;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // حركة تسكين الغرف
    public function rooms_status_show(Request $request)
    {
        $myA = array();
        if ($request->from) {
            $from = $request->from;
        } else {
            $from = date('Y-m-d');
        }
        if ($request->to) {
            $to = $request->to;
        } else {
            $to = date('Y-m-d');
        }
        $bills = Bill::onlyTrashed()->whereRaw(
            "(deleted_at >= ? AND deleted_at <= ?)",
            [
                $from . " 00:00:00",
                $to . " 23:59:59"
            ]
        )->orderBy('deleted_at', 'asc')->get();
        foreach ($bills as $bill) {
            $price = 0;
            $tax = 0;
            $tourism = 0;
            $detas = BillDeta::onlyTrashed()->where('bill_id', '=', $bill->id)->get();
            if (count($detas)) {
                foreach ($detas as $deta) {
                    $tax += $deta->tax;
                    $tourism += $deta->tourism;
                    if ($deta->type != "pay") {
                        $price += $deta->price;
                    }
                }
            }

            $myA[$bill->id]["roomNumber"] = $bill->room->number;
            $myA[$bill->id]["bill_id"] = $bill->id;
            $myA[$bill->id]["guestNumber"] = $bill->guest->id;
            $myA[$bill->id]["guestName"] = $bill->guest->name;
            if ($bill->partner) {
                $myA[$bill->id]["pNumber"] = $bill->partner->id;
                $myA[$bill->id]["partnerName"] = $bill->partner->name;
            } else {
                $myA[$bill->id]["pNumber"] = "-";
                $myA[$bill->id]["partnerName"] = "-";
            }
            $myA[$bill->id]["arrDate"] = $bill->created_at->format('d/m/Y');
            $myA[$bill->id]["leaDate"] = $bill->deleted_at->format('d/m/Y');
            $myA[$bill->id]["ins"] = $bill->institution->name;
            $myA[$bill->id]["price"] = $price;
            $myA[$bill->id]["tax"] = $tax;
            $myA[$bill->id]["tourism"] = $tourism;
        }
        $st = 0;
        $stu = 0;
        $sp = 0;
        $rec = 0;
        $tot = 0;
        return view('reports.roomsStatus')
            ->with('from', $from)
            ->with('bills', $bills)
            ->with('myA', $myA)
            ->with('st', $st)
            ->with('stu', $stu)
            ->with('sp', $sp)
            ->with('rec', $rec)
            ->with('tot', $tot)
            ->with('to', $to);
    }

    // غرف كاش
    public function rooms_cash_show(Request $request)
    {
        $myA = array();
        if ($request->from) {
            $from = $request->from;
        } else {
            $from = date('Y-m-d');
        }
        if ($request->to) {
            $to = $request->to;
        } else {
            $to = date('Y-m-d');
        }
        $bills = BillDeta::withTrashed()
        ->where(function($q){
            $q->where('statment', 'LIKE', '%' . 'سداد فاتورة مطعم الغرفة رقم' . '%')
            ->orwhere('statment', 'LIKE', '%' . 'سداد الغرفة رقم' . '%')
            ->orwhere('statment', 'LIKE', '%' . 'سداد فاتورة مغسلة الغرفة' . '%');
        })
        ->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $from . " 00:00:00",
                $to . " 23:59:59"
            ]
        )
        ->orderBy('created_at', 'asc')->get();
        foreach ($bills as $bill) {
            $gbill = Bill::withTrashed()->find($bill->bill_id);
            if ($gbill->deleted_at) {
                $myA[$bill->id]["leaDate"] = $gbill->deleted_at->format('d/m/Y');
            } else {
                $myA[$bill->id]["leaDate"] = "-";
            }
            $myA[$bill->id]["bill_id"] = $gbill->id;
            $myA[$bill->id]["roomNumber"] = $gbill->room->number;
            $myA[$bill->id]["guestName"] = $gbill->guest->name;
            if ($gbill->partner) {
                $myA[$bill->id]["pNumber"] = $gbill->partner->id;
                $myA[$bill->id]["partnerName"] = $gbill->partner->name;
            } else {
                $myA[$bill->id]["pNumber"] = "-";
                $myA[$bill->id]["partnerName"] = "-";
            }
            $myA[$bill->id]["ins"] = $gbill->institution->name;
            $myA[$bill->id]["arrDate"] = $gbill->created_at;
            $myA[$bill->id]["price"] = $bill->price;
            $myA[$bill->id]["statment"] = $bill->statment;
        }
        $tot = 0;
        return view('reports.cashRooms')
            ->with('from', $from)
            ->with('bills', $bills)
            ->with('myA', $myA)
            ->with('tot', $tot)
            ->with('to', $to);
    }

    public function guests_Status(Request $request)
    {
        $myA = array();
        if ($request->from) {
            $from = $request->from;
        } else {
            $from = date('Y-m-d');
        }
        if ($request->to) {
            $to = $request->to;
        } else {
            $to = date('Y-m-d');
        }
        $rooms = Room::where('status', '=', 'ساكنة')->orderBy('created_at', 'asc')->get();
        foreach ($rooms as $room) {
            $myA[$room->id]["billId"] = $room->bill->id;
            $myA[$room->id]["guestId"] = $room->guest->id;
            $myA[$room->id]["roomNumber"] = $room->number;
            $myA[$room->id]["guestName"] = $room->guest->name;
            if ($room->partner) {
                $myA[$room->id]["partnerId"] = $room->partner->id;
                $myA[$room->id]["partnerName"] = $room->partner->name;
            } else {
                $myA[$room->id]["partnerId"] = "-";
                $myA[$room->id]["partnerName"] = "-";
            }
            $myA[$room->id]["guestAddress"] = $room->guest->institution;
            $myA[$room->id]["institution"] = $room->institution->name;
            $myA[$room->id]["guestPhone"] = $room->guest->phone;
            $myA[$room->id]["guestIdentity"] = $room->guest->identity;
            $myA[$room->id]["guestIdentityId"] = $room->guest->identityId;
            $myA[$room->id]["billCreatedAt"] = $room->bill->created_at->format('d/m/Y');
        }
        return view('reports.guestStatus')
            ->with('myA', $myA)
            ->with('rooms', $rooms);
    }

    // public function rest_cash(Request $request)
    // {
    //     $myA = array();
    //     if ($request->from) {
    //         $from = $request->from;
    //     } else {
    //         $from = date('Y-m-d');
    //     }
    //     if ($request->to) {
    //         $to = $request->to;
    //     } else {
    //         $to = date('Y-m-d');
    //     }
    //     $bills = ReBill::withTrashed()->whereRaw(
    //         "(created_at >= ? AND created_at <= ?)",
    //         [
    //             $from . " 00:00:00",
    //             $to . " 23:59:59"
    //         ]
    //     )->orderBy('created_at', 'asc')->get();
    //     foreach ($bills as $bill) {
    //         $tax = 0;
    //         $redetas = BillDe::where('bill_id', '=', $bill->id)->get();
    //         if (count($redetas)) {
    //             foreach ($redetas as $deta) {
    //                 $tax += $deta->tax;
    //                 if ($deta->type != "pay") {
    //                     $price += $deta->price;
    //                 }
    //                 else{
    //                     $pay += $deta->price;
    //                 }
    //             }
    //         }
    //     }
    // }
}
