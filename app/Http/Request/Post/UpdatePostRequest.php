<?php
declare(strict_types=1);

namespace App\Http\Request\Post;

use App\Application\Post\Dto\CreatePostDto;
use App\Application\Post\Dto\UpdatePostDto;
use App\Http\Request\ApiFormRequest;

class UpdatePostRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return  [
            'title' => 'required',
            'content' => 'required'
        ];
    }

    public function getDto(int $id): UpdatePostDto
    {
        return new UpdatePostDto(
            $id,
            $this->input('title'),
            $this->input('content')
        );
    }
}
