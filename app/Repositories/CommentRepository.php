<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function index(array $with = [])
    {
        return $this->model->with($with)->get();
    }
    
    public function show($id)
    {
        return $this->model->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $update = $this->model->find($id);
        $update->update($data);

        return $update;
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->find($id)->restore();
    }

    public function forceDelete($id)
    {
        return $this->model->withTrashed()->find($id)->forceDelete();
    }
}