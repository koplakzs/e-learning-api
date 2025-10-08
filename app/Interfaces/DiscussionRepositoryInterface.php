<?php

namespace App\Interfaces;

interface DiscussionRepositoryInterface
{
    public function getAll();
    public function getById(string $id);
    public function create(array $data);
    public function reply(string $id, array $data);
}
