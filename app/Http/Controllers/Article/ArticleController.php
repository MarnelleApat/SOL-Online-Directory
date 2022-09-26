<?php

namespace App\Http\Controllers\Article;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WPRestApi\WP_Category;
use App\WPRestApi\WP_Post;

class ArticleController extends Controller
{
    public function PostByCategory( WP_Category $wp_category, WP_Post $wp_post, $category_slug )
    {
        $categories = $wp_category->get();
        $category = $wp_category->get_cat_by_slug($category_slug);
        $articles = $wp_post->get_post_by_category_id( $category['id'] );

        return Inertia::render( 'Articles/ArticlesByCategory', [
            'articles' => $articles,
            'category_name' => $category['name'],
            'navigationMenu' => $categories
        ]);
    }

    public function SingleArticle( $article_slug )
    {
        $article = [
            'id' => '1',
            'title' => 'AGWO Celebrates Pongal Festival with the Guest Workers at Kranji',
            'date' => 'August 20, 2021',
            'author' => 'HIA',
            'slug' => 'test4',
            'url' => 'https://beta.streamsoflife.sg/wp-content/uploads/2022/06/WhatsApp-Image-2022-06-06-at-4.44.17-PM-768x431.jpeg',
            'content' => 'Over 500 <strong>guest workers</strong> from 70 dormitories came together at <u>Kranji Recreation</u> Centre on Sunday, 16 January from 2-9pm, celebrating the festivities of Pongal Festival, which is widely celebrated by'
        ];

        return Inertia::render( 'Articles/Single', ['article' => $article]);
    }

}
