<?php

namespace App\Infrastructure\Storage;

use Aws\S3\S3Client;

class S3FileStorage implements FileStorage {

    /* @var S3Client $s3Client */
    private $s3Client;

    /* @var string $bucketName */
    private $bucketName;

    public function __construct(string $bucketName) {
        $this->s3Client = new S3Client([
            'endpoint' => 'http://localstack:4566',
            'use_path_style_endpoint' => true,
            'version' => 'latest',
            'region'  => 'us-east-1',
            'credentials' => [
                'key' => 'minhaChave',
                'secret' => 'minhaChaveSecreta',
            ],
        ]);

        $this->bucketName = $bucketName;
    }

    public function listAllFiles(): array {
        // $continuationToken = '';
        $files = [];
        
        do {
            $result = $this->s3Client->listObjectsV2([
                'Bucket' => $this->bucketName,
                // 'ContinuationToken' => $continuationToken,
                'MaxKeys' => 1000,
            ]);
            
            array_push($files, $result['Contents']);
            // $continuationToken = isset($result['NextContinuationToken']) ?? $result['NextContinuationToken'];
        } while($result['IsTruncated']);

        return $files;
    }

    public function find($id) {
        return $this->s3Client->getObject(['Bucket' => $this->bucketName, 'Key'=>$id]);
    }

    public function uploadFile(array $params) {
        $this->s3Client->putObject([
            'ACL' => 'private',
            'Body' => $params['fileContent'],
            'Bucket' => $this->bucketName, // REQUIRED
            'BucketKeyEnabled' => true,
            'ContentType' => 'application/json',
            'Key' => $params['fileName'], // REQUIRED
            'ServerSideEncryption' => 'AES256',
            'StorageClass' => 'INTELLIGENT_TIERING',
        ]);
    }
}
