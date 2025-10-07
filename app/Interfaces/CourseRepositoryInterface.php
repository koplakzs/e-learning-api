<?php

namespace App\Interfaces;

interface CourseRepositoryInterface
{
    public function getAll();

    public function create(array $data);
    public function getById(string $id);

    public function update(string $id, array $data);
    public function delete(string $id);
    public function enrollCheck(string $id);
    public function enroll(string $id);
}
