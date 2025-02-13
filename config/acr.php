<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Azure Communication Services Email Configuration
    |--------------------------------------------------------------------------
    |
    | endpoint: The base URL of your Azure Communication Service resource.
    | access_key: The access key or token provided by Azure for authentication.
    | sender: The default sender email address.
    | api_version: The API version to use (if required by Azure).
    |
    */

    'endpoint' => env('AZURE_COMMUNICATION_ENDPOINT', 'https://your-resource.communication.azure.com'),
    'access_key' => env('AZURE_COMMUNICATION_ACCESS_KEY', 'your-access-key'),
    'sender' => env('AZURE_COMMUNICATION_SENDER', 'sender@example.com'),
    'api_version' => env('AZURE_COMMUNICATION_API_VERSION', '2023-01-15'),
];
