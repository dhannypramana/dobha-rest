<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'body' => $this->body,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => [
                'id' => $this->id,
                'kode_produk' => $this->product->kode_produk,
                'nama_produk' => $this->product->nama_produk,
                'slug_produk' => $this->product->slug_produk,
                'deskripsi_produk' => $this->product->deskripsi_produk,
                'gambar_produk' => $this->product->gambar_produk,
            ],
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
