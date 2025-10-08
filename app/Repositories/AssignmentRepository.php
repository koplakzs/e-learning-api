<?php

namespace App\Repositories;

use App\Interfaces\AssignmenRepositoryInterface;
use App\Models\Assignment;
use App\Models\Submission;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentRepository implements AssignmenRepositoryInterface
{
    public function getAll()
    {
        $query = Assignment::orderBy('created_at', 'desc')->get();
        return $query;
    }
    public function getSubmissionById(string $id)
    {
        $query = Submission::find($id);

        return $query;
    }


    public function create(array $data)
    {

        DB::beginTransaction();

        try {
            $assigment = new Assignment();
            $assigment->deadline = $data['deadline'];
            $assigment->description = $data['description'];
            $assigment->course_id = $data['course_id'];
            $assigment->title = $data['title'];
            $assigment->save();
            DB::commit();

            return $assigment;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
    public function submission(array $data)
    {
        DB::beginTransaction();

        try {
            $submission = new Submission();
            $path = $data['file']->store('files', 'public');
            $submission->assignment_id = $data['assignment_id'];
            $submission->student_id = Auth::user()->id;
            $submission->file_path = $path;
            $submission->save();
            DB::commit();

            return $submission;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    public function score(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $submission = Submission::find($id);
            $submission->score = $data['score'];
            $submission->save();
            DB::commit();

            return $submission;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
}
