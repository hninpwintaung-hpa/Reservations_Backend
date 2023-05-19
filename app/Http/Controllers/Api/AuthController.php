<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repository\User\UserRepoInterface;
use App\Services\User\UserServiceInterface;

class AuthController extends BaseController
{
    private $userService, $userRepo;
    public function __construct(UserServiceInterface $userService, UserRepoInterface $userRepo)
    {

        $this->userService = $userService;
        $this->userRepo = $userRepo;
    }


    public function register(Request $request)
    {

        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'employee_id' => 'required|unique:users,employee_id',
                    'phone' => 'required|unique:users,phone',
                    'password' => 'required',
                    'status' => 'required',
                    'role_id' => 'required',
                    'team_id' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return $this->sendError('Validation Error.', $validateUser->errors(), 403);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => $request->status,
                'team_id' => $request->team_id,
            ]);
            $user->assignRole($request->role_id);
            $success['token'] = $user->createToken('API TOKEN')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User Register successfully.');

            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Created Successfully',
            //     'token' => $user->createToken("API TOKEN")->plainTextToken
            // ], 200);

        } catch (\Throwable $th) {
            return $this->sendError('Registration Fail!.', $th->getMessage(), 500);

            // return response()->json([
            //     'status' => false,
            //     'message' => $th->getMessage()
            // ], 500);
        }
    }

    public function login(Request $request)
    {
        // try {
        //     $validateUser = Validator::make(
        //         $request->all(),
        //         [
        //             'email' => 'required|email',
        //             'password' => 'required'
        //         ]
        //     );
        //     if ($validateUser->fails()) {
        //         return $this->sendError('Validation error.', ['error' => 'unathorised'], 404);
        //     }
        //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //         $user = Auth::user();
        //         $user = User::where('email', $request->email)->first();
        //         $success['token'] = $user->createToken('MyApp')->plainTextToken;
        //         $success['name'] = $user->name;
        //         $success['user'] = $user;
        //         $success['role'] = $user->getRoleNames()->first();


        //         // $success['email'] = $user->email;
        //         // $success['id'] = $user->id;

        //         return $this->sendResponse($success, 'User Login successfully.');
        //     } else {
        //         return $this->sendError('Unauthorised.', ['error' => 'Email & Password does not match with our record.'], 403);
        //     }
        // } catch (\Throwable $th) {
        //     return $this->sendError('Server Error.',  $th->getMessage(), 405);

        //     // return response()->json([
        //     //     'status' => false,
        //     //     'message' => $th->getMessage()
        //     // ], 500);
        // }

        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return $this->sendError('Validation error.', ['error' => 'unathorised']);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user,
                'role' => $user->getRoleNames()->first()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
