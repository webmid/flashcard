<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
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

    public function all()
    {
        return $this->model->all();
    }

    public function show($id)
    {
       return  $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }


    public function with($relation)
    {
        return $this->model->with($relation);
    }
}
