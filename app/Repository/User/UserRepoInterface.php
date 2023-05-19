<?php

namespace App\Repository\User;

interface UserRepoInterface {

    public function get();

    public function show($id);
}
