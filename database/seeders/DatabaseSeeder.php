<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarReservation;
use App\Models\Room;
use App\Models\RoomReservation;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        $this->call(AdminSeeder::class);

        $team1 = Team::create(
            [
                'name' => 'Team1',
                // 'user_id' => '1',
            ]
        );
        $team2 = Team::create(
            [
                'name' => 'Team2',
                // 'user_id' => '2',

            ]
        );
        $team3 = Team::create(
            [
                'name' => 'Team3',
                // 'user_id' => '3',

            ]
        );
        $team4 = Team::create(
            [
                'name' => 'Team4',
                // 'user_id' => '3',

            ]
        );
        $team5 = Team::create(
            [
                'name' => 'Team5',
                // 'user_id' => '3',

            ]
        );
        $room1 = Room::create(
            [
                'name' => 'Conference Room',
                'capacity' => 10,
                // 'user_id' => '3',

            ]
        );
        $room2 = Room::create(
            [
                'name' => 'Hall Room',
                'capacity' => 20,
                // 'user_id' => '3',

            ]
        );
        $room3 = Room::create(
            [
                'name' => 'Meeting Room 1',
                'capacity' => 5,
                // 'user_id' => '3',

            ]
        );

        $roomReservation1 = RoomReservation::create(
            [
                'title' => 'Meeting One',
                'description' => 'Meeting Agenda One',
                'date' => '2023-05-28',
                'start_time' => '10:0:0',
                'end_time' => '11:0:0',
                'room_id' => 1,
                'user_id' => 3,
            ]
        );
        $roomReservation2 = RoomReservation::create(
            [
                'title' => 'Meeting Four',
                'description' => 'Meeting Agenda Four',
                'date' => '2023-05-28',
                'start_time' => '11:0:0',
                'end_time' => '12:0:0',
                'room_id' => 1,
                'user_id' => 3,
            ]
        );
        $roomReservation3 = RoomReservation::create(
            [
                'title' => 'Meeting Tow',
                'description' => 'Meeting Agenda Two ',
                'date' => '2023-05-28',
                'start_time' => '10:0:0',
                'end_time' => '11:0:0',
                'room_id' => 2,
                'user_id' => 2,
            ]
        );

        $car1 = Car::create(
            [
                'brand' => 'Toyota',
                'licence_no' => '4F-09522',
                'capacity' => 5,
                // 'user_id' => '3',

            ]
        );
        $car2 = Car::create(
            [
                'brand' => 'Honda',
                'licence_no' => '4H-09022',
                'capacity' => 5,
                // 'user_id' => '3',

            ]
        );
        $car3 = Car::create(
            [
                'brand' => 'KIA',
                'licence_no' => '4E-59512',
                'capacity' => 5,
                // 'user_id' => '3',

            ]
        );
        $carReservation1 = CarReservation::create(
            [
                'title' => 'To Meet with Client One',
                'date' => '2023-05-28',
                'start_time' => '10:0:0',
                'end_time' => '11:0:0',
                'destination' => 'Thingankyun',
                'car_id' => 1,
                'user_id' => 2,
            ]
        );
        $carReservation2 = CarReservation::create(
            [
                'title' => 'To Meet with Client Two',
                'date' => '2023-05-28',
                'start_time' => '10:0:0',
                'end_time' => '11:0:0',
                'destination' => 'Kamayut',
                'car_id' => 2,
                'user_id' => 2,
            ]
        );
        $carReservation3 =  CarReservation::create(
            [
                'title' => 'To Meet with Client Three',
                'date' => '2023-05-28',
                'start_time' => '14:0:0',
                'end_time' => '17:0:0',
                'destination' => 'Latha',
                'car_id' => 2,
                'user_id' => 2,
            ]
        );
    }
}
