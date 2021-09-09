<?php
declare(strict_types=1);

namespace App\Repository\Sql;

use App\Application\Post\PostRepositoryInterface;
use App\Models\Post\Post;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @throws NotFoundHttpException
     */
    public function getById(int $id): Post
    {
        $post = Post::find($id);
        if ($post === null) {
            throw new NotFoundHttpException("Post with id {$id} not found");
        }

        return $post;
    }

    public function save(Post $post): Post
    {
        $post->save();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return Post::all()->toArray();
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
