<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReservation extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'title', 'start_time', 'end_time',  'destination', 'no_of_traveller', 'status', 'user_id', 'car_id', 'remark', 'approved_by'];
}
