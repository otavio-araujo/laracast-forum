<?php

use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use function Pest\Laravel\get;

it('should return the correct component', function () {
    $this->withoutExceptionHandling();
    get(route('posts.index'))
        ->assertComponent('Posts/Index');
});

it('passes posts to the view', function () {
    $this->withoutExceptionHandling();

    $posts = Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});

it('can filter to a topic', function () {
    $this->withoutExceptionHandling();
    $general = Topic::factory()->create();
    $posts = Post::factory(2)->for($general)->create();
    $otherPost = Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});

it('passes the selected topic tho the view', function () {
    $this->withoutExceptionHandling();

    $topic = Topic::factory()->create();

    get(route('posts.index', ['topic' => $topic]))
        ->assertHasResource('selectedTopic', TopicResource::make($topic));
});
