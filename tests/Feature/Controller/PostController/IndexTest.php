<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use function Pest\Laravel\get;

it('should return the correct component', function () {
    $this->withoutExceptionHandling();
    get(route('posts.index'))
        ->assertComponent('Posts/Index');
});

it('passes posts to the view', function () {
    $this->withoutExceptionHandling();

    $posts = Post::factory(3)->create();

    $posts->load('user');

    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});
