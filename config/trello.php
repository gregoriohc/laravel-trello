<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trello API KEY
    |--------------------------------------------------------------------------
    |
    | Your trello API key. You can get it from https://trello.com/app-key
    |
    */

    'api_key' => env('TRELLO_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Trello API token
    |--------------------------------------------------------------------------
    |
    | Your trello user API token.
    |
    | You can generate a new never expiring token on this url:
    | https://trello.com/1/authorize?response_type=token&key=API_KEY&return_url=https%3A%2F%2Fexample.com&callback_method=&scope=read%2Cwrite%2Caccount&expiration=never&name=MY_APP
    | replacing API_KEY with your trello API key and MY_APP with yor app name.
    | After authorizing, it will redirect you to an example.com page. You just
    | need to grab the access token from the url.
    |
    */

    'api_token' => env('TRELLO_API_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Trello default organization name
    |--------------------------------------------------------------------------
    |
    | You can set up here your default organization name to use it in your API
    | calls. If left blank, it will reference the user's own boards organization.
    |
    | To retrieve its ID, call Trello::getDefaultOrganizationId() method
    |
    */

    'organization' => env('TRELLO_ORGANIZATION', ''),

    /*
    |--------------------------------------------------------------------------
    | Trello default board name
    |--------------------------------------------------------------------------
    |
    | You can set up here your default board name to use it in your API
    | calls. This board must exists in the previously configured default organization.
    |
    | To retrieve its ID, call Trello::getDefaultBoardId() method
    |
    */

    'board' => env('TRELLO_BOARD', 'Main'),

    /*
    |--------------------------------------------------------------------------
    | Trello default list name
    |--------------------------------------------------------------------------
    |
    | You can set up here your default list name to use it in your API
    | calls. This list must exists in the previously configured default board.
    |
    | To retrieve its ID, call Trello::getDefaultListId() method
    |
    */

    'list' => env('TRELLO_LIST', 'Today'),
];
