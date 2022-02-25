<?php

namespace App\Infrastructure\Storage;

interface FileStorage {

    public function listAllFiles(): array;

    public function uploadFile(array $params);
}
