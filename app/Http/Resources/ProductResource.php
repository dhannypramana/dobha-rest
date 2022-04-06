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
        return [
            'id' => $this->id,
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'slug_produk' => $this->slug_produk,
            'deskripsi_produk' => $this->deskripsi_produk,
            'gambar_produk' => $this->gambar_produk,
            'stock_produk' => $this->stock_produk,
            'harga_satuan' => $this->harga_satuan,
            'rating_produk' => $this->harga_produk,
            'published' => $this->created_at->format('j F Y, H:i a'),
            'published_diff' => $this->created_at->diffForHumans(),
            'updated' => $this->updated_at->format('j F Y, H:i a'),
            'updated_diff' => $this->updated_at->diffForHumans(),
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
