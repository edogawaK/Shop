<?php

namespace App\Services;

use Exception;
use Throwable;

class BaseService
{
    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
        if (!$this->repository) {
            throw new Exception('Service: Repository invalid', 0);
        }
    }

    public function handle($action, $exception)
    {
        // try {
        //     $action();
        // } catch (Throwable $e) {
        //     throw new RepositoryException(
        //         $exception['message'] ?? $e->getMessage(),
        //         $exception['code'] ?? $e->getCode(),
        //     );
        // }
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get($id)
    {
        return $this->repository->get($id);
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
