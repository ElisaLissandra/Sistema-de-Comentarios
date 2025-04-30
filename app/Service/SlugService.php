<?php

namespace App\Service;
use Illuminate\Support\Str;

class SlugService
{
    public function uniqueSlug($slug, $model)
    {
        $baseSlug = Str::slug($slug);

        $count = $model::where('slug', $baseSlug)->count();

        if($count > 0) {
            $newSlug = $baseSlug . '-' . ($count + 1);
            while($model::where('slug', $newSlug)->exists()) {
                $count++;
                $newSlug = $baseSlug . '-' . ($count + 1);
            }

            return $newSlug;
        }

        return $baseSlug;

    }
}