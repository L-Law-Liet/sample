<?php

namespace App\Modules\Status\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductStatus;
use App\Modules\Status\Facades\StatusesFacade;
use App\Modules\Status\Requests\StoreStatusRequest;
use App\Modules\Status\Requests\UpdateStatusRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusesController extends Controller
{
    private $facade;

    public function __construct(StatusesFacade $statusesFacade)
    {
        $this->facade = $statusesFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'sortBy']);
        try {
            $this->authorize('viewAny', ProductStatus::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to view list of the status');
        }
        return view('admin.statuses.index', $parameters);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        try {
            $this->authorize('create', ProductStatus::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the status');
        }
        return view('admin.statuses.add');
    }

    /**
     * @param StoreStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreStatusRequest $request)
    {
        $this->facade->create($request->validated());
        return redirect()->route('admin.statuses.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $productStatus = $this->facade->findOrFail($id);
        try {
            $this->authorize('update', [ProductStatus::class, $productStatus]);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the status with id: ' . $id);
        }
        return view('admin.statuses.add', compact('productStatus'));
    }

    /**
     * @param UpdateStatusRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateStatusRequest $request, int $id)
    {
        $this->facade->update($request->validated(), $id);
        return redirect()->route('admin.statuses.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $this->facade->delete($id);
        return redirect()->route('admin.statuses.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('admin.statuses.index',
            $parameters);
    }
}
