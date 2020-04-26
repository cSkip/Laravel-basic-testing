<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * RefreshDatabase
     * Trait that refreshes the DB before the tests are executed
     * It will run migrations
     */
    use RefreshDatabase;

    /**
     * WithFaker
     * Trait used to fake data
     */
    use WithFaker;

    /**
     * @covers \App\Http\Controllers\PostController::store()
     */
    public function testCanCreatePost()
    {

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $this->post(route('posts.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * @covers \App\Http\Controllers\PostController::update()
     */
    public function testCanUpdatePost()
    {

        $post = factory(Post::class)->create();

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph
        ];

        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    /**
     * @covers \App\Http\Controllers\PostController::show()
     */
    public function testCanShowPost()
    {

        $post = factory(Post::class)->create();

        $this->get(route('posts.show', $post->id))
            ->assertStatus(200);
    }

    /**
     * @covers \App\Http\Controllers\PostController::delete()
     */
    public function testCanDeletePost()
    {

        $post = factory(Post::class)->create();

        $this->delete(route('posts.delete', $post->id))
            ->assertStatus(204);
    }

    /**
     * @covers \App\Http\Controllers\PostController::index()
     */
    public function testCanListPosts()
    {
        // Create posts with only 3 parameters
        $posts = factory(Post::class, 2)
            ->create()
            ->map(function ($post) {
            return $post->only(['id', 'title', 'content']);
        });

        $this->get(route('posts'))
            ->assertStatus(200)
            ->assertJson($posts->toArray())

            // Assert what the json is structured like and has keys...
            // This will fail if you add keys that are not in the Posts::class
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'content'
                ],
            ]);
    }
}
