<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $allowedResources = [
        'films', 'species', 'vehicles', 'starships', 'planets'
    ];

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $heroId = $this->getRandomHero();
        if (!$heroId) {
            return response()->json(['error' => 'API did not return required data'], 400);
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->hero_id = $heroId;
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return JsonResponse
     */
    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 200);
    }

    /**
     * Update user e-mail.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function updateEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();
        $user->email = $request->get('email');
        $user->save();

        return response()->json(['message' => 'User e-mail successfully updated'], 200);
    }

    /**
     * Get user resources.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function getResources(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'resource' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if(!in_array($request->get('resource'), $this->allowedResources)) {
            return response()->json(['error' => 'Resource not exists'], 400);
        }

        $resource = $this->getResource($request->get('resource'), $request->get('id'));

        if (!$resource) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($resource, 200);
    }
}
