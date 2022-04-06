<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'image' => $this->image,
            'published' => $this->created_at->format('j F Y, H:i a'),
            'published_diff' => $this->created_at->diffForHumans(),
            'updated' => $this->updated_at->format('j F Y, H:i a'),
            'updated_diff' => $this->updated_at->diffForHumans(),
            // You can place relationship in Resource
            // Ex: $this->title->user. or smth like that u know what i mean right
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
