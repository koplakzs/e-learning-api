<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\ScoreRequest;
use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\SubmissionResource;
use App\Interfaces\AssignmenRepositoryInterface;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private AssignmenRepositoryInterface $assignmenRepository;

    public function __construct(AssignmenRepositoryInterface $assignmenRepository)
    {
        $this->assignmenRepository = $assignmenRepository;
    }
    public function index()
    {
        try {
            $assignment = $this->assignmenRepository->getAll();
            return ResponseHelper::jsonResponse(true, 'Asissment Berhasil Diambil', AssignmentResource::collection($assignment), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentRequest $request)
    {
        $request = $request->validated();
        try {
            $assignment = $this->assignmenRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Assignment berhasil ditambahkan', new AssignmentResource($assignment), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function submission(SubmissionRequest $request)
    {
        $request = $request->validated();
        try {
            $submission = $this->assignmenRepository->submission($request);

            return ResponseHelper::jsonResponse(true, 'Submission berhasil ditambahkan', new SubmissionResource($submission), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    public function score(ScoreRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $submission = $this->assignmenRepository->getSubmissionById($id);
            if (!$submission) {
                return ResponseHelper::jsonResponse(false, 'Submission tidak ditemukan', null, 404);
            }
            $submission = $this->assignmenRepository->score($id, $request);

            return ResponseHelper::jsonResponse(true, 'Submission berhasil dinilai', new SubmissionResource($submission), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
