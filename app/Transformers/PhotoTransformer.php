<?php

namespace App\Transformers;

Use App\Photo;

class PhotoTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Photo $photo)
    {
        return [
            'id' => $photo->id,
            'title' => $photo->title,
            'file_photo' => $photo->file_photo,
            'brand' => $photo->brand,
            'tag' => $photo->tag,
            'created_at' => $photo->created_at->toDateTimeString(),
            'created_at_human' => $photo->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Photo $photo)
    {
        return $this->item($photo->user, new UserTransformer);
    }
}
