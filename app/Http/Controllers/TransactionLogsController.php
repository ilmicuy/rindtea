<?php

namespace App\Http\Controllers;

use App\Models\TransactionLog;
use Illuminate\Http\Request;
use PDF; // Make sure you have this package installed

class TransactionLogsController extends Controller
{
    /**
     * Display a listing of the transaction logs.
     */
    public function transactionLogs(Request $request)
    {
        $transactionLogs = TransactionLog::orderBy('created_at', 'DESC')->paginate(10);

        return view('pages.admin.transactionLogs.index', [
            'transactionLogs' => $transactionLogs
        ]);
    }

    /**
     * Download a PDF of the transaction logs.
     */
    public function downloadPdf()
    {
        $transactionLogs = TransactionLog::with(['loggable', 'user'])->get();

        // Load the view for the PDF
        $pdf = PDF::loadView('pages.admin.transactionLogs.transactionLogsPdf', compact('transactionLogs'));

        // Stream the PDF back to the user for download
        return $pdf->download('transaction_logs.pdf');
    }
}
