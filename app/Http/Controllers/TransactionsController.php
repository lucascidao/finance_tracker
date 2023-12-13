<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
            'type' => 'required|string|in:income,expense'
        ];
        $messages = [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'transaction_date.required' => 'Transaction date is required',
            'transaction_date.date' => 'Transaction date must be a date',
            'type.required' => 'Type is required',
            'type.string' => 'Type must be a string',
            'type.in' => 'Type must be income or expense'
        ];
        $validate = Validator::make($request->all(),$rules,$messages);
        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()
            ],422);
        }
        
        return $this->transactionsRepository->store($request->all());
    }
    public function delete($id){
        $transaction = $this->transactionsRepository->find($id);
        if($transaction == null){
            return response()->json([
                'message' => 'Transaction not found'
            ],404);
        }
        return $this->transactionsRepository->delete($transaction);
    }
    public function update(Request $request,$id){
        $transaction = $this->transactionsRepository->find($id);
        if($transaction == null){
            return response()->json([
                'message' => 'Transaction not found'
            ],404);
        }
        return $this->transactionsRepository->update($transaction,$request->all());
    }

    public function expenseData(){
        return $this->transactionsRepository->expensesSum();
    }

    public function transactionByMonth(){
        return $this->transactionsRepository->transactionByMonth();
    }
    public function transactionsLastMonths(){
        return $this->transactionsRepository->expensesSumLastMonths();
    }
}
