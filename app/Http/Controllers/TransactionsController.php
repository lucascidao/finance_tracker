<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    protected TransactionRepository $transactionsRepository;
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionsRepository = $transactionRepository;
    }
    public function indexIncome(){
        return $this->transactionsRepository->listIncome();
    }
    public function indexExpense(){
        return $this->transactionsRepository->listExpense();
    }
    public function store(Request $request){
        return $this->transactionsRepository->store($request->all());
    }
    public function delete($id){
        $transaction = $this->transactionsRepository->find($id);
        return $this->transactionsRepository->delete($transaction);
    }
    public function update(Request $request,$id){
        $transaction = $this->transactionsRepository->find($id);
        return $this->transactionsRepository->update($transaction,$request->all());
    }

    public function expenseData(){
        return $this->transactionsRepository->expensesSum();
    }

    public function transactionByMonth(){
        return $this->transactionsRepository->transactionByMonth();
    }
}
