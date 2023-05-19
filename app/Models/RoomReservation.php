<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'start_time', 'end_time',  'date', 'room_id', 'user_id'];
}
