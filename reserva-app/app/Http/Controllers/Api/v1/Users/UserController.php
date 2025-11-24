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
        return response()->json(['message' => 'User index']);
    }

    public function show(Request $request, $uuid)
    {
        return response()->json(['message' => "User details for UUID: $uuid"]);
    }

    public function store(Request $request)
    {
        return response()->json(['message' => 'User created'], 201);
    }

    public function update(Request $request, $uuid)
    {
        return response()->json(['message' => "User with UUID: $uuid updated"]);
    }

    public function destroy(Request $request, $uuid)
    {
        return response()->json(['message' => "User with UUID: $uuid deleted"]);
    }
}
