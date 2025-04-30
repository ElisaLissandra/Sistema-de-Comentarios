<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
    public function index(array $data = []);

    public function store(array $data);

    public function show($id);

    public function update(array $data, $id);

    public function delete($id);

    public function restore($id);

    public function forceDelete($id);
}