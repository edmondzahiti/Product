<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'price'        => $this->price,
            'user_id'      => $this->user_id,
            'created_at'   => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at'   => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
