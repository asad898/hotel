<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::latest()->get();
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => '',
            'tel' => '',
            'role' => '',
            'education' => '',
            'address' => '',
            'skill' => '',
            'note' => '',
        ]);
        $user->username = $request->input('username');
        $user->tel = $request->input('tel');
        $user->role = $request->input('role');
        $user->profile()->update([
            'education' => $request->input('education'),
            'address' => $request->input('address'),
            'skill' => $request->input('skill'),
            'note' => $request->input('note'),
        ]);

        $user->save();

        return redirect('/users/'.$user->username)->with('success', 'تم تحديث البيانات');
    }

    public function roles(Request $request, User $user)
    {
        $this->validate($request, [
            'am' => '',
            'shm' => '',
            'ree' => '',
            'mm' => '',
            'rem' => '',
        ]);
        if( $request->input('am') == false ) {
            $ch1 = 0;
        } else {
            $ch1 = 1;
        }
        if( $request->input('shm') == false ) {
            $ch2 = 0;
        } else {
            $ch2 = 1;
        }
        if( $request->input('ree') == false ) {
            $ch3 = 0;
        } else {
            $ch3 = 1;
        }
        if( $request->input('mm') == false ) {
            $ch4 = 0;
        } else {
            $ch4 = 1;
        }
        if( $request->input('rem') == false ) {
            $ch5 = 0;
        } else {
            $ch5 = 1;
        }
        $user->am = $ch1;// مدير حسابات
        $user->shm = $ch2;// مدير إشراف
        $user->ree = $ch3;// موظف إستقبال
        $user->mm = $ch4;// مدير عام
        $user->rem = $ch5;// مدير إستقبال

        $user->save();
        return redirect()->back()->with('success', 'تم تحديث الصلاحيات');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //Check if post exists before deleting
        if (!isset($user)){
            return redirect('/users')->with('error', 'المستخدم غير موجودة');
        }
        
        $user->profile()->delete();
        $user->delete();
        return redirect('users')->with('danger', 'تم حذف المستخدم');
    }
}
