<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Modules\Client\Facades\ClientsFacade;
use App\Modules\Client\Requests\StoreClientRequest;
use App\Modules\Client\Requests\UpdateClientRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    private $facade;

    public function __construct(ClientsFacade $clientsFacade)
    {
        $this->facade = $clientsFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'email', 'phone', 'address', 'type', 'sortBy']);
        try {
            $this->authorize('viewAny', Client::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to view list of the clients');
        }
        return view('clients.index', $parameters);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $this->authorize('create', Client::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the client');
        }
        return view('clients.add');
    }

    /**
     * @param StoreClientRequest $request
     * @return RedirectResponse
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        $this->facade->create($request->validated());
        return redirect()->route('clients.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $client = $this->facade->findOrFail($id);
        try {
            $this->authorize('update', Client::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the client with id: ' . $client->id);
        }
        return view('clients.add', compact('client'));
    }

    /**
     * @param UpdateClientRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateClientRequest $request, int $id): RedirectResponse
    {
        $this->facade->update($request->validated(), $id);
        return redirect()->route('clients.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->facade->delete($id);
        return redirect()->route('clients.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'email', 'phone', 'address', 'type', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('clients.index',
            $parameters);
    }
}
