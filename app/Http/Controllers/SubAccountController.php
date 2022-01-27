<?php

namespace App\Http\Controllers;

use App\Models\SubAccount;
use Illuminate\Http\Request;

class SubAccountController extends Controller
{
    public function index()
    {
        $subAccounts = SubAccount::orderBy('created_at', 'asc')->get();
        return view('accounts.mainAccounts.show')->with('subAccounts', $subAccounts);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'main_accounts_id' => 'required',
            'price' => '',
        ]);

        // Create Room
        $subAccount = new SubAccount();
        $subAccount->name = $request->input('name');
        $subAccount->main_accounts_id = $request->input('main_accounts_id');
        $subAccount->price = $request->input('price');
        $subAccount->save();

        return redirect('/main/accounts/'.$subAccount->main_accounts_id)->with('success', 'تم إضافة حساب جديد');
    }
}
