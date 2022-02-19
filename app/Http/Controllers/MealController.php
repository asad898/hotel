<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\RestTax;
use App\Models\Room;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $tax = RestTax::find(1);
        $rooms = Room::latest()->get();
        $meals = Meal::where([
            ['name', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->orderBy("id", "asc")
        ->get();
        return view('meals.index', compact(['meals', 'tax', 'rooms']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            
        ]);

        // New Meal
        $meal = new Meal;
        $meal->name = $request->input('name');
        $meal->price = $request->input('price');
        $meal->save();
        
        return redirect('/meals')->with('success', 'تم حفظ وجبة جديدة');
    }

    public function update(Request $request, Meal $meal)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            
        ]);

        // update Meal
        $meal->name = $request->input('name');
        $meal->price = $request->input('price');
        $meal->save();
        
        return redirect('/meals')->with('success', 'تم تحديث بيانات الوجبة');
    }

    public function taxUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'tax' => 'required',
            'tourism' => 'required',
            
        ]);
        $tax = RestTax::find($id);
        // update tax
        $tax->tax = $request->input('tax');
        $tax->tourism = $request->input('tourism');
        $tax->save();
        
        return redirect('/meals')->with('success', 'تم تحديث الضريبة');
    }
}
