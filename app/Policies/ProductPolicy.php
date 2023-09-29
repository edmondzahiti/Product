<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function updateOrDelete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
