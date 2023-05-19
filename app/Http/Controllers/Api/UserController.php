<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repository\User\UserRepoInterface;
use App\Services\User\UserServiceInterface;
use Exception;


class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $userService, $userRepo;
    public function __construct(UserServiceInterface $userService, UserRepoInterface $userRepo)
    {

        $this->userService = $userService;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        try {
            $user = Auth::user();
            // if (!$user->can('user-list')) {
            //     return $this->sendError('Error!', ['error' => 'You do not have permission to view user lists']);
            // }
            $data = $this->userRepo->get();
            return $this->sendResponse($data, 'All User lists.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $this->userService->store($request->all());
            return $this->sendResponse($data, 'Successfully register new user.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->userRepo->show($id);
            return $this->sendResponse($data, 'Successfully show selected user.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDelete($id)
    {
        try {

            $user = Auth::user();
            if (!$user->can('delete-user')) {
                return $this->sendError('Error!', ['error' => 'You do not have permission to delete user'], 403);
            } else {

                $userToDelete = User::find($id);
                if (!$userToDelete) {
                    // return response()->json(['message' => 'User not found'], 404);
                    return $this->sendError('Error!', ['error' => 'User not found'], 404);
                }

                if ($userToDelete->hasRole('Admin')) {
                    return $this->sendError('Error!', ['error' => 'Cannot delete a user with Admin role'], 403);

                    //return response()->json(['message' => 'Cannot delete a user with Admin role'], 403);
                }

                if ($userToDelete->hasRole('SuperAdmin')) {
                    return $this->sendError('Error!', ['error' => 'Cannot delete a user with Super Admin role'], 403);
                }

                $data = $this->userService->destroy($id);
                return $this->sendResponse($data, 'Successfully deleted selected user.');
            }
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
        }
    }

    public function adminDelete($id)
    {
        try {

            $user = Auth::user();
            if (!$user->can('delete-admin')) {
                return $this->sendError('Error!', ['error' => 'You do not have permission to delete admin'], 403);
            } else {

                $userToDelete = User::find($id);
                if (!$userToDelete) {
                    return $this->sendError('Error!', ['error' => 'User not found'], 404);
                }

                $data = $this->userService->destroy($id);
                return $this->sendResponse($data, 'Successfully deleted admin.');
            }
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
        }
    }
}
