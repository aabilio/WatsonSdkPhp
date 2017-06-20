# IBM Watson Services PHP SDK

PHP SDK for IBM Watson services

**Note: This project is at an early stage of development and should not be used for production.**


### Fully developed services

 * 
 
### Services in development

 * Watson Conversation Service


## Using Conversation Service Version 1

```php
<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use WatsonSdkPhp\Sdk\Services\Conversation\V1\WatsonConversationService;

// Using the Conversation Service directly
$conversationService = new WatsonConversationService("<username>", "<password>", "<workspace_id>");
$response = $conversationService->sendMessage("Hi!");
foreach ($response["output"]["text"] as $msg) { echo $msg . "\n"; }
$conversationService->sendMessage("OK", $response["context"]);

// Using the WatsonConversation to auto manage the context
$conversation = $conversationService->createConversation();
$conversation->say("hi!");
foreach ($conversation->getTextResponse() as $msg) { echo $msg . "\n"; }
$conversation->say("OK");

// Getting current conversation context, intents and entities
$context = $conversation->getContext();
$intents = $conversation->getIntents();
$entities = $conversation->getEntities();
```