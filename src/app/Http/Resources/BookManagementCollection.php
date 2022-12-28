<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookManagementCollection extends ResourceCollection
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function toArray($request)
    {
        return $this->resource->map(function (
            BookManagementResource $book
        ): BookManagementResource {
            return new BookManagementResource($book);
        });
    }
}
