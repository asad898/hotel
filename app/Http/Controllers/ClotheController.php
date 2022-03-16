<?php

namespace App\Http\Controllers;

use App\Models\Clothe;
use App\Models\LaundryTax;
use App\Models\Room;
use Illuminate\Http\Request;

class ClotheController extends Controller
{
    public function index(Request $request)
    {
        $tax = LaundryTax::find(1);
        $rooms = Room::latest()->get();
        $clothes = Clothe::where([
            ['name', '!=', Null],
            [function ($query) use ($request){
                if (($term = $request->term)){
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
        ->orderBy("id", "asc")
        ->get();
        return view('clothes.index', compact(['clothes', 'tax', 'rooms']))
        ->with(`i`, (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            
        ]);

        // New Clothe
        $clothe = new Clothe;
        $clothe->name = $request->input('name');
        $clothe->price = $request->input('price');
        $clothe->save();
        
        return redirect('/clothes')->with('success', 'تم حفظ نوع ملبوسات جديد');
    }

    public function update(Request $request, Clothe $clothe)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            
        ]);

        // New clothe
        $clothe->name = $request->input('name');
        $clothe->price = $request->input('price');
        $clothe->save();
        
        return redirect('/clothes')->with('success', 'تم تحديث بيانات الملبوسات');
    }

    public function taxUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'tax' => 'required',
            'tourism' => 'required',
            
        ]);
        $tax = LaundryTax::find($id);
        // update tax
        $tax->tax = $request->input('tax');
        $tax->stamp = $request->input('tourism');
        $tax->save();
        
        return redirect('/meals')->with('success', 'تم تحديث الضريبة');
    }
}
