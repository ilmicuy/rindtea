<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\ProductRequest;
use App\Http\Requests\admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::paginate(10);

        $lowStockProducts = Product::all()->filter(function ($product) {
            return $product->quantity < 10;
        });

        $hasLowStock = $lowStockProducts->isNotEmpty();

        return view('pages.admin.product.index', [
            'query' => $query,
            'hasLowStock' => $hasLowStock,
            'lowStockProducts' => $lowStockProducts,
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

        if ($request->has('opsi_pengiriman')) {
            $data['opsi_pengiriman'] = json_encode($request->opsi_pengiriman);
        }

        $product = Product::create($data);

        $bahanBakuData = [];
        foreach ($request->list_bahan_baku as $bahan_baku) {
            $bahanBakuData[$bahan_baku['bahan_baku']] = ['qty_needed' => $bahan_baku['qty_needed']];
        }

        $product->ingredients()->sync($bahanBakuData);

        // Log the initial product creation
        ProductTransaction::create([
            'product_id' => $product->id,
            'transaction_id' => null, // No specific transaction ID for initial creation
            'user_id' => Auth::user()->id,
            'transaction_type' => 'initial',
            'quantity' => 0,
            'old_quantity' => null,
            'new_quantity' => 0,
            'transaction_date' => Carbon::now(),
            'description' => 'Initial creation of product',
        ]);

        return redirect()->route('product.index');
    }

    public function productTransactions(Request $request)
    {
        $productTransaction = ProductTransaction::orderBy('created_at', 'DESC')->paginate(10);

        return view('pages.admin.product.productTransaction', [
            'transactions' => $productTransaction
        ]);
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
        // Retrieve all form data
        $data = $request->all();

        // Generate a slug from the product name
        $data['slug'] = Str::slug($request->name);

        // Handle file upload if a new photo is provided
        if ($request->hasFile('photos')) {
            $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        }

        // Handle the opsi_pengiriman field, encode it as JSON
        if ($request->has('opsi_pengiriman')) {
            $data['opsi_pengiriman'] = json_encode($request->opsi_pengiriman);
        }

        // Find the product by its ID and update it with the new data
        $item = Product::findOrFail($id);
        $item->update($data);

        // Prepare the ingredients data for syncing
        $bahanBakuData = [];
        foreach ($request->list_bahan_baku as $bahan_baku) {
            $bahanBakuData[$bahan_baku['bahan_baku']] = ['qty_needed' => $bahan_baku['qty_needed']];
        }

        // Sync the ingredients with the product
        $item->ingredients()->sync($bahanBakuData);

        // Redirect back to the edit page with a success message
        return redirect()->route('product.edit', $id)->with('success', 'Product updated successfully.');
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
