<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\ProductRequest;
use App\Http\Requests\admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::paginate(10);

        return view('pages.admin.product.index', [
            'query' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $bahanBaku = Ingredient::all();

        return view('pages.admin.product.create', [
            'categories' => $categories,
            'ingredients' => $bahanBaku
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        $data['quantity'] = 0;

        $product = Product::create($data);

        $bahanBakuData = [];
        foreach ($request->list_bahan_baku as $bahan_baku) {
            $bahanBakuData[$bahan_baku['bahan_baku']] = ['qty_needed' => $bahan_baku['qty_needed']];
        }

        $product->ingredients()->sync($bahanBakuData);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $categories = Category::all();
        $bahanBaku = Ingredient::all();

        return view('pages.admin.product.edit', [
            'item' => $item,
            'categories' => $categories,
            'ingredients' => $bahanBaku
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        if ($request->hasFile('photos')) {
            $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        }

        $item = Product::findOrFail($id);

        $item->update($data);


        $bahanBakuData = [];
        foreach ($request->list_bahan_baku as $bahan_baku) {
            $bahanBakuData[$bahan_baku['bahan_baku']] = ['qty_needed' => $bahan_baku['qty_needed']];

            // $bahanBakuData[] = [
            //     'ingredient_id' => $bahan_baku['bahan_baku'],
            //     'qty_needed' => $bahan_baku['qty_needed']
            // ];
        }

        $item->ingredients()->sync($bahanBakuData);

        return redirect()->route('product.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }
}
