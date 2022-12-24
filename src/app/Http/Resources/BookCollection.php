<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class BookCollection extends ResourceCollection
{
    public static $warp = 'books';

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function toArray($request): Collection
    {
        return $this->resource->map(function (
            BookResource $book
        ): BookResource {
            return new BookResource($book);
        });
    }
}
