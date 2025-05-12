<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Display a listing of the materials
    public function index()
    {
        $materials = Material::all();
        return view('materials.index', compact('materials'));
    }

    // Show the form for creating a new material
    public function create()
    {
        return view('materials.create');
    }

    // Store a newly created material in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'count' => 'required|integer',
            'sq_ft' => 'required|numeric|min:0',
        ]);

        Material::create($request->all());

        return redirect()->route('materials.index')->with('success', 'Material added successfully');
    }

    // Show the form for editing the specified material
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    // Update the specified material in storage
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'count' => 'required|integer',
            'sq_ft' => 'required|numeric|min:0',
        ]);

        $material->update($request->all());

        return redirect()->route('materials.index')->with('success', 'Material updated successfully');
    }

    // Remove the specified material from storage
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully');
    }

    public function getMaterialDetails($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        return response()->json([
            'sqft' => $material->sq_ft ?? 0 
        ]);
    }

}
