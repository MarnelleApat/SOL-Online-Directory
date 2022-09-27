<?php

namespace App\Http\Controllers;

use App\WPRestApi\WP_Category;
use App\WPRestApi\WP_Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function homepage(WP_Post $wp_post, WP_Category $wp_category)
    {
        $categories = $wp_category->get();

        return Inertia::render('Homepage/Main', [
            'canLogin'              => Route::has('login'),
            'canRegister'           => Route::has('register'),
            'navigationMenu'        => $categories,
            'newsArticles'          => $wp_post->get_post_by_category_slug('news'),
            'missionArticles'       => $wp_post->get_post_by_category_slug('mission-stories'),
            'humanitarianArticles'  => $wp_post->get_post_by_category_slug('humanitarian'),
            'theologyArticles'      => $wp_post->get_post_by_category_slug('theology'),
            'opinionArticles'       => $wp_post->get_post_by_category_slug('opinions'),
            'announcementArticles'  => $wp_post->get_post_by_category_slug('announcements'),
            'eventArticles'         => $wp_post->get_post_by_category_slug('events'),
            'videoArticles'         => $wp_post->get_post_by_category_slug('videos'),
            'cultureArticles'       => $wp_post->get_post_by_category_slug('culture'),
            'artArticles'           => $wp_post->get_post_by_category_slug('arts'),
            'generationArticles'    => $wp_post->get_post_by_category_slug('generations'),
            'lifestyleArticles'     => $wp_post->get_post_by_category_slug('lifestyle'),
            'analysisArticles'      => $wp_post->get_post_by_category_slug('analysis'),
            'contributionArticles'  => $wp_post->get_post_by_category_slug('contribution'),
        ]);
    }

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

    public function SingleArticle( WP_Category $wp_category, WP_Post $wp_post, $article_slug )
    {
        $categories = $wp_category->get();
        $post = $wp_post->get_single_post( $article_slug );

        return Inertia::render( 'Articles/Single', [
            'article' => $post,
            'navigationMenu' => $categories
        ]);
    }


}
