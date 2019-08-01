<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_email', 'sender_phone', 'receiver_email', 'receiver_phone'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
