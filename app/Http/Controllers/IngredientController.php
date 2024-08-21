<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Paginate ingredients
        $ingredients = Ingredient::paginate(10);

        // Filter low stock ingredients based on 'pcs' and 'gram' units
        $lowStockIngredients = Ingredient::all()->filter(function ($ingredient) {
            return ($ingredient->satuan == 'pcs' && $ingredient->qty < 50) ||
                ($ingredient->satuan == 'gram' && $ingredient->qty < 1000);
        });

        // Check if there are any low stock ingredients
        $hasLowStock = $lowStockIngredients->isNotEmpty();

        return view('pages.admin.ingredient.index', [
            'ingredients' => $ingredients,
            'hasLowStock' => $hasLowStock,
            'lowStockIngredients' => $lowStockIngredients,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('pages.admin.ingredient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ingredient::create([
            'kode_bahan_baku' => (new Ingredient)->generateKodeBahanBaku(),
            'nama_bahan_baku' => $request->nama_bahan_baku,
            'qty' => abs($request->qty),
            'satuan' => $request->satuan,
        ]);

        return redirect(route("ingredient.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
