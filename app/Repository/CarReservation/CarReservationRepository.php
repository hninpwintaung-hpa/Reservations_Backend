<?php

namespace App\Repository\CarReservation;

use App\Models\CarReservation;

class CarReservationRepository implements CarReservationRepoInterface
{
    public function get()
    {
        return CarReservation::all();
    }
    public function show($id)
    {
        return CarReservation::where('id', $id)->get();
    }
}
