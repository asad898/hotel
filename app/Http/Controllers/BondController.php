<?php

namespace App\Http\Controllers;

use App\Models\Bond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BondController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'dept' => 'required',
            'user_id' => '',
            'admin_conf' => ''
        ]);

        // Create bond
        $bond = new Bond();
        $bond->body = $request->input('body');
        $bond->dept = $request->input('dept');
        $bond->user_id = Auth::user()->id;
        $bond->save();
        
        return redirect()->back()->with('success', 'تم إنشاء السند, في إنتظار موافقة الإدارة');
    }

    public function create()
    {
        $bonds = Bond::orderBy('created_at', 'desc')->paginate(15);
        return view('bonds.create')->with('bonds', $bonds);
    }

    public function edit(Bond $bond)
    {
        return view('bonds.edit')->with('bond', $bond);
    }

    public function update(Request $request, Bond $bond)
    {
        $this->validate($request, [
            'body' => 'required',
            'dept' => 'required',
            'admin_conf' => ''
        ]);
        if ($request->input('admin_conf') == false) {
            $ch = 0;
        } else {
            $ch = 1;
        }
        $bond->admin_conf = $ch;
        // Create bond
        $bond->body = $request->input('body');
        $bond->dept = $request->input('dept');
        $bond->save();
        
        return redirect()->back()->with('success', 'تم تعديل, السند');
    }

    public function destroy(Bond $bond)
    {
        //Check if post exists before deleting
        if (!isset($bond)) {
            return redirect()->back()->with('error', 'السند غير موجودة');
        }
        
        $bond->delete();
        return redirect()->back()->with('success', 'تم حذف السند');
    }

    public function admin()
    {
        $bonds = Bond::orderBy('created_at', 'desc')->paginate(15);
        return view('bonds.admin')->with('bonds', $bonds);
    }

    public function am()
    {
        $bonds = Bond::orderBy('created_at', 'desc')->paginate(15);
        return view('bonds.am')->with('bonds', $bonds);
    }

    public function old()
    {
        $bonds = Bond::orderBy('created_at', 'desc')->onlyTrashed()->paginate(15);
        return view('bonds.old')->with('bonds', $bonds);
    }

}
