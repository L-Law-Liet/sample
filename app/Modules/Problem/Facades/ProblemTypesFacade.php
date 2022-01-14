<?php


namespace App\Modules\Problem\Facades;


use App\Facades\ModuleFacade;
use App\Models\ProblemType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class ProblemTypesFacade extends ModuleFacade
{
    protected function model(): string
    {
        return ProblemType::class;
    }

    /**
     * @param string $deleted
     * @return mixed
     */
    public function problems(string $deleted = '')
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
            $this->authorize('create', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the problem type');
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
            $this->authorize('update', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the problem type with id: ' . $id);
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
            $this->authorize('delete', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to delete the problem type with id: ' . $ids);
        }
        return parent::delete($ids); // TODO: Change the autogenerated stub
    }

    /**
     * @param int $id
     */
    public function restore(int $id)
    {
        $problem = $this->onlyTrashed()->findOrFail($id);
        try {
            $this->authorize('restore', $problem);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to restore the problem type with id: ' . $id);
        }
        $problem->restore();
        $problem->save();
    }

    /**
     * @return mixed
     */
    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }
}
