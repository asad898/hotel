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
            'type' => 'required',
            'price' => '',
        ]);

        // Create sub account
        $subAccount = new SubAccount();
        $subAccount->name = $request->input('name');
        $subAccount->main_accounts_id = $request->input('main_accounts_id');
        $subAccount->type = $request->input('type');
        $subAccount->price = $request->input('price');
        $subAccount->save();

        return redirect('/main/accounts/'.$subAccount->main_accounts_id)->with('success', 'تم إضافة حساب جديد');
    }

    public function update(Request $request, SubAccount $subAccount)
    {
        $this->validate($request, [
            'name' => 'required',
            'main_accounts_id' => 'required',
            'type' => 'required',
            'price' => '',
        ]);

        // update sub account
        $subAccount->name = $request->input('name');
        $subAccount->main_accounts_id = $request->input('main_accounts_id');
        $subAccount->type = $request->input('type');
        $subAccount->price = $request->input('price');
        $subAccount->save();

        return redirect('/main/accounts/'.$subAccount->main_accounts_id)->with('success', 'تم تعديل الحساب');
    }
}
