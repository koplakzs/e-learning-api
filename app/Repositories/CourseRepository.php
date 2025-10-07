<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use App\Models\Enroll;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll()
    {
        $query = Course::orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getById(string $id)
    {
        $query = Course::find($id);

        return $query;
    }

    public function create(array $data)
    {

        DB::beginTransaction();

        try {
            $course = new Course();
            $course->name = $data['name'];
            $course->description = $data['description'];
            $course->lecture_id = Auth::user()->id;
            $course->save();
            DB::commit();

            return $course;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $course = Course::find($id);
            $course->name = $data['name'];
            $course->description = $data['description'];
            $course->lecture_id = Auth::user()->id;
            $course->save();
            DB::commit();

            return $course;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();

        try {
            $course = Course::find($id);
            $course->delete();
            DB::commit();

            return $course;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    public function enrollCheck(string $id)
    {
        $query = Enroll::where('course_id', $id)->where('user_id', Auth::user()->id)->first();

        return $query;
    }
    public function enroll(string $id)
    {
        DB::beginTransaction();
        try {
            $enroll = new Enroll();
            $enroll->course_id = $id;
            $enroll->user_id = Auth::user()->id;
            $enroll->save();
            DB::commit();
            return $enroll;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
}
