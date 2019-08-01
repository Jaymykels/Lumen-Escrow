<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    { 
        $transactions = Transaction::with('details')->get();
        return response()->json($transactions);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'sender_email' => 'required|max:255',
            'sender_phone' => 'required|max:255',
            'receiver_email' => 'required|max:255',
            'receiver_phone' => 'required|max:255',
            'details' => 'required|array|min:1',
            'details.*.title' => 'required|max:255',
            'details.*.description' => 'required|max:3000',
            'details.*.price' => 'required|numeric|min:0',
        ]);

        $requestData = $request->only(['sender_email', 'sender_phone', 'receiver_email', 'receiver_phone']);
        $details = [];
        foreach($request->details as $detail) {
            $details[] = new TransactionDetail($detail);
        }
        $transaction = Transaction::create($requestData);
        $transaction->details()->saveMany($details);
        return response()->json($transaction->load('details'));
    }
     
    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'sender_email' => 'max:255',
            'sender_phone' => 'max:255',
            'receiver_email' => 'max:255',
            'receiver_phone' => 'max:255',
            'details' => 'array',
            'details.*.title' => 'max:255',
            'details.*.description' => '|max:3000',
            'details.*.price' => 'numeric|min:0',
        ]);

        $transaction = Transaction::findOrFail($id);
        $details = [];
        $detailsUpdated = [];
        $transactionData = $request->only(['sender_email', 'sender_phone', 'receiver_email', 'receiver_phone']);

        foreach($request->details as $detail) {
            if(isset($detail['id'])) {
                TransactionDetail::where('transaction_id', $transaction->id)
                    ->where('id', $detail['id'])
                    ->update($detail);
                $detailsUpdated[] = $detail['id'];
            } else {
                $details[] = new TransactionDetail($detail);
            }
        }

        $transaction->update($transactionData);

        TransactionDetail::whereNotIn('id', $detailsUpdated)
            ->where('transaction_id', $transaction->id)
            ->delete();

        if(count($details)){
            $transaction->details()->saveMany($details);
        }

        return response()->json($transaction->load('details'));
    }
    
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        TransactionDetail::where('transaction_id', $transaction->id)->delete();
        $transaction->delete();
        return response()->json(['message' => 'transaction removed successfully']);
    }
}
