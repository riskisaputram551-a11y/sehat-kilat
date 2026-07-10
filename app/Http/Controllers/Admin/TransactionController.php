<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $transactions = Payment::with(['consultation.patient', 'consultation.doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $transaction = Payment::with(['consultation.patient', 'consultation.doctor'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $transaction = Payment::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        if ($request->status == 'paid') {
            $transaction->consultation->update(['status' => 'approved']);
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
    }
}