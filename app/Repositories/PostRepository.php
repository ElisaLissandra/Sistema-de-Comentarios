<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
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