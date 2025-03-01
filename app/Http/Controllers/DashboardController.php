<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
// your models
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil start_date dan end_date dari request, default 7 hari terakhir
        $startDateInput = $request->get('start_date', Carbon::now()->subDays(7)->format('Y-m-d'));
        $endDateInput   = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Convert ke Carbon untuk memastikan boundary-nya (mulai hari, akhir hari)
        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate   = Carbon::parse($endDateInput)->endOfDay();

        // -- Contoh ambil data summary yang sudah ada --
        $productCount      = Product::count();
        $revenue           = Transaction::whereNotNull('paid_at')->sum('total_price');
        $transactions      = Transaction::whereNotNull('paid_at')->get();
        $rawPriceTotal     = TransactionDetail::whereHas('transaction', function ($query) {
            $query->whereNotNull('paid_at');
        })
            ->join('products', 'transaction_details.products_id', '=', 'products.id')
            ->sum('products.raw_price');
        $netRevenue        = $revenue - $rawPriceTotal;
        $transactionPending = Transaction::where('transaction_status', 'pending')->count('transaction_status');

        // -- Ambil data khusus untuk tabel "5 Produk" + filter tanggal --
        $filteredDetails = TransactionDetail::with(['product', 'transaction'])
            ->whereHas('transaction', function ($q) {
                $q->whereNotNull('paid_at');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Group by product
        $grouped = $filteredDetails->groupBy('products_id')->map(function ($details) {
            $product = $details->first()->product;
            $qty     = $details->sum('qty');

            // Jika di tabel transaction_details ada field 'price' (harga jual per item), pakai itu.
            // Kalau tidak ada, bisa pakai $product->price.
            $gross = 0;
            $net   = 0;

            foreach ($details as $d) {
                // Asumsikan detail->price adalah harga jual per item
                $itemSellingPrice = $d->price ?? $product->price;
                $gross += ($itemSellingPrice * $d->qty);

                // Hitung net = (harga jual - raw_price) * qty
                $net += (($itemSellingPrice - $product->raw_price) * $d->qty);
            }

            return [
                'product_id'     => $product->id,
                'name'           => $product->name,
                'selling_price'  => $product->price,
                'total_qty'      => $qty,
                'gross_revenue'  => $gross,
                'net_revenue'    => $net,
            ];
        });

        // Urutkan (misalnya) berdasarkan qty tertinggi, lalu ambil 5 saja
        $topProducts = $grouped->sortByDesc('total_qty')->take(5);

        // Hitung total di footer
        $totals = [
            'total_qty'     => $topProducts->sum('total_qty'),
            'gross_revenue' => $topProducts->sum('gross_revenue'),
            'net_revenue'   => $topProducts->sum('net_revenue'),
        ];

        // -- Ambil data untuk chart (Tidak di-filter oleh date; jika mau pun, boleh filter di atas)
        $transactionDetails = TransactionDetail::with(['product', 'transaction'])
            ->whereHas('transaction', function ($query) {
                $query->whereNotNull('paid_at');
            })
            ->get();

        $salesData = $transactionDetails->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })->map(function ($monthGroup) {
            return $monthGroup->groupBy('products_id')->map(function ($productGroup) {
                return [
                    'name' => $productGroup->first()->product->name,
                    'qty'  => $productGroup->sum('qty')
                ];
            });
        });

        // Statistik penjualan bulanan (tidak diubah)
        $currentMonth   = Carbon::now()->format('Y-m');
        $previousMonth  = Carbon::now()->subMonth()->format('Y-m');
        $salesStatistics = $transactionDetails
            ->groupBy('products_id')
            ->map(function ($productGroup) use ($currentMonth, $previousMonth) {
                $product          = $productGroup->first()->product;
                $currentMonthSales = $productGroup->whereBetween('created_at', [
                    Carbon::parse($currentMonth)->startOfMonth(),
                    Carbon::parse($currentMonth)->endOfMonth()
                ])->sum('qty');
                $previousMonthSales = $productGroup->whereBetween('created_at', [
                    Carbon::parse($previousMonth)->startOfMonth(),
                    Carbon::parse($previousMonth)->endOfMonth()
                ])->sum('qty');

                $trend = 'neutral';
                if ($currentMonthSales > $previousMonthSales) {
                    $trend = 'up';
                } elseif ($currentMonthSales < $previousMonthSales) {
                    $trend = 'down';
                }
                return [
                    'product_name'        => $product->name,
                    'current_month_sales' => $currentMonthSales,
                    'trend'               => $trend,
                ];
            })->values()->sortByDesc('current_month_sales')->toArray();

        // =============================
        // RETURN JSON IF AJAX REQUEST
        // =============================
        if ($request->ajax()) {
            return response()->json([
                'startDate'     => $startDate->format('Y-m-d'),
                'endDate'       => $endDate->format('Y-m-d'),
                'topProducts'   => $topProducts->values(), // convert collection to array
                'totals'        => $totals,
                'salesData'     => $salesData,
                // If you also need to update the monthly stats table via Ajax, you can include it here:
                // 'salesStatistics' => $salesStatistics,
            ]);
        }

        // =============================
        // OTHERWISE, RETURN BLADE VIEW
        // =============================
        return view('pages.admin.home', [
            'salesData'          => $salesData,
            'salesStatistics'    => $salesStatistics,
            'currentMonth'       => $currentMonth,
            'productCount'       => $productCount,
            'revenue'            => $revenue,
            'netRevenue'         => $netRevenue,
            'transactionPending' => $transactionPending,

            'topProducts'        => $topProducts,
            'totals'             => $totals,
            'startDate'          => $startDate->format('Y-m-d'),
            'endDate'            => $endDate->format('Y-m-d'),
        ]);
    }
}
