<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Repository\User\UserRepoInterface;
use App\Services\User\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\Mail;

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

    // public function index()
    // {
    //     try {
    //         $user = Auth::user();
    //         if (!$user->can('user-list')) {
    //             return $this->sendError('Error!', ['error' => 'You do not have permission to view user lists']);
    //         }
    //         $data = $this->userRepo->get();
    //         return $this->sendResponse($data, 'All User lists.');
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage());
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(UserRequest $request)
    // {
    //     try {
    //         $data = $this->userService->store($request->all());
    //         return $this->sendResponse($data, 'Successfully register new user.');
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage());
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     try {
    //         $data = $this->userRepo->show($id);
    //         return $this->sendResponse($data, 'Successfully show selected user.');
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage());
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(UserRequest $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required',
    //             'email' => 'required|email|unique:users,email,' . $id,
    //             'phone' => 'required',
    //             'status' => 'required',
    //             'team_id' => 'required',
    //             'role_id' => 'required',
    //         ]);

    //         $user = Auth::user();

    //         if ($user->can('update-admin')) {
    //             $userToUpdate = User::find($id);
    //             if (!$userToUpdate) {
    //                 return $this->sendError('Error!', 'User not found', 404);
    //             }

    //             $data = $this->userService->update($request->all(), $id);

    //             return $this->sendResponse($data, 'Successfully updated selected user.');
    //             // return response()->json([
    //             //     'status' => 'success',
    //             //     'message' => 'user update successful',
    //             //     'data' => $data
    //             // ], 200);
    //         } else if ($user->can('update-user')) {
    //             $userToUpdate = User::find($id);
    //             if (!$userToUpdate) {
    //                 return $this->sendError('Error!', 'User not found', 404);
    //             }

    //             if ($userToUpdate->hasRole('SuperAdmin')) {
    //                 return $this->sendError('Error!', 'Cannot update a user with SuperAdmin role', 403);
    //             }

    //             if ($userToUpdate->hasRole('Admin')) {
    //                 if ($user->id !== $userToUpdate->id) {
    //                     return $this->sendError('Error!', 'Cannot update a user with Admin role', 403);
    //                 } else {
    //                     $data = $this->userService->update($request->all(), $id);
    //                     return $this->sendResponse($data, 'Successfully updated selected user.');
    //                 }
    //             }
    //             $data = $this->userService->update($request->all(), $id);
    //             return $this->sendResponse($data, 'Successfully updated selected user.');
    //         } else {
    //             return $this->sendError('Error!', 'You do not have permission to update a user', 403);
    //         }
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function userDelete($id)
    // {
    //     try {

    //         $user = Auth::user();
    //         if (!$user->can('delete-user')) {
    //             return $this->sendError('Error!', ['error' => 'You do not have permission to delete user'], 403);
    //         } else {

    //             $userToDelete = User::find($id);
    //             if (!$userToDelete) {
    //                 // return response()->json(['message' => 'User not found'], 404);
    //                 return $this->sendError('Error!', ['error' => 'User not found'], 404);
    //             }

    //             if ($userToDelete->hasRole('Admin')) {
    //                 return $this->sendError('Error!', ['error' => 'Cannot delete a user with Admin role'], 403);

    //                 //return response()->json(['message' => 'Cannot delete a user with Admin role'], 403);
    //             }

    //             if ($userToDelete->hasRole('SuperAdmin')) {
    //                 return $this->sendError('Error!', ['error' => 'Cannot delete a user with Super Admin role'], 403);
    //             }

    //             $data = $this->userService->destroy($id);
    //             return $this->sendResponse($data, 'Successfully deleted selected user.');
    //         }
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }

    // public function adminDelete($id)
    // {
    //     try {

    //         $user = Auth::user();
    //         if (!$user->can('delete-admin')) {
    //             return $this->sendError('Error!', ['error' => 'You do not have permission to delete admin'], 403);
    //         } else {

    //             $userToDelete = User::find($id);
    //             if (!$userToDelete) {
    //                 return $this->sendError('Error!', ['error' => 'User not found'], 404);
    //             }

    //             if ($userToDelete->hasRole('SuperAdmin')) {
    //                 return $this->sendError('Error!', ['error' => 'Cannot delete a user with Super Admin role'], 403);
    //             }

    //             $data = $this->userService->destroy($id);
    //             return $this->sendResponse($data, 'Successfully deleted admin.');
    //         }
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }
    // public function getProUser()
    // {
    //     try {
    //         $data = $this->userRepo->getProUser();
    //         return $this->sendResponse($data, 'Pro User Lists.');
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }

    // public function getStaff()
    // {
    //     try {
    //         $data = $this->userRepo->getStaff();
    //         return $this->sendResponse($data, 'Normal User Lists.');
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }

    // public function statusChange(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required',
    //             'email' => 'required|email|unique:users,email,' . $id,
    //             'phone' => 'required',
    //             'status' => 'required',
    //             'team_id' => 'required',
    //             'role_id' => 'required',
    //         ]);
    //         $user = Auth::user();

    //         if ($user->can('admin-status')) {
    //             $userToUpdate = User::find($id);
    //             if (!$userToUpdate) {
    //                 return $this->sendError('Error!', 'User not found', 404);
    //             }

    //             if ($userToUpdate->hasRole('SuperAdmin')) {
    //                 return $this->sendError('Error!', 'Cannot change status with superadmin role', 403);
    //             }

    //             $data = $this->userService->update($request->all(), $id);
    //             return $this->sendResponse($data, 'User updated successfully.');
    //         } else if ($user->can('user-status')) {
    //             $userToUpdate = User::find($id);
    //             if (!$userToUpdate) {
    //                 return $this->sendError('Error!', 'User not found', 404);
    //             }

    //             if ($userToUpdate->hasRole('SuperAdmin')) {

    //                 return $this->sendError('Error!', 'Cannot update a user with SuperAdmin role', 403);
    //             }

    //             if ($userToUpdate->hasRole('Admin')) {
    //                 return $this->sendError('Error!', 'Cannot update a user with Admin role', 403);
    //             }
    //             $data = $this->userService->update($request->all(), $id);
    //             return $this->sendResponse($data, 'User updated successfully.');
    //         } else {
    //             return $this->sendError('Error!', 'You do not have permission to update status', 403);
    //         }
    //     } catch (Exception $e) {
    //         return $this->sendError('Error!', $e->getMessage(), 500);
    //     }
    // }
    public function index()
    {
        try {
            // $roles = Role::all();
            $user = Auth::user();
            if (!$user->can('user-list')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to view user lists',
                ], 403);
            }
            $data = $this->userRepo->get();
            return response()->json([
                'status' => 'success',
                'message' => "user list all",
                'data' => $data
                // 'roles' => $roles,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
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
            $data = $this->userService->store($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'New user store',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
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
            return response()->json([
                'status' => 'success',
                'message' => "user select",
                'data' => $data,
                'role' => $data->getRoleNames(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required',
                'status' => 'required',
                'team_id' => 'required',
                'role_id' => 'required',
            ]);

            $user = Auth::user();

            if ($user->can('update-admin')) {
                $userToUpdate = User::find($id);
                if (!$userToUpdate) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToUpdate->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot update a user with SuperAdmin role'], 403);
                }

                // if ($userToUpdate->hasRole('Admin')) {
                //     return response()->json(['message' => 'Cannot update a user with Admin role'], 403);
                // }

                $data = $this->userService->update($request->all(), $id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'user update successful',
                    'data' => $data
                ], 200);
            } else if ($user->can('update-user')) {
                $userToUpdate = User::find($id);
                if (!$userToUpdate) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToUpdate->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot update a user with SuperAdmin role'], 403);
                }

                if ($userToUpdate->hasRole('Admin')) {
                    if ($user->id !== $userToUpdate->id) {
                        return response()->json(['message' => 'Cannot update a user with Admin role'], 403);
                    } else {
                        $data = $this->userService->update($request->all(), $id);
                        return response()->json([
                            'status' => 'success',
                            'message' => 'user update successful',
                            'data' => $data
                        ], 200);
                    }
                }
                $data = $this->userService->update($request->all(), $id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'user update successful',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to update a user',
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
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
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to delete a user',
                ], 403);
            } else {

                $userToDelete = User::find($id);
                if (!$userToDelete) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToDelete->hasRole('Admin')) {
                    return response()->json(['message' => 'Cannot delete a user with Admin role'], 403);
                }

                if ($userToDelete->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot delete a user with Super Admin role'], 403);
                }

                $data = $this->userService->destroy($id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'user delete successful',
                    'data' => $data
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }

    public function adminDelete($id)
    {
        try {

            $user = Auth::user();
            if (!$user->can('delete-admin')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to delete admin',
                ], 403);
            } else {

                $userToDelete = User::find($id);
                if (!$userToDelete) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToDelete->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot delete a user with Super Admin role'], 403);
                }

                $data = $this->userService->destroy($id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'admin delete successful',
                    'data' => $data
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }


    public function getProUser()
    {
        try {
            $data = $this->userRepo->getProUser();
            return response()->json([
                'status' => 'success',
                'message' => "get admin user",
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }

    public function getStaff()
    {
        try {
            $data = $this->userRepo->getStaff();
            return response()->json([
                'status' => 'success',
                'message' => "get staff",
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }

    public function statusChange(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required',
                'status' => 'required',
                'team_id' => 'required',
                'role_id' => 'required',
            ]);
            $user = Auth::user();

            if ($user->can('admin-status')) {
                $userToUpdate = User::find($id);
                if (!$userToUpdate) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToUpdate->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot change status with superadmin role'], 403);
                }

                $data = $this->userService->update($request->all(), $id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'user update successful',
                    'data' => $data
                ], 200);
            } else if ($user->can('user-status')) {
                $userToUpdate = User::find($id);
                if (!$userToUpdate) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                if ($userToUpdate->hasRole('SuperAdmin')) {
                    return response()->json(['message' => 'Cannot update a user with SuperAdmin role'], 403);
                }

                if ($userToUpdate->hasRole('Admin')) {
                    return response()->json(['message' => 'Cannot update a user with Admin role'], 403);
                }
                $data = $this->userService->update($request->all(), $id);
                Mail::to($data->email)->send(new WelcomeEmail());

                return response()->json([
                    'status' => 'success',
                    'message' => 'user update successful',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to update status',
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
