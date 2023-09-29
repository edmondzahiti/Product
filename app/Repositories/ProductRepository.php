<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function getModel()
    {
        return new Product();
    }

    public function ownProducts()
    {
        return $this->model->where('user_id', auth()->id())->get();
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();

        return $this->model->create($data);
    }

    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        $product->delete();

        return true;
    }
}
