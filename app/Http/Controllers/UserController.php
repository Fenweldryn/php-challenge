<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\StockCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $users = User::all();

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());

        } catch (\Throwable $th) {
            return response()->json(['Error' => 'Email has already been used. Choose a new email.'], 400);
        }
        $token = $user->createToken('default');
        $user->token = $token->plainTextToken;

        return response()->json($user, 200);
    }

    public function history(Request $request): StockCollection
    {
        return new StockCollection($request->user()->stocks);
    }

    public function show(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(Request $request, User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
