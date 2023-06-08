<?php

namespace App\Repository\Room;

use App\Models\Room;

class RoomRepository implements RoomRepoInterface
{
    public function get()
    {
        return Room::where('status', 1)->get();
    }
    public function show($id)
    {
        $data = Room::where('id', $id)->first();
        return $data;
    }

    public function getRoomCount()
    {
        $data = Room::count();
        return $data;
    }
}
