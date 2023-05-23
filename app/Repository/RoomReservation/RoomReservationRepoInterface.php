<?php

namespace App\Repository\RoomReservation;

interface RoomReservationRepoInterface
{
    public function get();
    public function show($id);
    public function searchByDate($date);
    public function getRoomReserveCountByTeam();
    public function getRoomReserveCountById($id);
}
