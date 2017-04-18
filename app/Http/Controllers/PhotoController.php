<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePhotoRequest;
use App\Transformers\PhotoTransformer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Hanger;
use App\Photo;
use App\Jobs\UploadPhoto;

class PhotoController extends Controller
{
    public function store(StorePhotoRequest $request, Hanger $hanger)
    {

        if ($request->file('file_photo')) {
            $request->file('file_photo')->move(storage_path() . '/uploads', $fileId = uniqid(true));

            $fileName = $fileId . '.png';

            $photo = new Photo();
            $photo->title = $request->title;
            $photo->file_photo = $fileName;
            $photo->brand = $request->brand;
            $photo->tag = $request->tag;
            $photo->user()->associate($request->user());

            $hanger->photos()->save($photo);

            $this->dispatch(new UploadPhoto($fileName, $fileId));
        }

        return response(null, 200);

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
