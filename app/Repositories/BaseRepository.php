<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;

class BaseRepository
{
    protected $model;
    protected $pageSize=2;

    public function __construct($model)
    {
        $this->model = $model;

        if (!$this->model) {
            throw new RepositoryException('Repository: Model invalid', 0);
        }
    }

    public function all()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
