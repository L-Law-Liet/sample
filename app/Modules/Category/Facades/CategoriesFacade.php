<?php


namespace App\Modules\Category\Facades;


use App\Facades\ModuleFacade;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class CategoriesFacade extends ModuleFacade
{
    protected function model(): string
    {
        return Category::class;
    }

    /**
     * @param string $deleted
     * @return mixed
     */
    public function categories(string $deleted = '')
    {
        return ($deleted) ? $this->onlyTrashed() : $this->model::query();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        try {
            $this->authorize('create', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the category');
        }
        return $this->model->create($data);
    }

    /**
     * @param $data
     * @param int $id
     * @return mixed
     */
    public function update($data, int $id)
    {
        try {
            $this->authorize('update', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the category with id: ' . $id);
        }
        return $this->findOrFail($id)->update($data);
    }

    /**
     * @param array|int $ids
     * @return mixed
     */
    public function delete($ids)
    {
        try {
            $this->authorize('delete', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to delete the category with id: ' . $ids);
        }
        return parent::delete($ids); // TODO: Change the autogenerated stub
    }

    /**
     * @param int $id
     */
    public function restore(int $id)
    {
        $category = $this->onlyTrashed()->findOrFail($id);
        try {
            $this->authorize('restore', $category);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to restore the category with id: ' . $id);
        }
        $category->restore();
        $category->save();
    }

    /**
     * @return mixed
     */
    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }
}
