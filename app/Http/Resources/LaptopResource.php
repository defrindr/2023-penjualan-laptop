<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaptopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "manufacturer" => $this->manufacturer,
            "model_name" => $this->model_name,
            "category" => $this->category,
            "screen_size" => $this->screen_size,
            "screen" => $this->screen,
            "cpu" => $this->cpu,
            "ram" => $this->ram,
            "storage" => $this->storage,
            "gpu" => $this->gpu,
            "operating_system" => $this->operating_system,
            "operating_system_version" => $this->operating_system_version,
            "weight" => $this->weight,
            "price" => $this->price,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'priceIdr' => $this->priceIdr,
            'weightLabel' => $this->weightLabel,
            'ramLabel' => $this->ramLabel,
        ];
    }
}
