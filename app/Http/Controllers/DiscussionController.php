<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DiscussionRequest;
use App\Http\Requests\ReplyRequest;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\ReplyResource;
use App\Interfaces\DiscussionRepositoryInterface;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private DiscussionRepositoryInterface $discussionRepository;

    public function __construct(DiscussionRepositoryInterface  $discussionRepository)
    {
        $this->discussionRepository = $discussionRepository;
    }
    public function index()
    {

        try {
            $discussions = $this->discussionRepository->getAll();
            return ResponseHelper::jsonResponse(true, 'Disccusion Berhasil Diambil', DiscussionResource::collection($discussions), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscussionRequest $request)
    {
        $request = $request->validated();
        try {
            $disccusion = $this->discussionRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Disccusion berhasil ditambahkan', new DiscussionResource($disccusion), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }



    public function reply(ReplyRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $discussion = $this->discussionRepository->getById($id);
            if (!$discussion) {
                return ResponseHelper::jsonResponse(false, 'Diskusi tidak ditemukan', null, 404);
            }
            $discussion = $this->discussionRepository->reply($id, $request);

            return ResponseHelper::jsonResponse(true, 'Reply berhasil ditambahkan', new ReplyResource($discussion), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
