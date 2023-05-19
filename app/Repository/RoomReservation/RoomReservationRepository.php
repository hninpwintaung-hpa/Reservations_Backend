<?php

namespace App\Repository\RoomReservation;

use App\Models\Reservation;
use App\Models\RoomReservation;

class RoomReservationRepository implements RoomReservationRepoInterface
{
    public function get()
    {
        return RoomReservation::all();
    }
    public function show($id)
    {
        return RoomReservation::where('id', $id)->first();
    }
    public function searchByDate($date)
    {
        return  RoomReservation::where('date', $date)->get();
    }
}