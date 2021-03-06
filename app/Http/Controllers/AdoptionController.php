<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdoptionController extends Controller {

    public function create() {
        return view('adoptions.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'        => ['required'],
            'description' => ['required'],
            'image'       => ['file', 'image']
        ]);


        $adoption = new Adoption();
        if ($request->has('image'))  {
            $filename = Str::random(32) . "." . $request->file('image')->extension();
            $request->file('image')->move('imgs/uploads', $filename);
            $adoption->image_path = "imgs/uploads/$filename";
        }
        else
            $adoption->image_path = "imgs/demo/4.jpg";
        $adoption->name        = $validated['name'];
        $adoption->description = $validated['description'];
        $adoption->listed_by   = auth()->id();
        $adoption->save();

        return redirect()->home()->with('success', "Post for $adoption->name created successfully");

    }

    public function show(Adoption $adoption) {
        return view('adoptions.details', ['adoption' => $adoption]);
    }

    public function adopt(Adoption $adoption) {
        $user = Auth::user();
        $adoption->adopted_by = $user->id;
        $adoption->save();

        return redirect()->home()->with('success', "Pet $adoption->name adopted successfully");
    }

    public function mine() {
        $adoptions = Adoption::where('adopted_by',Auth::user()->id)->get();
        return view('adoptions.list', ['adoptions' => $adoptions, 'header' => 'My Adoptions']);

    }
}
