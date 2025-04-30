<?php

namespace App\Repositories;


use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
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