<?php

namespace App\Http\Controllers;

use App\Models\MainAccount;
use App\Models\SubAccount;
use Illuminate\Http\Request;

class MainAccountController extends Controller
{
    public function index()
    {
        $mainAccounts = MainAccount::orderBy('created_at', 'asc')->get();
        return view('accounts.mainAccounts.index')->with('mainAccounts', $mainAccounts);
    }

    public function show(MainAccount $mainAccount)
    {
        $subAccounts = SubAccount::orderBy('created_at', 'asc')->get();
        return view('accounts.mainAccounts.show')->with('mainAccount', $mainAccount)->with('subAccounts', $subAccounts);
    }

    # معادلة الميزانية
    public function budget()
    {
        $sum1 = 0;
        $sum2 = 0;
        $mainAccounts = MainAccount::orderBy('created_at', 'asc')->get();
        foreach($mainAccounts as $account){
            if($account->id == 1 or $account->id == 2){
                $sum1 += $account->price;
            }
            if($account->id == 3 or $account->id == 4 or $account->id == 5){
                $sum2 += $account->price;
            }
        }
        return view('accounts.budget')->with('mainAccounts', $mainAccounts)->with('sum1', $sum1)->with('sum2', $sum2);
    }
}
