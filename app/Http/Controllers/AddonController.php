<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index() {
        $addons = Addon::orderBy('name')->get();

        return view('addons.index',[
            'addons' => $addons
        ]);
    }

    public function show(Addon $addon) {
        return view('addons.view', ['addon'=>$addon]);
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'name' => 'string|required',
            'description' => 'string|required',
            'addon_type' => 'string|required',
            'amount' => 'numeric|required',
        ]);

        Addon::create($fields);

        return redirect('/addons')->with('Info','New addon has been created');
    }

    public function update(Request $request, Addon $addon) {
        $addon->update($request->all());

        return back()->with('Info','This addon has been updated.');
    }

    public function destroy(Addon $addon) {
        $name = $addon->name;
        $addon->delete();
        return redirect('/addons')->with('Info',"$name addon has been deleted.");
    }
}
