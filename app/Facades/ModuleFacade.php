<?php


namespace App\Facades;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


abstract class ModuleFacade
{
    use AuthorizesRequests;

    protected $model;

    /**
     * ModuleFacade constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    /**
     * @return string classname
     */
    abstract protected function model(): string;

    /**
     * @return array|null
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param int|array $ids
     * @return mixed
     */
    public function delete($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }
}
