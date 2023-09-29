<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    public function find($id, $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function get()
    {
        return $this->model->all();
    }
}
