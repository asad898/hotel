<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $guests = Guest::where([
            ['name', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('institution', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('phone', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "desc")
            ->with('room')
            ->paginate(21);

        return view('guests.index', compact('guests'))
            ->with(`i`, (request()->input('page', 1) - 1) * 5);
        // $guests = Guest::latest()->paginate(30);
        // return view('guests.index')->with('guests', $guests);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => ['required', 'unique:guests'],
            'institution' => 'required',
            'user_id' => '',
            
        ]);

        // Create Guest
        $guest = new Guest;
        $guest->name = $request->input('name');
        $guest->phone = $request->input('phone');
        $guest->institution = $request->input('institution');
        $guest->user_id = Auth::user()->id;
        $guest->save();
        
        return redirect('/guests')->with('success', 'تم تسجيل نزيل جديد');
    }

    public function update(Request $request , Guest $guest)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'institution' => 'required',
            'user_id' => '',
        ]);

        // Update guest
        $guest->name = $request->input('name');
        $guest->phone = $request->input('phone');
        $guest->institution = $request->input('institution');
        $guest->user_id = Auth::user()->id;
        $guest->save();
        
        return redirect('/guests')->with('success', 'تم تحديث بيانات النزيل ');
    }

    public function destroy(Guest $guest)
    {
        //Check if post exists before deleting
        if (!isset($guest)){
            return redirect('/guests')->with('error', 'النزيل غير موجودة');
        }

        $guest->delete();
        return redirect('/guests')->with('success', 'تم حذف النزيل');
    }
}
