<?php

namespace App\Controller;

use App\Service\Random;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Welcome endpoints controller
 */
class WelcomeController extends AbstractController
{
    #[Route('/welcome/customer/{id}', name: 'app_welcome_customer_id', methods: ['GET'])]
    #[Get(
        path: '/welcome/customer/{id}',
        description: 'Complex object describing the user',
        summary: 'Customer by ID',
        tags: ['welcome'],
        parameters: [
            new Parameter(
                name: 'id',
                description: 'Some ID from "customer" table',
                in: 'path',
                required: true,
                schema: new Schema(type: 'integer')
            )
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Not simple customer object',
                content: [
                    new JsonContent(ref: '#/components/schemas/Customer')
                ]
            ),
            new Response(response: 400, description: 'Bad Request'),
            new Response(response: 404, description: 'Not found'),
        ]
    )]
    public function customer($id, Random $random): JsonResponse
    {
        return $this->json([
            [
                'id' => $id,
                'name' => 'Ермолаева София Никаноровна',
                'dob' => $random->date(),
                'average_check' => $random->float(),
                'orders_amount' => $random->int(),
                'last_orders' => array_fill(0, 3, [
                    'id' => $random->leadZeros(),
                    'price' => $random->float(),
                    'date' => $random->date(),
                ]),
            ],
        ]);
    }

    #[Route('/welcome/list/persons', name: 'app_welcome_list_persons', methods: ['GET'])]
    #[Get(
        path: '/welcome/list/persons',
        description: 'Example of some persons list from USA',
        summary: 'Persons list',
        tags: ['welcome'],
        responses: [
            new Response(
                response: 200,
                description: 'Arrays list with keys: "person" and "dob"',
                content: [
                    new JsonContent(ref: '#/components/schemas/PersonsList')
                ]
            ),
            new Response(response: 400, description: 'Bad Request'),
            new Response(response: 404, description: 'Not found'),
        ]
    )]
    public function listPersons(Random $random): JsonResponse
    {
        return $this->json(array_fill(0, 3, [
            'person' => $random->name(),
            'dob' => $random->date(),
        ]));
    }

    #[Route('/welcome/list/emails', name: 'app_welcome_list_emails', methods: ['GET'])]
    #[Get(
        path: '/welcome/list/emails',
        description: 'Example of some yandex email addresses',
        summary: 'Emails list',
        tags: ['welcome'],
        responses: [
            new Response(
                response: 200,
                description: 'String emails list',
                content: [
                    new JsonContent(ref: '#/components/schemas/EmailsList')
                ]
            ),
            new Response(response: 400, description: 'Bad Request'),
            new Response(response: 404, description: 'Not found'),
        ]
    )]
    public function listEmails(Random $random): JsonResponse
    {
        return $this->json(array_fill(0, 3, $random->email()));
    }

    #[Route('/welcome', name: 'app_welcome', methods: ['GET'])]
    #[Get(
        path: '/welcome',
        description: 'Default response from new Controller method with JsonResponse',
        summary: 'Welcome message',
        tags: ['welcome'],
        responses: [
            new Response(
                response: 200,
                description: 'Keys "message" and "path"',
                content: [
                    new JsonContent(ref: '#/components/schemas/JsonDefault')
                ]
            ),
            new Response(response: 400, description: 'Bad Request'),
            new Response(response: 404, description: 'Not found'),
        ]
    )]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/WelcomeController.php',
        ]);
    }
}
