<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->authUser();
        $products = Product::factory(3)->create(['user_id' => auth()->id()]);

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function testStoreWithValidData()
    {
        $this->authUser();

        $validProductData = [
            'name' => 'Sample Product',
            'description' => 'This is a sample product.',
            'price' => 19.99,
        ];

        $response = $this->post('/api/products', $validProductData);

        $response->assertStatus(201);

        $response->assertSee($validProductData);

    }

    public function testStoreWithInvalidData()
    {
        $this->authUser();

        $invalidProductData = [
            'name' => 'Sample Product',
            'description' => 'This is a sample product.',
            'price' => null,
        ];

        $response = $this->post('/api/products', $invalidProductData);

        $response->assertStatus(302);
    }

    public function testShowAuthorized()
    {
        $this->authUser();

        $product = Product::factory()->create(['user_id' => auth()->id()]);

        $response = $this->get('/api/products/' . $product->id);
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function testShowUnauthorized()
    {
        $this->authUser();

        $ownerUser = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $ownerUser->id]);

        $response = $this->get('/api/products/' . $product->id);

        $response->assertStatus(500);
    }

    public function testUpdateAuthorized()
    {
        $this->authUser();
        $product = Product::factory()->create(['user_id' => auth()->id()]);

        $updatedData = [
            'name' => 'Updated Product Name',
            'description' => 'Updated product description.',
            'price' => 29.99,
        ];

        $response = $this->put('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(200);

        $response->assertSee($updatedData);
    }

    public function testUpdateUnauthorized()
    {
        $this->authUser();
        $ownerUser = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $ownerUser->id]);

        $updatedData = [
            'name' => 'Updated Product Name',
            'description' => 'Updated product description.',
            'price' => 29.99,
        ];

        $response = $this->put('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(500);
    }

    public function testDestroyAuthorized()
    {
        $this->authUser();
        $product = Product::factory()->create(['user_id' => auth()->id()]);

        // Simulate a DELETE request to the destroy method with the product's ID
        $response = $this->delete('/api/products/' . $product->id);

        // Assert that the response has a 200 status code (or adjust as needed)
        $response->assertStatus(200);

        // Assert that the response contains the success message
        $response->assertJson([
            'type' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }

    public function testDestroyUnauthorized()
    {
        $this->authUser();
        $ownerUser = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $ownerUser->id]);

        $response = $this->delete('/api/products/' . $product->id);

        $response->assertStatus(500);
    }


    public function authUser()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer {$token}");
        parent::actingAs($user);

        return $this;
    }

}
