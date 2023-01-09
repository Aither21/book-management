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
            'imageUrl' => 'https://images-na.ssl-images-amazon.com/images/P/' . $this->book->image_number . '.09.LZZZZZZZ',
            'company' => $this->book->company,
            'status' => $this->status,
            'userId' => $this->user->id,
            'userName' => $this->user->name
        ];
    }
}
