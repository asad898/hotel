<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\MainAccount;
use App\Models\SubAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    #اليومية
    public function index(Request $request)
    {
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
        $entrys = Ledger::whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $from . " 00:00:00",
                $to . " 23:59:59"
            ]
        )->with(['dAccount', 'cAccount'])->latest()->get();
        $creditSum = 0;
        $debitSum = 0;
        foreach ($entrys as $entry) {
            $creditSum += $entry->c_amount;
            $debitSum += $entry->d_amount;
        }
        return view('accounts.day')
            ->with('entrys', $entrys)
            ->with('creditSum', $creditSum)
            ->with('debitSum', $debitSum)
            ->with('from', $from)
            ->with('to', $to);
    }

    #الاستاذ
    public function single(Request $request)
    {
        $accounts = SubAccount::get();
        $account1 = $request->account;
        $from = $request->from;
        $to = $request->to;
        $entrys = Ledger::where('credit', '=', $account1)->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $from . " 00:00:00",
                $to . " 23:59:59"
            ]
        )->orwhere('debit', '=', $account1)->whereRaw(
            "(created_at >= ? AND created_at <= ?)",
            [
                $from . " 00:00:00",
                $to . " 23:59:59"
            ]
        )->with(['dAccount', 'cAccount'])->get();
        $creditSum = 0;
        $debitSum = 0;
        foreach ($entrys as $entry) {
            if ($entry->credit != $account1) {
                $creditSum += $entry->c_amount;
            }
            if ($entry->debit != $account1) {
                $debitSum += $entry->d_amount;
            }
        }
        if ($creditSum > $debitSum) {
            $bigSum = $creditSum;
            $stage = $creditSum - $debitSum;
        } else {
            $bigSum = $debitSum;
            $stage = $debitSum - $creditSum;
        }
        return view('accounts.single')
            ->with('entrys', $entrys)
            ->with('creditSum', $creditSum)
            ->with('debitSum', $debitSum)
            ->with('accounts', $accounts)
            ->with('account1', $account1)
            ->with('stage', $stage)
            ->with('bigSum', $bigSum)
            ->with('from', $from)
            ->with('to', $to);
    }

    #ميزان المراجعة
    public function balance(Request $request)
    {
        $accounts = SubAccount::get();
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
        $sum1 = 0;
        $sum2 = 0;
        foreach ($accounts as $account) {

            $entrys = Ledger::where('credit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->orwhere('debit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->get();
            $creditSum = 0;
            $debitSum = 0;
            foreach ($entrys as $entry) {
                if ($entry->credit != $account->id) {
                    $creditSum += $entry->c_amount;
                }
                if ($entry->debit != $account->id) {
                    $debitSum += $entry->d_amount;
                }
            }
            if ($creditSum > $debitSum) {
                $stage = $creditSum - $debitSum;
                $myA[$account->id]["name"] = $account->name;
                $myA[$account->id]["price"] = $stage;
                $myA[$account->id]["state"] = "credit";
                $sum1 += $stage;
            } else {
                $stage = $debitSum - $creditSum;
                $myA[$account->id]["name"] = $account->name;
                $myA[$account->id]["price"] = $stage;
                $myA[$account->id]["state"] = "debit";
                $sum2 += $stage;
            }
        }
        return view('accounts.balance')
            ->with('myA', $myA)
            ->with('sum2', $sum2)
            ->with('sum1', $sum1)
            ->with('entrys', $entrys)
            ->with('to', $to)
            ->with('from', $from);
    }

    # قائمة الدخل
    public function income(Request $request)
    {
        $accounts = SubAccount::get();
        $myA = array();
        $myB = array();
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
        $sum1 = 0;
        $sum2 = 0;
        foreach ($accounts as $account) {
            $entrys = Ledger::where('credit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->orwhere('debit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->get();
            $creditSum = 0;
            $debitSum = 0;
            foreach ($entrys as $entry) {
                if ($entry->credit != $account->id) {
                    $creditSum += $entry->c_amount;
                }
                if ($entry->debit != $account->id) {
                    $debitSum += $entry->d_amount;
                }
            }
            if ($account->main_accounts_id == 4) { # إيرادات
                if ($creditSum > $debitSum) {
                    $myA[$account->id]["name"] = $account->name;
                    $myA[$account->id]["price"] = $creditSum;
                    $myA[$account->id]["state"] = "credit";
                } else {
                    $myA[$account->id]["name"] = $account->name;
                    $myA[$account->id]["price"] = $debitSum;
                    $myA[$account->id]["state"] = "debit";
                }
                $sum1 += $debitSum;
            } elseif ($account->main_accounts_id == 2) { # مصروفات
                if ($creditSum > $debitSum) {
                    $myB[$account->id]["name"] = $account->name;
                    $myB[$account->id]["price"] = $creditSum;
                    $myB[$account->id]["state"] = "credit";
                } else {
                    $myB[$account->id]["name"] = $account->name;
                    $myB[$account->id]["price"] = $debitSum;
                    $myB[$account->id]["state"] = "debit";
                }
                $sum2 += $creditSum;
            }
        }
        return view('accounts.income')
            ->with('myA', $myA)
            ->with('myB', $myB)
            ->with('sum1', $sum1)
            ->with('sum2', $sum2)
            ->with('from', $from)
            ->with('to', $to);
    }

    # قائمة الدخل المالي
    public function incomeStatement(Request $request)
    {
        $accounts = SubAccount::get();
        $myA = array();
        $myB = array();
        $myC = array();
        $myD = array();
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
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $sum4 = 0;
        $income = 0;
        foreach ($accounts as $account) {
            $entrys = Ledger::where('credit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->orwhere('debit', '=', $account->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $from . " 00:00:00",
                    $to . " 23:59:59"
                ]
            )->get();
            $creditSum = 0;
            $debitSum = 0;
            foreach ($entrys as $entry) {
                if ($entry->credit != $account->id) {
                    $creditSum += $entry->c_amount;
                }
                if ($entry->debit != $account->id) {
                    $debitSum += $entry->d_amount;
                }
            }
            if ($account->main_accounts_id == 1) { # الاصول
                if ($creditSum > $debitSum) {
                    $stage = $creditSum - $debitSum;
                    $myA[$account->id]["name"] = $account->name;
                    $myA[$account->id]["price"] = $stage;
                    $myA[$account->id]["state"] = "credit";
                    $sum1 += $stage;
                } else {
                    $stage = $debitSum - $creditSum;
                    $myA[$account->id]["name"] = $account->name;
                    $myA[$account->id]["price"] = $stage;
                    $myA[$account->id]["state"] = "debit";
                    $sum1 += $stage;
                }
            } elseif ($account->main_accounts_id == 3 or $account->main_accounts_id == 5) { # خصوم حقوق ملاك
                if ($creditSum > $debitSum) {
                    $stage = $creditSum - $debitSum;
                    $myB[$account->id]["name"] = $account->name;
                    $myB[$account->id]["price"] = $stage;
                    $myB[$account->id]["state"] = "credit";
                    $sum2 += $stage;
                } else {
                    $stage = $debitSum - $creditSum;
                    $myB[$account->id]["name"] = $account->name;
                    $myB[$account->id]["price"] = $stage;
                    $myB[$account->id]["state"] = "debit";
                    $sum2 += $stage;
                }
            }

            # صافي الربح او الخسارة
            $creditSum1 = 0;
            $debitSum1 = 0;
            foreach ($entrys as $entry) {
                if ($entry->credit != $account->id) {
                    $creditSum1 += $entry->c_amount;
                }
                if ($entry->debit != $account->id) {
                    $debitSum1 += $entry->d_amount;
                }
            }
            if ($account->main_accounts_id == 4) { # إيرادات
                if ($creditSum1 > $debitSum1) {
                    $myC[$account->id]["name"] = $account->name;
                    $myC[$account->id]["price"] = $creditSum1;
                    $myC[$account->id]["state"] = "credit";
                } else {
                    $myC[$account->id]["name"] = $account->name;
                    $myC[$account->id]["price"] = $debitSum1;
                    $myC[$account->id]["state"] = "debit";
                }
                $sum3 += $debitSum1;
            } elseif ($account->main_accounts_id == 2) { # مصروفات
                if ($creditSum1 > $debitSum1) {
                    $myD[$account->id]["name"] = $account->name;
                    $myD[$account->id]["price"] = $creditSum1;
                    $myD[$account->id]["state"] = "credit";
                } else {
                    $myD[$account->id]["name"] = $account->name;
                    $myD[$account->id]["price"] = $debitSum1;
                    $myD[$account->id]["state"] = "debit";
                }
                $sum4 += $creditSum1;
            }
        }
        if ($sum3 > $sum4) {
            $myB[$account->id]["name"] = "صافي ربح";
            $myB[$account->id]["price"] = $sum3 - $sum4;
            $myB[$account->id]["state"] = "debit";
            $income = $sum3 - $sum4;
        } elseif ($sum4 > $sum3) {
            $myB[$account->id]["name"] = "صافي خسارة";
            $myB[$account->id]["price"] = $sum3 - $sum4;
            $myB[$account->id]["state"] = "debit";
            $income = $sum3 - $sum4;
        } else {
            $myB[$account->id]["name"] = "الجانبان متساويان";
            $myB[$account->id]["price"] = $sum3 - $sum4;
            $myB[$account->id]["state"] = "debit";
            $income = $sum3 - $sum4;
        }
        $sum2 += $income;
        return view('accounts.incomeStatement')
            ->with('myA', $myA)
            ->with('myB', $myB)
            ->with('sum1', $sum1)
            ->with('sum2', $sum2)
            ->with('from', $from)
            ->with('to', $to);
    }

    public function createPay()
    {
        $accounts = SubAccount::get();
        return view('accounts.pay.create')->with('accounts', $accounts);
    }
    # إنشاء سند دفع 
    public function pay(Request $request)
    {
        $this->validate($request, [
            'statement' => 'required',
            'credit' => 'required', # دائن
            'debit' => 'required', # مدين
            'c_amount' => '',
            'd_amount' => '',
            'user_id' => '',

        ]);

        // Create Pay
        $pay = new Ledger();
        $pay->statement = $request->input('statement');
        if (SubAccount::where('id', '=', $request->input('debit'))->exists()) {
            $pay->debit = $request->input('debit');
        }else{
            return redirect()->back()->with('error1', 'رقم الحساب غير صحيح ');
        }
        if (SubAccount::where('id', '=', $request->input('credit'))->exists()) {
            $pay->credit = $request->input('credit');
        }else{
            return redirect()->back()->with('error1', 'رقم الحساب غير صحيح ');
        }
        $pay->c_amount = $request->input('price');
        $pay->d_amount = $request->input('price');
        $pay->user_id = Auth::user()->id;
        $pay->save();

        return redirect('/pay')->with('success', 'تم انشاء قيد جديد');
    }

    public function destroy(Ledger $ledger)
    {
        //Check if ledger exists before deleting
        if (!isset($ledger)) {
            return redirect('/journal')->with('error', 'لا يوجد قيد بهذا الرقم');
        }

        $ledger->delete();

        return redirect('/journal')->with('danger', 'تم حذف القيد');
    }
}
