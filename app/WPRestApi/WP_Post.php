<?php

namespace App\WPRestApi;

use App\WPRestApi\WP_ResponseParser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class WP_Post
{
    // private string $wp_api_url_namespace = 'https://beta.streamsoflife.sg/wp-json/wp/v2/posts';

    public function get()
    {
        $posts = Storage::disk('public')->get('post.json');
        $json = json_decode($posts, true);
        return $json;

    }

    public function get_post_by_category_id($category_id)
    {
        $posts = $this->get();
        $returnValue = array();

        foreach($posts as $posts_by_catagory)
        {
            if( in_array($category_id, $posts_by_catagory['categories']) )
            {
                array_push( $returnValue, $posts_by_catagory );
            }
        }

        return $returnValue;
    }

    // public function get_post_by_category( $cat_id, $perpage = null ): object
    // {
    //     $post_url = $this->wp_api_url_namespace . '?categories=' . $cat_id. (($perpage != null || $perpage > 0) ? '&per_page='.$perpage : '');
    //     $JSON = new WP_ResponseParser($post_url);
    //     return collect($JSON->process());
    // }

}
