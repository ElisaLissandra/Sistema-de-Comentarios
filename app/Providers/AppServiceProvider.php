<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Post
        $this->app->bind(
            'App\Interfaces\PostRepositoryInterface',
            'App\Repositories\PostRepository'
        );

        //Product
        $this->app->bind(
            'App\Interfaces\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );

        //Comment
        $this->app->bind(
            'App\Interfaces\CommentRepositoryInterface',
            'App\Repositories\CommentRepository'
        );


        Relation::enforceMorphMap([
            'Post' => 'App\Models\Post',
            'Product' => 'App\Models\Product',
        ]);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
