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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
