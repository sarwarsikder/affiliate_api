<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'shop_name' => $this->shop_name,
            'shop_logo' => $this->shop_logo,
            'shop_description' => $this->shop_description,
            'shop_benefits' => $this->shop_benefits,
            'shop_category' => $this->get_shop_category($this->shop_category),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shop_details' => url('/') . '/api/shops/' . $this->id
        ];
    }

    public function get_shop_category($shop_category)
    {
        return [
            'id' => $shop_category->id,
            'name' => $shop_category->name,
        ];
    }
}
