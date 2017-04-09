<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePhotoRequest;
use App\Transformers\PhotoTransformer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Storage;
use App\Photo;
use App\Hanger;

class PhotoController extends Controller
{
    protected $allowedFileExtensions = ['png', 'jpg', 'gif'];

    public function store(StorePhotoRequest $request, Hanger $hanger)
    {

        $file = $request->file_photo->move(storage_path() . '/uploads', $fileId = uniqid(true));

        $path = storage_path() . '/uploads/' . $fileId;

        $fileName = $fileId . '.png';
        //dd($fileName);
        Storage::disk('s3')->put('images/' . $fileName, fopen($path, 'r+'));

        //Storage::disk('s3')->put(
        //    $this->buildFilePath($name),
        //    file_get_contents($file->getRealPath()),
        //    'public'
        //);



        //$photo = new Photo;
        //$photo->title = $request->title;
        //$photo->brand = $request->brand;
        //$photo->tag = $request->tag;
        //$photo->file_photo = $this->buildAbsoluteFilePath($name);
        //$photo->user()->associate($request->user());

        //$hanger->photos()->save($photo);

        //return fractal()
        //    ->item($photo)
        //    ->parseIncludes(['user'])
        //    ->transformwith(new PhotoTransformer)
        //    ->toArray();

    }

    protected function isAllowedFile(UploadedFile $file)
    {
        return in_array(
            $file->getClientOriginalExtension(),
            $this->allowedFileExtensions
        );
    }

    protected function buildFilePath($name)
    {
        return 'Images/' . $name;
    }

    protected function buildAbsoluteFilePath($name)
    {
        return 'https://s3.us-east-2.amazonaws.com/coby.app/' . $this->buildFilePath($name);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
