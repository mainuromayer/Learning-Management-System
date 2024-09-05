<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

trait FileUploadTrait
{
    /**
     * Uploads a file to the server and returns the path where the file has been saved.
     * @param $file
     * @return string
     */
    public function uploadFile($file): string
    {
        try {
            if (!$file->isValid()) {
                throw new Exception('Invalid file uploaded.');
            }

            $year = date('Y');
            $month = date('m');
            $year_month = $year . '/' . $month . '/';
            $local_path = public_path('images/' . $year_month); // Use public_path helper
            $db_path = uniqid(time() . '_', false) . '.' . $file->getClientOriginalExtension();

            // Create directories if they don't exist
            if (!file_exists($local_path)) {
                // Ensure parent directory exists
                $parent_directory = dirname($local_path);
                if (!file_exists($parent_directory)) {
                    mkdir($parent_directory, 0755, true);
                }

                mkdir($local_path, 0755, true);
                // Optionally create an index.html file to prevent directory listing
                file_put_contents($local_path . 'index.html', '');
            }

            $file->move($local_path, $db_path);

            // Return the path relative to the public directory
            return 'images/' . $year_month . $db_path;

        } catch (Exception $e) {
            Log::error("Error occurred in FileUploadTrait@uploadFile ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data store [FileUpload-101]");
            return Redirect::back()->withInput();
        }
    }
}

