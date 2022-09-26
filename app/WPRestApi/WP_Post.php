<?php

namespace App\WPRestApi;

use Illuminate\Support\Facades\Storage;

class WP_Post
{
    public function get()
    {
        $posts = Storage::disk('public')->get('post.json');
        $json_post = json_decode($posts, true);

        $returnValue = array();
        $postData = array();
        $cat = [];

        foreach( $json_post as $post)
        {
            $cat = $this->get_post_categories($post['_embedded']['wp:term']);

            $postData = [
                'title'      => $post['title']['rendered'],
                'excerpt'    => strip_tags(str_replace("[&hellip;]","", $post['excerpt']['rendered'])),
                'content'    => $post['content']['rendered'],
                'slug'       => $post['slug'],
                'categories' => $cat,
                'tags'       => $post['tags'],
                'thumbnail'  => $this->get_post_thumbnail($post),
                'author'     => $this->get_post_author($post),
                // 'test'       => $post,
            ];

            array_push( $returnValue, $postData );
        }

        return $returnValue;
    }

    public function get_post_by_category_id($category_id)
    {
        $posts = $this->get();
        $returnValue = array();

        foreach( $posts as $post )
        {
            foreach( $post['categories'] as $category )
            {
                if( in_array($category_id, $category) )
                {
                    array_push( $returnValue, $post );
                }
            }
        }
        return $returnValue;
    }

    public function get_post_by_category_slug($category_slug)
    {
        $posts = $this->get();
        $returnValue = array();

        foreach( $posts as $post )
        {
            foreach( $post['categories'] as $category )
            {
                if($category['slug'] === $category_slug)
                    array_push( $returnValue, $post );
            }
        }
        return $returnValue;
    }

    public function get_post_categories( $arrays_of_categories )
    {

        $ArryCat = array();
        $returnValue = array();

        foreach( $arrays_of_categories as $category)
        {
            foreach( $category as $cat)
            {
                $ArryCat = [
                    'id' => $cat['id'],
                    'name' => $cat['name'],
                    'slug' => $cat['slug']
                ];

                array_push( $returnValue, $ArryCat );
            }
        }
        return $returnValue;
    }

    public function get_post_thumbnail( $post )
    {
        if($post['featured_media'] > 0)
            return $post['_embedded']['wp:featuredmedia'][0]['source_url'];
        else
            return 'https://via.placeholder.com/350x200?text=Streams+of+Life';
    }

    public function get_post_author( $post )
    {
        $author = array();
        $author = $post['_embedded']['author'];

        return $author;
    }

    public function get_single_post( $post_slug )
    {
        $posts = $this->get();
        $returnValue = array();

        foreach( $posts as $post )
        {
            if($post['slug'] === $post_slug)
                $returnValue = $post;
        }

        return $returnValue;
    }

}
