<?php

namespace Modules\Ichat\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;
use Modules\Ichat\Repositories\ConversationRepository;
use Modules\Ichat\Repositories\MessageRepository;
use Modules\Media\Entities\File;
use Modules\Notification\Entities\Provider;
use Modules\User\Entities\Sentinel\User;
use Modules\User\Repositories\UserRepository;

class MessageService
{
    private $userEntity;

    private $userRepository;

    private $conversation;

    private $messageRepository;

    private $user;

    public function __construct(
    ConversationRepository $conversation,
    User $userEntity,
    UserRepository $userRepository,
    MessageRepository $messageRepository
  ) {
        $this->userEntity = $userEntity;
        $this->userRepository = $userRepository;
        $this->conversation = $conversation;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Create a message handle the User, conversation and the Provider
     *
     * @return mixed
     */
    public function create($data)
    {
        \DB::beginTransaction();
        try {
            //Instance the response
            $response = ['data' => []];

            /** Get the parameters used from the data */
            $messageText = ($data['message'] ?? $data['body'] ?? $data['template']['name'] ?? null); // Message text
            $sendToProvider = ($data['send_to_provider'] ?? false); // Define if the message should be send to the provider

            /** Validate when it's possible create the message*/
            //Valida for message information
            if (! $messageText && ! isset($data['file']) && ! isset($data['media_id'])) {
                throw new Exception('There is not body, message or file to save as message', 400);
            }
            // Validate if the provider it's valid
            if (($data['provider'] ?? null)) {
                $provider = Provider::where('system_name', $data['provider'])->first();
                if (! $provider || ! $provider->status || ! isset($provider->fields)) {
                    throw new Exception("Provider '{$data['provider']}' not found", 400);
                }
            }

            /* Validate the conversation type private/public */
            // when this parameter is missing, the conversation will become public by default
            if (! isset($data['conversation_private'])) {
                $data['conversation_private'] = 0;
            }

            /* Get the conversation users (keep this process before the conversation process)*/
            $conversationUsers = $this->getConversationUsers($data);
            $data['users'] = $conversationUsers['users'];

            /** Check the Authenticated user. this is needed to save the files below */
            if (! \Auth::id()) {
                \Auth::loginUsingId($conversationUsers['sender']->id);
            }

            /* Get the conversation */
            $conversation = $this->getConversation($data);
            $response['data']['conversation'] = $conversation;

            //Validate if exist a file
            $fileMessage = $this->getMessageFile($data);

            /** create the message */
            $response['data']['message'] = $this->messageRepository->create([
                'conversation_id' => $conversation->id,
                'user_id' => $conversationUsers['sender']->id,
                'body' => $messageText ?? '',
                'attached' => $fileMessage ? $fileMessage->id : null,
                'medias_single' => $fileMessage ? ['attachment' => $fileMessage->id] : [],
                'options' => ['template' => $data['template'] ?? null, 'type' => $data['type'] ?? null],
                'created_at' => $data['created_at'] ?? Carbon::now(),
            ]);

            /** emit the messaga to the provider */
            if ($sendToProvider) {
                $this->emitMessageProvider(
                    $response['data']['message'],
                    $response['data']['conversation'],
                    ($provider ?? null)
                );
            }

            \DB::commit(); //Commit to Data Base

            return $response; //Response
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Return the users for the conversation
     */
    public function getConversationUsers($data)
    {
    // Instance the parameters used form the data
        $recipientId = ($data['recipient_id'] ?? null); //userId who send the message or the id of the contact for a provider
        $conversationId = ($data['conversation_id'] ?? null); // the conversationId for the message
        $provider = ($data['provider'] ?? null); // Provider name for the conversation
        $firstName = ($data['first_name'] ?? null); // Optional, when should create a new user set the firstName
        $lastName = ($data['last_name'] ?? null); // Optional, when should create a new user set the lastName
        $senderId = ($data['sender_id'] ?? null); // Id user who send the message. when it's for a provider and this is missing will be filled with the user provider (recipient)

        //Instance the response
        $response = ['users' => []];

        /**  Validate the required paramters*/
        //Validate the recipient_id this is required for any case
        if (! $recipientId && ! $conversationId) {
            throw new Exception('recipient_id is required', 400);
        }

        /** Handle the recipient user */
        // Get the recipient user data
        // if: the conversation it's for a provider and the recipient not found then it will be created
        // else: just find by id the recipient id
        if ($provider) {
            //Instance de user email for provider
            $email = "{$recipientId}@{$provider}.com";
            //Search the user by email
            $response['recipient'] = $this->userEntity->where('email', $email)->first();
            //Create the user if not exist
            if (! $response['recipient']) {
                //Instance the user data
                $userData = [
                    'email' => $email,
                    'first_name' => $firstName ?? $recipientId,
                    'last_name' => $lastName ?? $provider,
                    'password' => generatePassword(),
                ];
                //Create user
                $response['recipient'] = $this->userRepository->createWithRoles($userData, [], true);
            }
        } else {
            $response['recipient'] = $this->userRepository->find($recipientId);
        }

        /** Handle the sender user */
        // if: exist the senderId search it by id
        // else: only if there is provider the sender will filled with the recipient user
        if ($senderId) {
            $response['sender'] = $this->userRepository->find($senderId);
        } elseif ($provider) {
            $response['sender'] = $response['recipient'];
        } elseif (! ($response['recipient'] ?? null)) {
            throw new Exception('recipient_id is required or not found', 400);
        }
        //Validate if the sender was found
        if (! ($response['sender'] ?? null)) {
            throw new Exception("sender_id is required or wasn't found", 400);
        }

        /** Merge the users id */
        if (($response['recipient'] ?? null)) {
            $response['users'][] = $response['recipient']->id;
        }
        if (($response['sender'] ?? null)) {
            $response['users'][] = $response['sender']->id;
        }

        //Return response
        return array_merge($response, ['users' => array_unique($response['users'])]);
    }

    /**
     * Return the conversation
     *
     * @return null
     */
    public function getConversation($data)
    {
    // Instance the parameters used form the data
        $conversationId = ($data['conversation_id'] ?? null); // the conversationId for the message
        $provider = ($data['provider'] ?? null); // Provider name for the conversation
        $recipientId = ($data['recipient_id'] ?? null); // for provider, it's the contact id if it
        $conversationPrivate = (int) ($data['conversation_private'] ?? 1); // Define the conversation type private/public
        $conversationUsers = $data['users']; // users for the conversation

        /** Validate the parameters */
        if (! $conversationId && ! $provider) {
            throw new Exception(
                "conversation_id is required. when the message it's for a provider this parameter will be optional",
                400
            );
        }

        /** Search de conversation */
        // if: the conversation id exist then search it by id
        // else: validate if provider exist and search by entity using the rectType. if not found then will be created
        if ($conversationId) {
            $conversation = $this->conversation->find($data['conversation_id']);
        } elseif ($provider) {
            //Search by entity
            $conversation = $this->conversation->where('entity_type', $provider)
              ->where('entity_id', $recipientId)->first();
            //Create the conversation for provider
            if (! $conversation) {
                $conversation = $this->conversation->create([
                    'private' => $conversationPrivate,
                    'entity_type' => $provider,
                    'entity_id' => $recipientId,
                    'users' => $conversationUsers,
                ]);
            }
        }

        /** Validate the parameters */
        if (! $conversation) {
            throw new Exception("Conversation Id {$conversationId} not found", 400);
        }

        //Return the conversation
        return $conversation ?? null;
    }

    /**
     * Insert file if exist and return the file entity
     *
     * @return null
     */
    private function getMessageFile($data)
    {
    // Instance the parameters used form the data
        $file = ($data['file'] ?? null); // Message file
        $mediaId = ($data['media_id'] ?? null); // Message file form media by id
        $fileContext = ($data['file_context'] ?? []); // Message file context
    //Instance the response
        $response = null;
        if ($mediaId) {
            $response = File::find($mediaId);
        } elseif ($file) {
            //Instance file service
            $fileService = app("Modules\Media\Services\FileService");
            //Get base64 file
            $uploadedFile = getUploadedFileFromUrl($file, $fileContext);
            //Create file
            $response = $fileService->store($uploadedFile, 0, 'privatemedia');
        }
        //Response
        return $response;
    }

    /** Emit message for providers*/
    public function emitMessageProvider($message, $conversation, $provider)
    {
        //Search if conversation is of the provider
        $provider = $provider ?? Provider::where('system_name', $conversation->entity_type ?? 'null')->first();
        //Emit message
        if ($provider) {
            //Instance de inotification service
            $notification = app("Modules\Notification\Services\Inotification");
            //Instance the message type
            $messageType = 'text';
            //Get message attachment
            if ($message->attached) {
                $file = $message->files()->where('zone', 'attachment')->first();
                if ($file) {
                    $fileToken = $file->generateToken(null, 2);
                    //Send url to get file
                    $messagaAttachment = \URL::route('public.media.media.show', [
                        'criteria' => $file->id,
                        'token' => $fileToken->token,
                    ]);
                    //Default file type
                    $messageType = 'document';
                    //Validate extension
                    if ($file->isImage()) {
                        $messageType = 'image';
                    }
                    if (in_array($file->extension, json_decode(setting('media::allowedAudioTypes')))) {
                        $messageType = 'audio';
                    }
                    if (in_array($file->extension, json_decode(setting('media::allowedVideoTypes')))) {
                        $messageType = 'video';
                    }
                }
            }
            //Handle template options
            if (($message->options['template'] ?? null)) {
                //Change the message type
                $messageType = 'template';
                //Instance the message template
                $messageTemplate = $message->options['template'];
            }

            //type from $data
            isset($message->options['type']) ? $messageType = $message->options['type'] : '';

            //Send notification
            $notification->provider($provider->system_name)
              ->to($message->conversation->entity_id)
              ->push([
                  'type' => $messageType,
                  'message' => $message->body,
                  'file' => $messagaAttachment ?? null,
                  'template' => $messageTemplate ?? null,
              ]);
        }
    }
}
