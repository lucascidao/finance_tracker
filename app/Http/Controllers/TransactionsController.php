<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    private TransactionRepository $transactionsRepository;
    private function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionsRepository = $transactionRepository;
    }
    public function index(){
        return $this->transactionsRepository->list();
    }
    public function store(ClientRequest $request){
        return $this->transactionsRepository->store($request->all());
    }
    public function delete($id){
        return $this->transactionsRepository->delete($id);
    }
    public function update(ClientRequest $request,$id){
        return $this->transactionsRepository->update($request->all(),$id);
    }
}
