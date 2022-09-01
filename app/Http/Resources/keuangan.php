<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class keuangan extends JsonResource
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
            'id_users' => $this->id_users,
            'uang_masuk' => $this->uang_masuk,
            'uang_keluar' => $this->uang_keluar
        ];
    }
}
