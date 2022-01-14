<?php

namespace App\Modules\Problem\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProblemType;
use App\Modules\Problem\Facades\ProblemTypesFacade;
use App\Modules\Problem\Requests\StoreProblemTypeRequest;
use App\Modules\Problem\Requests\UpdateProblemTypeRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProblemTypesController extends Controller
{
    private $facade;

    public function __construct(ProblemTypesFacade $problemTypesFacade)
    {
        $this->facade = $problemTypesFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'description', 'payoutStart', 'payoutEnd', 'sortBy']);
        try {
            $this->authorize('viewAny', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to view list of the problem types');
        }
        return view('problem-types.index', $parameters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $this->authorize('create', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the problem type');
        }
        return view('problem-types.add');
    }

    /**
     * @param StoreProblemTypeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProblemTypeRequest $request): RedirectResponse
    {
        $this->facade->create($request->validated());
        return redirect()->route('problem-types.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $problemType = $this->facade->findOrFail($id);
        try {
            $this->authorize('update', ProblemType::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the problem type with id: ' . $problemType->id);
        }
        return view('problem-types.add', compact('problemType'));
    }

    /**
     * @param UpdateProblemTypeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateProblemTypeRequest $request, int $id): RedirectResponse
    {
        $this->facade->update($request->validated(), $id);
        return redirect()->route('problem-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->facade->delete($id);
        return redirect()->route('problem-types.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'description', 'payoutStart', 'payoutEnd', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('problem-types.index',
            $parameters);
    }
}
