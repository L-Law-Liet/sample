<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Category\Facades\CategoriesFacade ;
use App\Modules\Category\Requests\StoreCategoryRequest;
use App\Modules\Category\Requests\UpdateCategoryRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    private $facade;

    public function __construct(CategoriesFacade $categoriesFacade)
    {
        $this->facade = $categoriesFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'sortBy']);
        try {
            $this->authorize('viewAny', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to view list of the categories');
        }
        return view('admin.categories.index', $parameters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $this->authorize('create', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the category');
        }
        return view('admin.categories.add');
    }

    /**
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->facade->create($request->validated());
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Category $category)
    {
        try {
            $this->authorize('update', Category::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the category with id: ' . $category->id);
        }
        return view('admin.categories.add', compact('category'));
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, int $id): RedirectResponse
    {
        $this->facade->update($request->validated(), $id);
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->facade->delete($id);
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('admin.categories.index',
            $parameters);
    }
}
