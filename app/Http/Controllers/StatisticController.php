<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\CourseReportResource;
use App\Http\Resources\StudentReportResource;
use App\Interfaces\StatisticRepositoryInterface;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private StatisticRepositoryInterface $statisticRepository;

    public function __construct(StatisticRepositoryInterface $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }
    public function assignments()
    {
        try {
            $assignment = $this->statisticRepository->countAssignment();
            return ResponseHelper::jsonResponse(true, 'Asissment Berhasil Diambil', $assignment, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
    public function students(string $id)
    {
        try {
            $assignment = $this->statisticRepository->getUserById($id);
            if (!$assignment) {
                return ResponseHelper::jsonResponse(false, 'Student tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Asissment Berhasil Diambil', StudentReportResource::collection($assignment->submissions), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
    public function courses()
    {
        try {

            $courses = $this->statisticRepository->countCourse();
            return ResponseHelper::jsonResponse(true, 'Asissment Berhasil Diambil', CourseReportResource::collection($courses), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
