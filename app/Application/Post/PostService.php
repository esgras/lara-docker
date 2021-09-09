<?php
declare(strict_types=1);

namespace App\Application\Post;

use App\Application\Post\Dto\CreatePostDto;
use App\Application\Post\Dto\UpdatePostDto;
use App\Models\Post\Post;

class PostService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function get(int $id): Post
    {
        return $this->postRepository->getById($id);
    }

    public function findAll(): array
    {
        return $this->postRepository->findAll();
    }

    public function create(CreatePostDto $dto): Post
    {
        $post = Post::create($dto->getTitle(), $dto->getContent());
        $this->postRepository->save($post);

        return $post;
    }

    public function update(UpdatePostDto $dto): Post
    {
        $post = $this->postRepository->getById($dto->getId());
        $post->change($dto->getTitle(), $dto->getContent());
        $this->postRepository->save($post);

        return $post;
    }

    public function delete(int $id): void
    {
        $post = $this->postRepository->getById($id);
        $this->postRepository->delete($post);
    }
}
