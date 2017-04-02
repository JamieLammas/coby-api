<?php

namespace App\Transformers;

Use App\Photo;

class PhotoTransformer extends \League\Fractal\TransformerAbstract
{
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
}
