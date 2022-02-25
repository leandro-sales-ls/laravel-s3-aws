<?php

//https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Infrastructure\Storage\FileStorage;
use App\Infrastructure\Storage\S3FileStorage;

class UploadController extends Controller
{
    /* @var FileStorage $storageClient */
    private $storageClient;

    public function __construct() {
        $this->storageClient = new S3FileStorage('bucket-teste');
    }
    
    public function sendFile(Request $request)
    {
        if ($request->file('file')->isValid()) {
            return $request->file('file')->store('imagens', 's3');
        }
    }

    public function listFiles() {
        return $this->storageClient->listAllFiles();
    }

    public function listFileId() {
        // return Storage::disk('s3')->response(request('name_file'));
        return $this->storageClient->find(request('name_file'));
    }
}
