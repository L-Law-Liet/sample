<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\Facades\UsersFacade;
use App\Modules\Admin\Requests\UserInviteRequest;
use App\Modules\Admin\Requests\UserStoreRequest;
use App\Modules\Admin\Requests\UserUpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    private $facade;

    public function __construct(UsersFacade $usersFacade)
    {
        $this->facade = $usersFacade;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'email', 'dateStart', 'dateEnd', 'status', 'sortBy']);
        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email . ' tried to view list of technicians');
        }
        return view('admin.users.index', $parameters);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        try {
            $this->authorize('create', User::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email . ' tried to create the technician');
        }
        return view('admin.users.add');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showInviteForm()
    {
        return view('admin.users.add');
    }

    /**
     * @param UserInviteRequest $request
     * @return RedirectResponse
     */
    public function invite(UserInviteRequest $request): RedirectResponse
    {
        $this->facade->storeUserWithInvite($request->name, $request->email);
        return redirect()->route('admin.users.index');
    }

    /**
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            $this->authorize('create', User::class);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to create the technician');
        }
        $this->facade->create($request->validated());
        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the technician with id: ' . $user->id);
        }
        return view('admin.users.add', compact('user'));
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to update the technician with id: ' . $user->id);
        }
        $this->facade->update($request->validated(), $user);
        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->authorize('delete', $user);
        } catch (AuthorizationException $e) {
            Log::error(auth()->user()->email. ' tried to delete the technician with id: ' . $user->id);
        }
        $this->facade->delete($user->id);
        return redirect()->route('admin.users.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deleted(Request $request)
    {
        $parameters = $request->all(['idx', 'name', 'email', 'dateStart', 'dateEnd', 'status', 'sortBy']);
        $parameters['deleted'] = 'true';
        return view('admin.users.index',
            $parameters);
    }
}
