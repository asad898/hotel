<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $institutions = Institution::where([
            ['id', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                    $query->orWhere('id', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "asc")
            ->with('user')
            ->paginate(10);

        return view('institutions.index', compact('institutions'))
            ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => ''
        ]);

        // New Institution
        $institution = new Institution;
        $institution->name = $request->input('name');
        $institution->user_id = Auth::user()->id;
        $institution->save();
        
        return redirect('/institutions')->with('success', 'تم حفظ مؤسسة جديد');
    }

    public function update(Request $request, Institution $institution)
    {
        $this->validate($request, [
            'name' => 'required',
            'user_id' => ''
        ]);

        // Update Institution
        $institution->name = $request->input('name');
        $institution->user_id = Auth::user()->id;
        $institution->save();
        
        return redirect('/institutions')->with('success', 'تم تحديث مؤسسة');
    }
}
