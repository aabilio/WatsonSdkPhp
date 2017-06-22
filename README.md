# IBM Watson Services PHP SDK
[![Build Status](https://travis-ci.org/aabilio/WatsonSdkPhp.svg?branch=master)](https://travis-ci.org/aabilio/WatsonSdkPhp)

PHP SDK for IBM Watson services

**Note: This project is at an early stage of development and should not be used for production.**

### Fully developed services

 * 
 
### Services in development

 * Watson Conversation Service


[Online PHP Docs here](https://aabilio.github.io/WatsonSdkPhp/index.html)

## Using Conversation Service Version 1

```php
<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use WatsonSdkPhp\Factories\WatsonFactory;
// use WatsonSdkPhp\Services\Conversation\V1\WatsonConversationService;

// Getting Conversation Service
$watsonFactory = new WatsonFactory("<username>", "<password>");
$conversationService = $watsonFactory->createConversationServiceV1("<workspace_id>");
// or $conversationService = new WatsonConversationService("<username>", "<password>", "workspace_id");

// Send message
$conversation = $conversationService->sendMessage("Hi!");
// Get the response and the context
$context = $conversation->getContext();
$messages = $conversation->getTextResponse();
foreach ($messages as $msg) { echo $msg . "\n"; }
// Respond using the context
$conversation = $conversationService->sendMessage("OK", $context);
foreach ($conversation->getTextResponse() as $msg) { echo $msg . "\n"; }

// Getting current conversation intents and entities
$intents = $conversation->getIntents();
var_dump($intents);
$entities = $conversation->getEntities();
var_dump($entities);
```