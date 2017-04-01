<?php

namespace App\Http\Controllers;

use App\Hanger;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHangerRequest;

class HangerController extends Controller
{
    public function store(StoreHangerRequest $request)
    {
        $hanger = new Hanger;
        $hanger->title = $request->title;
        $hanger->user()->associate($request->user());

        $hanger->save();

        //transform
    }

}
