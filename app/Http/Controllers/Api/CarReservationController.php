<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\CarReservation\CarReservationRepoInterface;
use App\Services\CarReservation\CarReservationServiceInterface;
use Exception;
use Illuminate\Http\Request;

class CarReservationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $carReservationService, $carReservationRepo;
    public function __construct(CarReservationRepoInterface $carReservationRepo, CarReservationServiceInterface $carReservationService)
    {
        $this->carReservationService = $carReservationService;
        $this->carReservationRepo = $carReservationRepo;
    }
    public function index()
    {
        try {
            $data = $this->carReservationRepo->get();
            return $this->sendResponse($data, ' Data Show successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->validate([
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'date' => 'required',
                'destination' => 'required',
                'no_of_traveller' => 'required',
                'user_id' => 'required',
                'car_id' => 'required',
            ]);
            $data = $this->carReservationService->store($input);
            return $this->sendResponse($data, 'Created  Reservation successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->carReservationRepo->show($id);
            return $this->sendResponse($data, ' Data Show successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->validate([
                'title' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'date' => 'required',
                'destination' => 'required',
                'no_of_traveller' => 'required',
                'user_id' => 'required',
                'car_id' => 'required',
            ]);
            $data = $this->carReservationService->update($input, $id);
            return $this->sendResponse($data, 'Updated Reservation successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->carReservationService->delete($id);
            return $this->sendResponse($data, 'Deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    public function getCarReserveCount(){
        try{
            $data = $this->carReservationRepo->getCarReserveCount();
            return $this->sendResponse($data, 'Car Reservation Count');
        } catch(Exception $e){
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    public function getCarReserveCountByTeam(){
        try{
            $data = $this->carReservationRepo->getCarReserveCountByTeam();
            return $this->sendResponse($data, 'Car Reserve Count by Team');
        } catch(Exception $e){
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    public function getCarReserveCountById($id){
        try{
            $data = $this->carReservationRepo->getCarReserveCountById($id);
            return $this->sendResponse($data, 'Car Count by Id');
        } catch(Exception $e){
            return $this->sendError('Error', $e->errorMessage(), 500);
        }
    }
}
