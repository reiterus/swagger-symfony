<?php

namespace App\Controller;

use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Patch;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Fake CRUD endpoints controller
 */
class ItemController extends AbstractController
{
    #[Route('/crud/get/item/{id}', name: 'app_crud_get_item_id', methods: ['GET'])]
    #[Get(
        path: '/crud/get/item/{id}',
        description: 'Retrieve one row from "item" table by row ID',
        summary: 'Get one table row',
        tags: ['fake CRUD'],
        parameters: [
            new Parameter(
                name: 'id',
                description:'Some ID from "item" table',
                in: 'path',
                required: true,
                schema: new Schema(type: 'integer')
            )
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Some response from database',
                content: [
                    //new JsonContent(ref: '#/components/schemas/JsonDefault')
                    new JsonContent(
                        properties: [
                            new Property(property: 'id',type: 'integer',example: 12),
                            new Property(property: 'title',type: 'string',example: 'Some Title'),
                            new Property(property: 'date',type: 'string', format: 'date' ,example: '2022-12-24'),
                        ],
                        type: 'object'
                    )
                ]
            ),
            new Response(response: 400,description: 'Bad Request'),
            new Response(response: 404,description: 'Not found'),
        ]
    )]
    public function index(int $id): JsonResponse
    {
        return $this->json([
            'id' => $id,
            'title' => 'Some Response Title',
            'date' => '1972-11-11'
        ]);
    }

    #[Route('/crud/post/item', name: 'app_crud_post_item', methods: ['POST'])]
    #[Post(
        path: '/crud/post/item',
        description: 'Create one row in "item" table',
        summary: 'Add new table row',
        requestBody: new RequestBody(
            content: [
                new JsonContent(ref: '#/components/schemas/DummyRequestBody')
            ]
        ),
        tags: ['fake CRUD'],
        responses: [
            new Response(
                response: 200,
                description: 'Response after creating',
                content: [
                    new JsonContent(
                        properties: [
                            new Property(property: 'message',type: 'string',example: 'Row created'),
                            new Property(property: 'request',type: 'string',example: 'Some JSON data'),
                        ],
                        type: 'object'
                    )
                ]
            ),
            new Response(response: 400,description: 'Bad Request'),
            new Response(response: 404,description: 'Not found'),
        ]
    )]
    public function post(Request $request): JsonResponse
    {
        $id = rand(5, 56);
        $data = $request->toArray();
        return $this->json([
            'message' => sprintf('Successfully created row with #%d', $id),
            'request' => $data,
            'row' => array_merge(['id' => $id], $data, ['created_at' => date('Y-m-d')]),
        ]);
    }

    #[Route('/crud/put/item', name: 'app_crud_put_item', methods: ['PUT'])]
    #[Put(
        path: '/crud/put/item',
        description: 'Create a new resource or replaces a representation of the target resource with the request payload',
        summary: 'Add/replace table row',
        requestBody: new RequestBody(
            content: [
                new JsonContent(ref: '#/components/schemas/DummyRequestBody')
            ]
        ),
        tags: ['fake CRUD'],
        responses: [
            new Response(
                response: 200,
                description: 'Response after creating/replacing',
                content: [
                    new JsonContent(
                        properties: [
                            new Property(property: 'message',type: 'string',example: 'Row created'),
                            new Property(property: 'request',type: 'string',example: 'Some JSON data'),
                        ],
                        type: 'object'
                    )
                ]
            ),
            new Response(response: 400,description: 'Bad Request'),
            new Response(response: 404,description: 'Not found'),
        ]
    )]
    public function put(Request $request): JsonResponse
    {
        $id = rand(8, 86);
        $data = $request->toArray();
        return $this->json([
            'message' => sprintf('Successfully updated row with #%d', $id),
            'request' => $data,
        ]);
    }

    #[Route('/crud/patch/item/{id}', name: 'app_crud_patch_item_id', methods: ['PATCH'])]
    #[Patch(
        path: '/crud/patch/item/{id}',
        description: 'Change some fields of one row from "item" table by row ID',
        summary: 'Update one table row',
        requestBody: new RequestBody(
            content: [
                new JsonContent(
                    properties: [
                        new Property(property: 'title', type: 'string', example: 'New Title', nullable: false),
                        new Property(property: 'date',type: 'string', format: 'date' ,example: '2022-12-24', nullable: false),
                    ],
                    type: 'object'
                )
            ]
        ),
        tags: ['fake CRUD'],
        parameters: [
            new Parameter(
                name: 'id',
                description:'Some ID from "item" table',
                in: 'path',
                required: true,
                schema: new Schema(type: 'integer')
            )
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Response after removing',
                content: [
                    new JsonContent(
                        properties: [
                            new Property(property: 'message',type: 'string',example: 'Row 2 updated'),
                            new Property(property: 'request',type: 'string',example: 'Some JSON data'),
                        ],
                        type: 'object'
                    )
                ]
            ),
            new Response(response: 400,description: 'Bad Request'),
            new Response(response: 404,description: 'Not found'),
        ]
    )]
    public function patch(int $id, Request $request): JsonResponse
    {
        return $this->json([
            'message' => sprintf('Successfully updated row with #%d', $id),
            'request' => array_filter($request->toArray())
        ]);
    }

    #[Route('/crud/delete/item/{id}', name: 'app_crud_delete_item_id', methods: ['DELETE'])]
    #[Delete(
        path: '/crud/delete/item/{id}',
        description: 'Remove one row from "item" table by row ID',
        summary: 'Delete one table row',
        tags: ['fake CRUD'],
        parameters: [
            new Parameter(
                name: 'id',
                description:'Some ID from "item" table',
                in: 'path',
                required: true,
                schema: new Schema(type: 'integer')
            )
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Response after removing',
                content: [
                    new JsonContent(
                        properties: [
                            new Property(property: 'message',type: 'string',example: 'Row 1 deleted'),
                        ],
                        type: 'object'
                    )
                ]
            ),
            new Response(response: 400,description: 'Bad Request'),
            new Response(response: 404,description: 'Not found'),
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        return $this->json([
            'message' => sprintf('Successfully deleted row with id = %d', $id),
        ]);
    }
}
