<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = fn() => [
        'title' => 'Hello World',
        'topic_id' => Topic::factory()->create()->getKey(),
        'body' => str_repeat('This is my very first post', 10),
    ];
});

it('requires authentication', function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('stores a post', function () {

    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $data = value($this->validData);

    actingAs($user)->post(route('posts.store', $data));

    $this->assertDatabaseHas('posts', [
        ...$data,
        'user_id' => $user->id,
    ]);

});

it('redirects to the post show page', function () {
    $user = User::factory()->create();
    $data = value($this->validData);

    actingAs($user)
        ->post(route('posts.store'), $data)
        ->assertRedirect(Post::latest('id')->first()->showRoute());
});

it('requires valid data', function (array $badData, array|string $errors) {
    $user = User::factory()->create();
    $data = value($this->validData);

    actingAs($user)
        ->post(route('posts.store'), [...$data, ...$badData])
        ->assertInvalid($errors);
})->with([
    [['title' => null], 'title'],
    [['title' => true], 'title'],
    [['title' => 1], 'title'],
    [['title' => 1.5], 'title'],
    [['title' => str_repeat('a', 121)], 'title'],
    [['title' => str_repeat('a', 9)], 'title'],
    [['topic_id' => null], 'topic_id'],
    [['topic_id' => -1], 'topic_id'],
    [['topic_id' => 'string'], 'topic_id'],
    [['body' => null], 'body'],
    [['body' => true], 'body'],
    [['body' => 1], 'body'],
    [['body' => 1.5], 'body'],
    [['body' => str_repeat('a', 10_001)], 'body'],
    [['body' => str_repeat('a', 99)], 'body'],
]);
