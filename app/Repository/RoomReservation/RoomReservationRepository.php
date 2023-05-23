<?php

namespace App\Repository\RoomReservation;

use App\Models\Reservation;
use App\Models\RoomReservation;
use Carbon\Carbon;

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
    public function searchByUserAndDate($user_id)
    {
        $date = Carbon::now()->toDateString();
        //dd($date);
        return RoomReservation::where('user_id', $user_id)->where('date', $date)->get();
    }
}
