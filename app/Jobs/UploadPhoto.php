<?php

namespace App\Jobs;

use File;
use Image;
use Storage;
use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class UploadPhoto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;
    protected $fileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $fileId)
    {
        $this->fileName = $fileName;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/uploads/' . $this->fileId;

        if (Storage::disk('s3')->put('images/' . $this->fileName, fopen($path, 'r+'))) {
            File::delete($path);
        }
    }
}
