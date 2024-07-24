<?php

namespace App\Http\Controllers;

use App\Models\ProductRequest;
use Illuminate\Http\Request;

class RequestProductController extends Controller
{
    public function index(Request $request)
    {
        $requestProduct = ProductRequest::paginate(10);

        return view('pages.admin.requestProduct.index', [
            'productRequest' => $requestProduct
        ]);
    }
}
