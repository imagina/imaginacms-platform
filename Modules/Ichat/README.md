# Asgardcms-ichat

## Installation

The page module is installed by default on an AsgardCms installation. If you want to install it on standalone you can
follow the steps.

### Composer requirement

``` json
composer require imagina/ichat-module
```

### Package migrations

Run the migrations:

``` bash
php artisan module:migrate Ichat
```

### Configuration

.env data pusher

### MessageService

- Usage:  `use Modules\Ichat\Services\MessageService;`
- Methods:
    - `create($data)` Allow to you create a message in the chat
  #### `$data` (Array) Parameter with the necessary data to create a message

| Property             | Type         | Description Message                                                                                                | 
|----------------------|--------------|--------------------------------------------------------------------------------------------------------------------|
| message/body         | string       | `Required` String with the message - `optional` if pass `file` or `media_id`                                       |
| conversation_id      | int/string   | `Optional` ConversationID where the message will be related                                                        |
| conversation_private | int (0/1)    | `Optional` Define if the conversation will be private by default it's 1                                            |
| sender_id            | int/string   | `Required` UserId who is creating the message                                                                      |
| file                 | url          | `Optional` File URL of the message. the service will get and store the file to attach to the message               |
| file_context         | array        | `Optional` parameters for copy the file refer to  https://www.php.net/manual/es/function.stream-context-create.php |
| media_id             | int          | `Optional` file ID from media to be attached to the message                                                        |

#### `$data` (Array) Parameter with the necessary data to create a message for a Provider

| Property             | Type       | Description Message                                                                                                                         | 
|----------------------|------------|---------------------------------------------------------------------------------------------------------------------------------------------|
| provider             | string     | `Require` system_name of provider from Notification module                                                                                  |
| message/body         | string     | `Required` String with the message - `optional` if pass `file`, `media_id` or `template`                                                    |
| recipient_id         | int/string | `Required` contactId of the provider                                                                                                        |
| sender_id            | int/string | `Required` UserId who is creating the message                                                                                               |
| send_to_provider     | boolean    | `optional` define if the message should by send to the provider                                                                             |
| conversation_private | int (0/1)  | `Optional` Define if the conversation will be private by default it's 1                                                                     |
| file                 | url        | `Optional` File URL of the message. the service will get and store the file to attach to the message                                        |
| file_context         | array      | `Optional` parameters for copy the file refer to  https://www.php.net/manual/es/function.stream-context-create.php                          |
| template             | apiParams  | `Optional` parameters of template provider refer to  https://developers.facebook.com/docs/whatsapp/cloud-api/guides/send-message-templates  |
| media_id             | int        | `Optional` file ID from media to be attached to the message                                                                                 |
| first_name           | string     | `Optional` The user name if is necessary create it                                                                                          |
| last_name            | string     | `Optional` The user last name if is necessary create it                                                                                     |
