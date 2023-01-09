<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public static $warp = 'book';

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        $bookManagement = $this->bookManagements->isNotEmpty()
            ? $this->bookManagements->first() : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'imageUrl' => 'https://images-na.ssl-images-amazon.com/images/P/' . $this->image_number . '.09.LZZZZZZZ',
            'company' => $this->company,
            'createdAt' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'status' => $bookManagement
                ? $bookManagement->status : null,
            'userId' => $bookManagement
                ? $bookManagement->user->id : null,
            'userName' => $bookManagement
                ? $bookManagement->user->name : null
        ];
    }
}
