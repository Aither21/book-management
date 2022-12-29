<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookManagementResource extends JsonResource
{
    public static $warp = 'bookManagement';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->book->name,
            'author' => $this->book->author,
            'company' => $this->book->company,
            'userName' => $this->user->name
        ];
    }
}
