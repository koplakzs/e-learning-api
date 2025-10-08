<?php

namespace App\Repositories;

use App\Http\Resources\StudentReportResource;
use App\Interfaces\StatisticRepositoryInterface;
use App\Models\Course;
use App\Models\Submission;
use App\Models\User;

class StatisticRepository implements StatisticRepositoryInterface
{
    public function getUserById($id)
    {
        $query = User::find($id);

        return $query;
    }
    public function countAssignment()
    {
        $hasNotScore = Submission::where('score', null)->count();
        $hasScore = Submission::where('score', '!=', null)->count();

        $data = [
            'hasScore' => $hasScore,
            'hasNotScore' => $hasNotScore
        ];
        return $data;
    }
    public function countCourse()
    {
        $query = Course::all();
        return $query;
    }
}
