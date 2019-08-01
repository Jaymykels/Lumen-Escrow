<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Transaction;
use App\MigrateFreshSeedOnce;

class TransactionTest extends TestCase
{
    use MigrateFreshSeedOnce;

    public function testShouldGetAllTransactions(){
        $this->get("api/v1/transactions", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['*' => 
                [
                    'sender_email',
                    'sender_phone',
                    'receiver_email',
                    'receiver_phone',
                    'updated_at',
                    'created_at',
                    'id',
                    'details' => [
                        '*' => [
                            'title',
                            'description',
                            'price'
                        ]
                    ]
                ]    
            ]
        );
    }
    
    public function testShouldCreateTransaction(){
        $parameters = [
            "sender_email" => "jaymykels69@gmail.com",
            "sender_phone" => "2356557576768",
            "receiver_email" => "test@yahoo.com",
            "receiver_phone" => "089876654334",
            "details" => [
                [
                    "title" => "Awesome Package",
                    "description" => "Great stuffs only",
                    "price" => 10000
                ],
                [
                    "title" => "Wawuuu",
                    "description" => "It happened Eventually",
                    "price" => 450000
                ]
            ]
        ];
        $this->post("api/v1/transactions", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'sender_email',
                'sender_phone',
                'receiver_email',
                'receiver_phone',
                'updated_at',
                'created_at',
                'id',
                'details'
            ]    
        );
    }

    public function testShouldUpdateTransaction(){
        $parameters = Transaction::with('details')->first()->toArray();
        $parameters['receiver_email'] = 'barnbie@yahoo.com';
        $details[] = array_pop($parameters['details']);
        $details[] = [
            "title" => "Crazy Shit",
            "description" => "You dunno wats going on",
            "price" => 450000
        ];
        $parameters['details'] = $details;
        $this->put("api/v1/transactions/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'sender_email',
                'sender_phone',
                'receiver_email',
                'receiver_phone',
                'updated_at',
                'created_at',
                'id',
                'details'
            ]    
        );
        $this->seeJson(
            [
                'receiver_email' => 'barnbie@yahoo.com',
            ]
        );
    }

    public function testShouldDeleteTransaction(){
        $this->delete("api/v1/transactions/1", [], []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => 'transaction removed successfully'
        ]);
    }
}
