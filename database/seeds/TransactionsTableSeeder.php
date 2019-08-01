<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Transaction;
use App\TransactionDetail;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();
        TransactionDetail::truncate();
        $transactions = factory('App\Transaction', 10)
            ->create()
            ->each(function($transaction) {
                $details = [];
                foreach(range(1, mt_rand(1, 3)) as $j){
                    $details[] = factory('App\TransactionDetail')->make();
                }
                $transaction->details()->saveMany($details);
            });
    }
}
