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
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'product_validity' => $this->product_validity,
            'shop' => $this->get_shop($this->shop),
            'product_category' => $this->get_product_category($this->product_category),
            'product_claim' => ($this->product_claimed != null) ? $this->get_claim($this->product_claimed) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_details' => url('/') . '/ap/products/' . $this->id
        ];
    }

    public function get_shop($shop)
    {
        return [
            'id' => $shop->id,
            'shop_name' => $shop->shop_name,
            'shop_logo' => $shop->shop_logo,
            'shop_details' => url('/') . '/api/shops/' . $shop->id
        ];
    }

    public function get_product_category($product_category)
    {
        return [
            'id' => $product_category->id,
            'name' => $product_category->name,
        ];
    }

    public function get_claim($product_claimed)
    {
        return [
            'id' => $product_claimed->id,
            'claim' => $product_claimed->claim,
        ];
    }
}
