<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * The service instance
     */
    private UserService $userService;

    /**
     * Constructor
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('list_user', User::class);

        return $this->userService->index($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse|\Illuminate\Http\Response
     *
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create_user', User::class);

        return $this->responseDataSuccess(['properties' => $this->properties()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create_user', User::class);

        $input = $request->validated();
        $record = $this->userService->create($input);
        if (! is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     *
     * @return UserResource|JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('list_user', User::class);

        $model = $this->userService->get($user);

        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return JsonResponse|\Illuminate\Http\Response
     *
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('list_user', User::class);

        return $this->show($user);
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('list_user', User::class);

        $data = $request->validated();
        if ($this->userService->update($user, $data)) {
            return $this->responseUpdateSuccess(['record' => $user->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Update avatar in for specified user
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateAvatar(UpdateAvatarRequest $request, User $user)
    {
        $this->authorize('edit-profile', User::class);

        $data = $request->validated();
        if ($this->userService->updateAvatar($user, $data)) {
            return $this->responseUpdateSuccess(['record' => $user->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(DestroyUserRequest $request, User $user)
    {
        $this->authorize('delete', User::class);

        if ($this->userService->delete($user)) {
            return $this->responseDeleteSuccess(['record' => $user]);
        }

        return $this->responseDeleteFail();

    }

    /**
     * Render properties
     *
     * @return array
     */
    public function properties()
    {
        return [];
    }
}
