<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $products = $this->productService->ownProducts();
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }

        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->create($request->validated());
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }
        return new ProductResource($product);
    }

    public function show($id)
    {
        try {
            $this->isAuthorized($id);

            $product = $this->productService->find($id);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $this->isAuthorized($id);

            $product = $this->productService->update($id, $request->validated());
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        try {
            $this->isAuthorized($id);

            $this->productService->delete($id);
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }
        return response()->json([
            'type'    => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }

    private function isAuthorized($id)
    {
        $product = $this->productService->find($id);
        $this->authorize('updateOrDelete', $product);
    }

}
