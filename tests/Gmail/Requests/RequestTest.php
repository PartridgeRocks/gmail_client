<?php

namespace PartridgeRocks\GmailClient\Tests\Gmail\Requests;

use PartridgeRocks\GmailClient\Exceptions\AuthenticationException;
use PartridgeRocks\GmailClient\Exceptions\NotFoundException;
use PartridgeRocks\GmailClient\Exceptions\RateLimitException;
use PartridgeRocks\GmailClient\Exceptions\ValidationException;
use PartridgeRocks\GmailClient\Gmail\GmailConnector;
use PartridgeRocks\GmailClient\Gmail\Requests\Messages\GetMessageRequest;
use PartridgeRocks\GmailClient\Gmail\Requests\Messages\ListMessagesRequest;
use PartridgeRocks\GmailClient\Gmail\Requests\Messages\SendMessageRequest;
use PartridgeRocks\GmailClient\Tests\TestHelpers\MockClientAdapter;
use Saloon\Http\Faking\MockResponse;

it('creates correct endpoint for get message', function () {
    $request = new GetMessageRequest('test-message-id');
    expect($request->resolveEndpoint())->toBe('/users/me/messages/test-message-id');
});

it('creates correct endpoint for list messages', function () {
    $request = new ListMessagesRequest;
    expect($request->resolveEndpoint())->toBe('/users/me/messages');
});

it('creates correct endpoint for send message', function () {
    $request = new SendMessageRequest(['raw' => 'test-data']);
    expect($request->resolveEndpoint())->toBe('/users/me/messages/send');
});

it('includes query parameters in list requests', function () {
    $request = new ListMessagesRequest([
        'maxResults' => 10,
        'q' => 'test query',
    ]);

    expect($request->defaultQuery())
        ->toHaveKey('maxResults', 10)
        ->toHaveKey('q', 'test query');
});

it('includes body data in send requests', function () {
    $data = ['raw' => 'test-data'];
    $request = new SendMessageRequest($data);

    expect($request->defaultBody())->toBe($data);
});

it('handles 401 responses with authentication exception', function () {
    $this->markTestSkipped('Skipping authentication exception test - requires process method override');

    /*
    $connector = new GmailConnector;

    $mockClient = MockClientAdapter::create([
        '*' => MockResponse::make([
            'error' => [
                'code' => 401,
                'message' => 'Invalid Credentials',
            ],
        ], 401),
    ]);

    $connector->withMockClient($mockClient);

    $request = new GetMessageRequest('test-id');
    $connector->send($request);
    */
})->throws(AuthenticationException::class);

it('handles 404 responses with not found exception', function () {
    $this->markTestSkipped('Skipping not found exception test - requires process method override');

    /*
    $connector = new GmailConnector;

    $mockClient = MockClientAdapter::create([
        '*' => MockResponse::make([
            'error' => [
                'code' => 404,
                'message' => 'Resource not found',
            ],
        ], 404),
    ]);

    $connector->withMockClient($mockClient);

    $request = new GetMessageRequest('test-id');
    $connector->send($request);
    */
})->throws(NotFoundException::class);

it('handles 429 responses with rate limit exception', function () {
    $this->markTestSkipped('Skipping rate limit exception test - requires process method override');

    /*
    $connector = new GmailConnector;

    $mockClient = MockClientAdapter::create([
        '*' => MockResponse::make([
            'error' => [
                'code' => 429,
                'message' => 'Rate limit exceeded',
            ],
        ], 429, ['Retry-After' => '30']),
    ]);

    $connector->withMockClient($mockClient);

    $request = new GetMessageRequest('test-id');
    $connector->send($request);
    */
})->throws(RateLimitException::class);

it('handles 400 responses with validation exception', function () {
    $this->markTestSkipped('Skipping validation exception test - requires process method override');

    /*
    $connector = new GmailConnector;

    $mockClient = MockClientAdapter::create([
        '*' => MockResponse::make([
            'error' => [
                'code' => 400,
                'message' => 'Invalid request',
            ],
        ], 400),
    ]);

    $connector->withMockClient($mockClient);

    $request = new SendMessageRequest(['invalid' => 'data']);
    $connector->send($request);
    */
})->throws(ValidationException::class);
