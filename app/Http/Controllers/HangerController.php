<?php

namespace App\Http\Controllers;

use App\Hanger;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHangerRequest;
use App\Http\Requests\UpdateHangerRequest;
use App\Transformers\HangerTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class HangerController extends Controller
{
    public function index()
    {
        $hangers = Hanger::latestFirst()->paginate(3);
        $hangersCollection = $hangers->getCollection();

        return fractal()
            ->collection($hangersCollection)
            ->parseIncludes(['user'])
            ->transformWith(New HangerTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($hangers))
            ->toArray();
    }

    public function show(Hanger $hanger)
    {
        //$this->authorize('update', $hanger);

        return fractal()
            ->item($hanger)
            ->parseIncludes(['user', 'photos', 'photos.user'])
            ->transformWith(new HangerTransformer)
            ->toArray();
    }

    public function store(StoreHangerRequest $request)
    {
        $hanger = new Hanger;
        $hanger->title = $request->title;
        $hanger->user()->associate($request->user());

        $hanger->save();

        //transform
        return fractal()
            ->item($hanger)
            ->parseIncludes(['user'])
            ->transformWith(new HangerTransformer)
            ->toArray();
    }

    public function update(UpdateHangerRequest $request, Hanger $hanger)
    {
        $this->authorize('update', $hanger);

        $hanger->title = $request->get('title', $request->title);

        $hanger->save();

        return fractal()
            ->item($hanger)
            ->parseIncludes(['user'])
            ->transformWith(new HangerTransformer)
            ->toArray();
    }

    public function destroy(UpdateHangerRequest $request, Hanger $hanger)
    {
        $this->authorize('destroy', $hanger);

        $hanger->delete();

        return response(null, 204);
    }


}
