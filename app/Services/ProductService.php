<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function ownProducts()
    {
        return $this->productRepository->ownProducts();
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    public function create($data)
    {
        return $this->productRepository->create($data);
    }

    public function update($id, $data)
    {
        $product = $this->productRepository->find($id);
        $this->productRepository->update($product, $data);

        return $product->refresh();
    }

    public function delete($id)
    {
        $product = $this->productRepository->find($id);

        $this->productRepository->delete($product);

        return true;
    }
}
