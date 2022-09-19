<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function PostByCategory( $slug )
    {

        $articles = [
            [
                'id' => '1',
                'title' => 'Test',
                'slug' => 'test',
                'content' => 'While the pandemic has impacted many, it has magnified the inequalities within society, where the most vulnerable groups in society have been heavily affected.'
            ],
            [
                'id' => '2',
                'title' => 'Test2',
                'slug' => 'test2',
                'content' => 'While the pandemic has impacted many, it has magnified the inequalities within society, where the most vulnerable groups in society have been heavily affected.'
            ],
            [
                'id' => '3',
                'title' => 'Test3',
                'slug' => 'test3',
                'content' => 'While the pandemic has impacted many, it has magnified the inequalities within society, where the most vulnerable groups in society have been heavily affected.'
            ]

        ];

        return Inertia::render( 'Articles/Category', [
            'catData' => ['articles' => $articles, 'slug' => $slug]
         ] );
    }
}
