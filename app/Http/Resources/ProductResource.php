<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $original = parent::toArray($request);
        
        return array_merge($original, [
            'category' => $this->product_category->name,
        ]);
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
