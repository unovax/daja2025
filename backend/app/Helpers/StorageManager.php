<?php
    namespace App\Helpers;


    class StorageManager {
        public static function upload($file, $name, $path): string {
            return $file->storeAs($path, $name, 'public');
        }
    }
