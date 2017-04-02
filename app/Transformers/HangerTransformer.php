<?php

namespace App\Transformers;

Use App\Hanger;

class HangerTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'photos'];

    public function transform(Hanger $hanger)
    {
        return [
            'id' => $hanger->id,
            'title' => $hanger->title,
            'created_at' => $hanger->created_at->toDateTimeString(),
            'created_at_human' => $hanger->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Hanger $hanger)
    {
        return $this->item($hanger->user, new UserTransformer);
    }

    public function includePhotos(Hanger $hanger)
    {
        return $this->collection($hanger->photos, new PhotoTransformer);
    }

}
