<?php

namespace App\Repository\User;

use App\Models\User;

class UserRepository implements UserRepoInterface
{

    public function get()
    {
        $data = User::with('team')->get();
        return $data;
    }

    public function show($id)
    {
        $data = User::where('id', $id)->first();
        return $data;
    }
    public function getProUser()
    {

        $data = User::with(['roles', 'team'])->whereHas('roles', function ($query) {
            $query->where('name', 'Admin')
                ->orWhere('name', 'SuperAdmin');
        })->get();
        return $data;
    }

    public function getStaff()
    {
        $data = User::with(['roles', 'team'])->whereHas('roles', function ($query) {
            $query->where('name', 'Staff');
        })->get();

        return $data;
    }
}
