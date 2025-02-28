<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCount = Product::count();
        $revenue = Transaction::whereNotNull('paid_at')->sum('total_price');

        $transactions = Transaction::whereNotNull('paid_at')->get();
        $rawPriceTotal = TransactionDetail::whereHas('transaction', function ($query) {
            $query->whereNotNull('paid_at');
        })->join('products', 'transaction_details.products_id', '=', 'products.id')
        ->sum('products.raw_price');

        $netRevenue = $revenue - $rawPriceTotal;

        $transactionPending = Transaction::where('transaction_status', 'pending')->count('transaction_status');

        // Fetch all transaction details with products and transactions
        $transactionDetails = TransactionDetail::with(['product', 'transaction'])
        ->whereHas('transaction', function ($query) {
            $query->whereNotNull('paid_at');
        })
            ->get();

        // Group by year-month and then by product ID
        $salesData = $transactionDetails->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->map(function ($monthGroup) {
            return $monthGroup->groupBy('products_id')->map(function ($productGroup) {
                return [
                    'name' => $productGroup->first()->product->name,
                    'qty' => $productGroup->sum('qty')
                ];
            });
        });

        // Get current and previous month's sales
        $currentMonth = Carbon::now()->format('Y-m');
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');

        $salesStatistics = $transactionDetails->groupBy('products_id')->map(function ($productGroup) use ($currentMonth, $previousMonth) {
            $product = $productGroup->first()->product;
            $currentMonthSales = $productGroup->whereBetween('created_at', [Carbon::parse($currentMonth)->startOfMonth(), Carbon::parse($currentMonth)->endOfMonth()])->sum('qty');
            $previousMonthSales = $productGroup->whereBetween('created_at', [Carbon::parse($previousMonth)->startOfMonth(), Carbon::parse($previousMonth)->endOfMonth()])->sum('qty');

            $trend = 'neutral';
            if ($currentMonthSales > $previousMonthSales) {
                $trend = 'up';
            } elseif ($currentMonthSales < $previousMonthSales) {
                $trend = 'down';
            }

            return [
                'product_name' => $product->name,
                'current_month_sales' => $currentMonthSales,
                'trend' => $trend,
            ];
        })->values()->sortByDesc('current_month_sales')->toArray();

        return view('pages.admin.home', [
            'salesData' => $salesData,
            'salesStatistics' => $salesStatistics,
            'currentMonth' => $currentMonth,
            'productCount' => $productCount,
            'revenue' => $revenue,
            'netRevenue' => $netRevenue,
            'transactionPending' => $transactionPending
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
