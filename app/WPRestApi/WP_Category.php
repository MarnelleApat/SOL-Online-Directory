<?php

namespace App\WPRestApi;

use Illuminate\Support\Facades\Storage;

class WP_Category
{

    public function get()
    {
        $category = Storage::disk('public')->get('category.json');
        $json = json_decode($category, true);
        return $json;
    }

    public function get_cat_by_slug($category_slug)
    {
        $categories = $this->get();

        $returnValue = array();

        foreach($categories as $category)
        {
            if($category['slug'] === $category_slug)
            {
                $returnValue = $category;
            }
        }

        return $returnValue;
    }

}
