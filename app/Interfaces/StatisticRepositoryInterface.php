<?php

namespace App\Interfaces;

interface StatisticRepositoryInterface
{

    public function countCourse();
    public function getUserById($id);
    public function countAssignment();
}
