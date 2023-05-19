<?php

namespace App\Repository\RoomReservation;

interface RoomReservationRepoInterface
{
    public function get();
    public function show($id);
    public function searchByDate($date);
}
