<?php

namespace App\Interfaces;

interface MaterialRepositoryInterface
{
    public function getAll();

    public function create(array $data);
    public function download(string $id);

    // public function update(string $id, array $data);
    // public function delete(string $id);
}
