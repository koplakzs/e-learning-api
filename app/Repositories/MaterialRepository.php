<?php

namespace App\Repositories;

use App\Interfaces\MaterialRepositoryInterface;
use App\Models\Material;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function getAll()
    {
        $query = Material::orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function download(string $id)
    {
        $query = Material::find($id);

        return $query;
    }

    public function create(array $data)
    {

        DB::beginTransaction();

        try {

            $material = new Material();
            $path = $data['file']->store('files', 'public');
            $material->file_path = $path;
            $material->course_id = $data['course_id'];
            $material->title = $data['title'];
            $material->save();
            DB::commit();

            return $material;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    // public function update(string $id, array $data)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $material = Material::find($id);
    //         if (isset($data['file'])) {
    //             if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
    //                 Storage::disk('public')->delete($material->file_path);
    //             }
    //             $path = $data['file']->store('files', 'public');
    //             $material->file_path = $path;
    //         }
    //         $material->course_id = $data['course_id'];
    //         $material->title = $data['title'];
    //         $material->save();
    //         DB::commit();

    //         return $material;
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         throw new Exception($th->getMessage());
    //     }
    // }

    // public function delete(string $id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $material = Material::find($id);
    //         if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
    //             Storage::disk('public')->delete($material->file_path);
    //         }
    //         $material->delete();
    //         DB::commit();

    //         return $material;
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         throw new Exception($th->getMessage());
    //     }
    // }
}
