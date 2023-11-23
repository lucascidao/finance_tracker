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
    public function index(){
        return $this->transactionsRepository->list();
    }
    public function store(Request $request){
        return $this->transactionsRepository->store($request->all());
    }
    public function delete($id){
        $transaction = $this->transactionsRepository->find($id);
        return $this->transactionsRepository->delete($transaction);
    }
    public function update(Request $request,$id){
        return $this->transactionsRepository->update($request->all(),$id);
    }
}
