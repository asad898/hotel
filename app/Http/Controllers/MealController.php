<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
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
        return view('meals.index', compact('meals'))
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

        // New Meal
        $meal->name = $request->input('name');
        $meal->price = $request->input('price');
        $meal->save();
        
        return redirect('/meals')->with('success', 'تم تحديث بيانات الوجبة');
    }
}
