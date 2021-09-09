<?php

namespace App\Http\Controllers\Api;

use App\Application\Post\PostService;
use App\Http\Controllers\Controller;
use App\Http\Request\Post\CreatePostRequest;
use App\Http\Request\Post\UpdatePostRequest;
use App\Models\Post\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function findAll(): JsonResponse
    {
        return new JsonResponse(
            $this->postService->findAll()
        );
    }

    public function find(int $id): JsonResponse
    {
        return new JsonResponse(
            $this->postService->get($id)
        );
    }

    public function create(CreatePostRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        return new JsonResponse(
            $this->postService->create($dto)
        );
    }

    public function update(int $id, UpdatePostRequest $request): JsonResponse
    {
        $dto = $request->getDto($id);

        return new JsonResponse(
            $this->postService->update($dto)
        );
    }

    public function delete(int $id): Response
    {
        $this->postService->delete($id);
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
