<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'amount',
        'payment_date',
        'due_date',
        'status',
        'payment_method',
        'transaction_id',
        'notes',
        // Add the new fields
        'card_last_four',
        'card_type',
        'bank_name',
        'wallet_type',
        'wallet_transaction_id',
        'check_number',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Invoice related methods
    public function getInvoiceNumberAttribute()
    {
        return 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }
}
