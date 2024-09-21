<?php

namespace App\Http\Controllers\Auth;

use App\DTO\NewUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserRepository $userRepository): UserResource|JsonResponse
    {
        $validated = $request->validated();
        $user = $userRepository->create(new NewUserDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password']
        ));
        return new UserResource($user);
    }

    public function login(LoginRequest $request, UserRepository $userRepository): JsonResponse
    {
        try {
            $loginRequestValidated = $request->validated();
            $user = $userRepository->getUserByEmail($loginRequestValidated['email']);
            if (!Hash::check($loginRequestValidated['password'], $user->getHashedPassword())) {
                throw new ValidationException('Password is incorrect!');
            }
            $token = $user->createToken($loginRequestValidated['device'])->plainTextToken;
            return new JsonResponse(['token' => $token]);
        } catch (\Exception $exception) {
            return response()->json(['errors' => 'Credentials is not valid!'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return new JsonResponse();
    }

}
