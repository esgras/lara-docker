<?php
declare(strict_types=1);

namespace Tests\Functional\Controller\Api;

use Tests\TestCase;

class PostControllerTest extends TestCase
{
    private const API_PREFIX = '/api/posts';

    public function testCreate(): array
    {
        $data = [
            'title' => 'New Post',
            'content' => 'New Content'
        ];

        $response = $this->json('POST', self::API_PREFIX, $data);

        $content = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJson($data);

        return $content;
    }

    /**
     * @depends testCreate
     */
    public function testFindAll(): void
    {
        $response = $this->get(self::API_PREFIX);

        $response->assertStatus(200);
        $data = json_decode($response->content());

        $this->assertGreaterThanOrEqual(1, $data);
    }

    /**
     * @depends testCreate
     */
    public function testFind(array $content): array
    {
        $id = $content['id'];
        $response = $this->get(self::API_PREFIX . '/' . $id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $id]);

        return $content;
    }

    /**
     * @depends testFind
     */
    public function testCreateTitleRequiredError(): void
    {
        $response = $this->json('POST', self::API_PREFIX, []);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The title field is required.']);
    }

    /**
     * @depends testCreateTitleRequiredError
     */
    public function testCreateContentRequiredError(): void
    {
        $response = $this->json('POST', self::API_PREFIX, ['title' => 'test']);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The content field is required.']);
    }

    /**
     * @depends testFind
     */
    public function testUpdate(array $content): void
    {
        $data = [
            'title' => 'New Post2',
            'content' => 'New Content2'
        ];

        $response = $this->json('PUT', self::API_PREFIX  . '/' .  $content['id'], $data);

        $response->assertStatus(200);
        $response->assertJson($data);
    }

    /**
     * @depends testFind
     */
    public function testUpdateTitleRequiredError(array $content): void
    {
        $response = $this->json('PUT', self::API_PREFIX  . '/' . $content['id'], []);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The title field is required.']);
    }

    /**
     * @depends testFind
     */
    public function testUpdateContentRequiredError(array $content): void
    {
        $response = $this->json('PUT', self::API_PREFIX   . '/' .  $content['id'], ['title' => 'title']);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The content field is required.']);
    }

    /**
     * @depends testFind
     */
    public function testDelete(array $content): void
    {
        $response = $this->delete(self::API_PREFIX   . '/' .  $content['id']);

        $response->assertStatus(204);
    }
}
