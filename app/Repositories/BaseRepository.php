<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($data){
        $new = new $this->model();
        $new->fill($data);
        $new->save();
        return $new;
    }

    public function update($model,$data){
         $model->update($data);
         return $model;
    }

    public function delete($model){
        $model->delete();
        $model->save();
        return response()->json('Deleted successfully');
    }

}
