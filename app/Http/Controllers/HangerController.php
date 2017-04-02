<?php

namespace App\Http\Controllers;

use App\Hanger;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHangerRequest;
use App\Transformers\HangerTransformer;

class HangerController extends Controller
{
    public function store(StoreHangerRequest $request)
    {
        $hanger = new Hanger;
        $hanger->title = $request->title;
        $hanger->user()->associate($request->user());

        $hanger->save();

        //transform
        return fractal()
            ->item($hanger)
            ->parseIncludes(['user', 'photos'])
            ->transformWith(new HangerTransformer)
            ->toArray();
    }

}
