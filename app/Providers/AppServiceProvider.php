<?php

namespace App\Providers;

use App\Events\CommentCreated;
use App\Listeners\SendCommentNotification;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
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
            'User' => 'App\Models\User',
            'Post' => 'App\Models\Post',
            'Product' => 'App\Models\Product',
        ]);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
