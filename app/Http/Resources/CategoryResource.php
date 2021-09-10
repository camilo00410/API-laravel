<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;

class CategoryResource extends JsonResource
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
        return[
            'id' => $this->id,
            'name' => $this->name,
            'descripcion'=> $this->descripcion,
            'slug'=> $this->slug,
            // 'posts' => $this->whenLoaded('posts')
            'posts' => PostResource::collection($this->whenLoaded('posts'))
        ];

    }
}
