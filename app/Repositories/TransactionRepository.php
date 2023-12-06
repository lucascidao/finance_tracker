<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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

    public function expensesSum()
    {
        $expense =  $this->model->where('type', 'expense')->select('amount')->sum('amount');
        $income =  $this->model->where('type', 'income')->select('amount')->sum('amount');
        return response()->json([
            'expense' => $expense,
            'income' => $income,
            'total' => $income - $expense
        ]);
    }

    public function expensesSumLastMonths()
    {
        $expense =  $this->model->where('type', 'expense')
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as amount')
        ->where('created_at', '>=', now()->subMonths(3))
        ->groupByRaw('MONTH(created_at)')->get();

        $income =  $this->model->where('type', 'income')
        ->selectRaw('MONTH(created_at) as month, SUM(amount) as amount')
        ->where('created_at', '>=', now()->subMonths(3))
        ->groupByRaw('MONTH(created_at)')->get();
        
        return response()->json([
            'expense' => $expense,
            'income' => $income,
        ]);
    }

    public function transactionByMonth()
    {
        $lastYear = now()->year; // Get the year for the last year

        return $this->model->
        select(DB::raw('YEAR(transaction_date) as year'), DB::raw('MONTH(transaction_date) as month'), DB::raw('count(*) as total'))
        ->whereYear('transaction_date', $lastYear)    
        ->groupBy('year', 'month')
            ->get();
    }
}
