<?php

namespace App\Interfaces;

interface AssignmenRepositoryInterface
{
    public function getAll();
    public function getSubmissionById(string $id);
    public function create(array $data);
    public function submission(array $data);
    public function score(string $id, array $data);
    // public function getById(string $id);
    // public function update(string $id, array $data);
    // public function delete(string $id);
}
