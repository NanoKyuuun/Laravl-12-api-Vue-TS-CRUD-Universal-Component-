<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makanans = Makanan::all();
        foreach ($makanans as $makanan) {
            if ($makanan->img_makanan) {
                $makanan->img_makanan = asset('storage/public/makanan/' . $makanan->img_makanan);
            }
        }
        return response()->json([
            'makanans' => $makanans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'img_makanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
        ]);

        $fileName = null;
        if ($request->file('img_makanan')) {
            $fileName = time() . '_' . $request->file('img_makanan')->getClientOriginalName();
            $request->file('img_makanan')->storeAs('public/makanan', $fileName);
        }

        $makanan = Makanan::create([
            'name' => $request->name,
            'description' => $request->description,
            'img_makanan' => $fileName,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Makanan created successfully',
            'makanan' => $makanan,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Makanan $makanan)
    {
        return response()->json([
            'makanan' => $makanan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Makanan $makanan)
    {
        return response()->json([
            'makanan' => $makanan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Makanan $makanan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'img_makanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
        ]);

        $fileName = $makanan->img_makanan;
        if ($request->file('img_makanan')) {
            $fileName = time() . '_' . $request->file('img_makanan')->getClientOriginalName();
            $request->file('img_makanan')->storeAs('public/makanan', $fileName);
        }

        $makanan->update([
            'name' => $request->name,
            'description' => $request->description,
            'img_makanan' => $fileName,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Makanan updated successfully',
            'makanan' => $makanan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Makanan $makanan)
    {
        if ($makanan->img_makanan) {
            Storage::delete('public/makanan/' . $makanan->img_makanan);
        }
        $makanan->delete();

        return response()->json([
            'message' => 'Makanan deleted successfully',
        ]);
    }
}
