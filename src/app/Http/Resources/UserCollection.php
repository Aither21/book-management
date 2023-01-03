<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public static $warp = 'users';

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function toArray($request)
    {
        return $this->resource->map(function (
            UserResource $user
        ): UserResource {
            return new UserResource($user);
        });
    }
}
