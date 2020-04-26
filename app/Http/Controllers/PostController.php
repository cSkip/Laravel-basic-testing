<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    /**
     * @return Post[]|Collection
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
