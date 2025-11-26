<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IUserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserTransformer $userTransformer;
    protected IUserRepository $userRepository;

    public function __construct(UserTransformer $userTransformer, IUserRepository $userRepository)
    {
        $this->userTransformer = $userTransformer;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $filters = $request->except(['per_page', 'orderBy', 'page']);
        $filtersData = $this->prepareFilters($filters);

        $users = $this->userRepository
            ->all(
                $filtersData['criteria'],
                $request->get('orderBy', []),
                $filtersData['orWhere']
            );

        $transformedUsers = $this->userTransformer->transformCollection($users);

        $paginatedUsers = $this->paginate($transformedUsers, $perPage, $request->get('page', 1));

        return response()->json(
            [
                'data' => $paginatedUsers->items(),
                'meta' => $this->getPaginationMeta($paginatedUsers)
            ],
            200
        );
    }

    public function show(Request $request, string $uuid)
    {
        $user = $this->userRepository->findByUuid($uuid);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 422);
        }

        $transformedUser = $this->userTransformer->transform($user);

        return response()->json(['data' => $transformedUser], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,gerente,garcom,recepcionista',
        ]);


        $newUser = $this->userRepository->create($validated);

        if (!$newUser) {
            return response()->json(['message' => 'Falha ao criar usuario'], 500);
        }

        $newUser = $this->userTransformer->transform($newUser);

        return response()->json(['data' => $newUser], 201);
    }

    public function update(Request $request, $uuid)
    {
        if (is_null($uuid)) {
            return response()->json(['message' => 'UUID is required'], 422);
        }

        $user = $this->userRepository->findByUuid($uuid);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 422);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email:rfc,dns|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|string|in:admin,gerente,garcom,recepcionista',
        ]);

        $updatedUser = $this->userRepository->update($user->id, $validated);
        $transformedUser = $this->userTransformer->transform($updatedUser);

        return response()->json(['data' => $transformedUser], 200);
    }

    public function destroy(Request $request, $uuid)
    {
        if (is_null($uuid)) {
            return response()->json(['message' => 'UUID is required'], 422);
        }

        $user = $this->userRepository->findByUuid($uuid);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 422);
        }

        $this->userRepository->delete($user->id);

        return response()->json(['message' => "User with name: {$user->name} deleted"], 200);
    }
}
