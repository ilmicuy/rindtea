<?php

namespace App\Providers;

use App\Models\Inbox;
use App\Models\IngredientRequest;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('includes.admin.header', function ($view) {
            // Assuming you want to get all inbox messages for the authenticated user
            $userId = auth()->id();
            $inboxes = Inbox::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();
            $unreadInboxes = $inboxes->where('is_read', 0)->count();

            $getIngredientRequest = 0;
            $getProductRequest = 0;

            if(auth()->user()->roles->first()->name == 'produksi'){
                $getProductRequest = ProductRequest::where('status', 'pending')->count();
            }

            if(auth()->user()->roles->first()->name == 'keuangan'){
                $getIngredientRequest = IngredientRequest::where('status', 'pending')->count();
            }

            $products = Product::all();
            $lowStockProducts = $products->filter(function ($product) {
                return $product->quantity < 10;
            });

            $hasLowStock = $lowStockProducts->isNotEmpty();

            $view->with('inboxes', $inboxes)
            ->with('unreadInboxes', $unreadInboxes)
            ->with('getProductRequest', $getProductRequest)
            ->with('getIngredientRequest', $getIngredientRequest)
            ->with('lowStockProducts', $lowStockProducts)
            ->with('hasLowStock', $hasLowStock);
        });
    }
}
