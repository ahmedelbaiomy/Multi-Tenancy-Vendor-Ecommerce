<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements \App\Http\Interfaces\RepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);

    }

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);

    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function getModel()
    {
        return $this->model;
    }
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
    public function with($relations)
    {
        return $this->model->with($relations);
    }

}
