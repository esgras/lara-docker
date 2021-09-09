<?php
declare(strict_types=1);

namespace App\Application\Post;

use App\Models\Post\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): Post;

    public function getById(int $id): Post;

    /**
     * @return Post[]
     */
    public function findAll(): array;

    public function delete(Post $post);
}
