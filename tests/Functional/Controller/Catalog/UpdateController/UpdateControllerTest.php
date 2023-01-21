<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Tests\Functional\WebTestCase;

class UpdateControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new UpdateControllerFixture());
    }

    /**
     * @throws \JsonException
     */
    public function test_patch_whole_product(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'name' => 'Product changed',
            'price' => 2000,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page' => null,
            'count' => 1,
            'products' => [
                [
                    'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name' => 'Product changed',
                    'price' => 2000,
                ],
            ]
        ], $response);
    }

    public function test_patch_name_only(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'name' => 'Product changed',
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page' => null,
            'count' => 1,
            'products' => [
                [
                    'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name' => 'Product changed',
                    'price' => 1990,
                ],
            ]
        ], $response);
    }

    public function test_patch_price_only(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'price' => 2000,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page' => null,
            'count' => 1,
            'products' => [
                [
                    'id' => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name' => 'Product 1',
                    'price' => 2000,
                ],
            ]
        ], $response);
    }

}