<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\MaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Interfaces\MaterialRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private MaterialRepositoryInterface $materialRepository;
    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }
    public function index()
    {
        try {
            $materials = $this->materialRepository->getAll();
            return ResponseHelper::jsonResponse(true, 'Materi Berhasil Diambil', MaterialResource::collection($materials), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $request = $request->validated();
        try {
            $material = $this->materialRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Course berhasil ditambahkan', new MaterialResource($material), 201);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function download(string $id)
    {
        try {
            $material = $this->materialRepository->download($id);
            if (!$material) {
                return ResponseHelper::jsonResponse(false, 'Materi tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Materi ditemukan', new MaterialResource($material), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::jsonResponse(false, $th->getMessage(), null, 500);
        }
    }
}
