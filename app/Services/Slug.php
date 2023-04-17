<?php

namespace App\Services;

use Illuminate\Support\Str;

class Slug
{
    public function createSlug($title='',$model, $programCode = null)
    {

        $slug = Str::slug($title);
        $allSlugs = $this->getRelatedSlugs($slug,$model, $programCode);
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }

    public function getRelatedSlugs($slug,$model, $programCode = null)
    {
        $m = $model::class;

        return $m::select('slug')->where('slug', 'like', $slug.'%')
        ->where('programCode', '<>', $programCode)
        ->get();
    }
}
