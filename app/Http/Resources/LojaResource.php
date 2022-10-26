<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LojaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nome_loja' => $this->nome_loja,
            'email' => $this->email
        ];
    }
}
