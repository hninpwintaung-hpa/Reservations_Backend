<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Http\Controllers\Controller;
use App\Repository\Team\TeamRepoInterface;
use App\Services\Team\TeamServiceInterface;
use Exception;

class TeamController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $teamService, $teamRepo;
    public function __construct(TeamServiceInterface $teamService, TeamRepoInterface $teamRepo)
    {

        $this->teamService = $teamService;
        $this->teamRepo = $teamRepo;
    }
    public function index()
    {
        try {
            $data = $this->teamRepo->get();
            return $this->sendResponse($data, 'Team lists.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        try {
            $data = $this->teamService->store($request->validated());
            return $this->sendResponse($data, 'Successfully register new team.');
        } catch (Exception $e) {
            return $this->sendError('Error in team registration', $e->getMessage(), 500);
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
            $data = $this->teamRepo->show($id);
            return $this->sendResponse($data, 'Selected team.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        try {
            $data = $this->teamService->update($request->validated(), $id);
            return $this->sendResponse($data, 'Successfully updated selected team.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
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
            $data = $this->teamService->destroy($id);
            return $this->sendResponse($data, 'Successfully deleted selected team.');
        } catch (Exception $e) {
            return $this->sendError('Error!', $e->getMessage(), 500);
        }
    }
}
