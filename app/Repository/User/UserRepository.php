<?php

namespace App\Repository\User;
use App\Models\User;

class UserRepository implements UserRepoInterface{

    public function get() {
        $data = User::get();
        return $data;
    }

    public function show($id) {
        $data = User::where('id', $id)->first();
        return $data;
    }
}
