<?php
declare(strict_types=1);

namespace App\Http\Request\Post;


use App\Application\Post\Dto\CreatePostDto;
use App\Http\Request\ApiFormRequest;

class CreatePostRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return  [
            'title' => 'required',
            'content' => 'required'
        ];
    }

    public function getDto(): CreatePostDto
    {
        return new CreatePostDto(
            $this->input('title'),
            $this->input('content')
        );
    }
}
