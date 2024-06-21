<?php

namespace App\Traits;

trait UploadHelper
{
    use GenerateRandom;
    public function upload($file, $folderStorage)
    {
        $fileName = time() . '-' . $this->getRandomString(10) . '.' . $file->extension();
//        $originName = $file->getClientOriginalName();
        $location = public_path('uploads/' . $folderStorage);

        $file->move($location, $fileName);

        return $fileName;
    }


}
