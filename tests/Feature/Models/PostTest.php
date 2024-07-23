<?php

use App\Models\Post;

it('uses title case for titles', function () {
    $post = Post::factory()->create(['title' => 'Hello, how are you?']);

    expect($post->title)->toBe('Hello, How Are You?');
});

it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});

it('can generate additional query parameters to show route', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});
