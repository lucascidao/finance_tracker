<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function listIncome()
    {
        return $this->model->where('type', 'income')->get();
    }

    public function listExpense()
    {
        return $this->model->where('type', 'expense')->get();
    }

}