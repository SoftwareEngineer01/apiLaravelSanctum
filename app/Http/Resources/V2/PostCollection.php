<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{

    // public $collects = PostResource::class;


    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
              'organization' => 'Platzi',
              'authors' => [
                'Italomoralesf',
                'Platzi'
              ]
            ],
            'type' => 'articles'
        ];
    }
}
