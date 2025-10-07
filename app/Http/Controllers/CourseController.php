<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrollResource;
use App\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private CourseRepositoryInterface $courseRepository;
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function index()
    {
        try {
            $courses = $this->courseRepository->getAll();
            return ResponseHelper::jsonResponse(true, 'Course Berhasil Diambil', CourseResource::collection($courses), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $course = $this->courseRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Course berhasil ditambahkan', new CourseResource($course), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $course = $this->courseRepository->getById($id);
            if (!$course) {
                return ResponseHelper::jsonResponse(false, 'Course tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Course ditemukan', new CourseResource($course), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $course = $this->courseRepository->getById($id);
            if (!$course) {
                return ResponseHelper::jsonResponse(false, 'Course tidak ditemukan', null, 404);
            }
            $course = $this->courseRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Course berhasil di update', new CourseResource($course), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $course = $this->courseRepository->getById($id);
            if (!$course) {
                return ResponseHelper::jsonResponse(false, 'Course tidak ditemukan', null, 404);
            }

            $this->courseRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Course berhasil di hapus', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
    public function enroll(string $id)
    {
        try {
            $course = $this->courseRepository->getById($id);
            if (!$course) {
                return ResponseHelper::jsonResponse(false, 'Course tidak ditemukan', null, 404);
            }
            $hasEnroll = $this->courseRepository->enrollCheck($id);
            if ($hasEnroll) {
                return ResponseHelper::jsonResponse(false, 'Course sudah terdaftar', null, 400);
            }



            $enroll = $this->courseRepository->enroll($id);
            return ResponseHelper::jsonResponse(true, 'Course berhasil di daftarkan', new EnrollResource($enroll), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
