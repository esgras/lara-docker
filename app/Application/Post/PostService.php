<?php
declare(strict_types=1);

namespace App\Application\Post;

use App\Application\Post\Dto\CreatePostDto;
use App\Application\Post\Dto\UpdatePostDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService
{
    public function get(int $id): array
    {
        return $this->getById($id);
    }

    public function getAll(): array
    {
        return $this->getData();
    }

    public function create(CreatePostDto $dto): array
    {
        $id = max(array_map(fn($arr) => $arr['id'], $this->getData()));
        return ['id' => $id, 'title' => "Post #{$id}", 'content' => "Content {$id}"];
    }

    public function update(UpdatePostDto $dto): array
    {
        $post = $this->getById($dto->getId());
        $post['title'] = $dto->getTitle();
        $post['content'] = $dto->getContent();

        return $post;
    }

    public function delete(int $id): void
    {

    }


    private function getData(): array
    {
        return [
            ['id' => 1, 'title' => 'First Post', 'content' => 'Post 1'],
            ['id' => 2, 'title' => 'Second Post', 'content' => 'Post 2'],
            ['id' => 3, 'title' => 'Third Post', 'content' => 'Post 3'],
            ['id' => 4, 'title' => 'Fourth Post', 'content' => 'Post 4'],
            ['id' => 5, 'title' => 'Fifth Post', 'content' => 'Post 5'],
        ];
    }

    private function getById(int $id): array
    {
        foreach ($this->getData() as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }

        throw new NotFoundHttpException("Post with id {$id} not found");
    }
}
