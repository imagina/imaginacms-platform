<?php

namespace Modules\Notification\Services;

use Modules\Notification\Entities\Provider;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Modules\Notification\Emails\NotificationMailable;
use Modules\Notification\Events\BroadcastNotification;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Repositories\ProviderRepository;
use Modules\User\Contracts\Authentication;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Validator;

final class ImaginaNotification implements Inotification
{
  /**
   * @var NotificationRepository
   */
  private $notificationRepository;
  
  /**
   * @var Notification Entity
   */
  private $notification;
  
  private $auth;
  
  /**
   * @var string
   */
  private $recipient;
  
  /**
   * @var string
   */
  private $type;
  
  /**
   * @var string|Provider[object]
   */
  private $provider;
  /**
   * @var array
   */
  private $providerConfig;
  
  /**
   * @var ProviderRepository
   */
  private $providerRepository;
  
  /**
   * @var savedInDatabase
   * Boolean
   */
  private $savedInDatabase;
  
  /**
   * @var Entity
   */
  private $entity;
  /**
   * @var Setting
   */
  private $setting;
  /**
   * @var array
   */
  private $data;
  
  public function __construct(
    NotificationRepository $notificationRepository,
    ProviderRepository $providerRepository,
    Authentication $auth)
  {
    $this->notificationRepository = $notificationRepository;
    $this->providerRepository = $providerRepository;
    $this->auth = $auth;
  }
  
  /**
   * Push a notification on the dashboard
   * @param string $title
   * @param string $message
   * @param string $icon
   * @param string|null $link
   */
  public function push($params = [])
  {
    $this->entity = $params["entity"] ?? null;
    $this->setting = $params["setting"] ?? null;
    $this->data = $params["data"] ?? $params ?? null;
    
    // if provider its not defined
    if (!isset($this->provider->id)) {
      
      // if the type of notification it's defined
      if ($this->type) {
        
        // the type of notification may be an array of strings for multiples notifications
        if (!is_array($this->type)) $this->type = [$this->type];
        
        foreach ($this->type as $type) {
          $this->provider = $this->providerRepository->getItem($type, (object)["include" => [], "filter" => (object)["field" => "type", "default" => 1]]);
          
          if (isset($this->provider->id) && $this->provider->status) {
            $this->send();
          }
        }
      } else {
        // if the provider and type is not defined, the $recipient can defined the type for notification
        // like ["push" => $user->id,"email" => $user->email]
        if (is_array($this->recipient)) {
          $typeRecipients = $this->recipient;
          
          foreach ($typeRecipients as $type => $recipients) {
            $this->type = $type;
            $this->provider = $this->providerRepository->getItem($type, (object)["include" => [], "filter" => (object)["field" => "type", "default" => 1]]);
            
            if (isset($this->provider->id) && $this->provider->status) {
              
              if (!is_array($recipients)) $recipients = [$recipients];
              
              foreach ($recipients as $recipient) {
                $this->recipient = $recipient;
                $this->send();
              }
              
            }
          }
        }
      }
    } else {
      if ($this->provider->status) {
        $this->send();
      }
    }
  }
  
  /**
   * Set a user id to set the notification to
   * @param int $recipient
   * @return $this
   */
  public function to($recipient)
  {
    $this->recipient = $recipient;
    
    return $this;
  }
  
  public function provider($provider)
  {
    if (is_string($provider))
      $this->provider = $this->providerRepository->getItem($provider, (object)["include" => [], "filter" => (object)["field" => "system_name", "default" => 1]]);
    else
      $this->provider = $provider;
    
    return $this;
  }
  
  public function type($type)
  {
    $this->type = $type;
    
    return $this;
  }
  
  /**
   * validating recipient with laravel request rules
   * @param $recipient
   * @param $providerConfig
   * @return bool
   */
  private function validateRecipient($recipient)
  {
    
    $providersConfig = collect(config("asgard.notification.config.providers"));
    $providersConfig = $providersConfig->keyBy("systemName");
    $this->providerConfig = $providersConfig[$this->provider->system_name];
    
    $valid = true;
    if (isset($this->providerConfig["rules"])) {
      $result = Validator::make(["recipient" => $recipient], ["recipient" => $this->providerConfig["rules"]]);
      if ($result->fails()) {
        $valid = false;
      }
    }
    return $valid;
  }
  
  private function send()
  {
    
    //validating $recipient with rules defined in the config of the provider
    $valid = $this->validateRecipient($this->recipient);
    
    if ($valid) {
      //configuring global laravel config with data in database
      $this->loadConfigFromDatabase();
      
      $this->savedInDatabase = false;
      //if provider is configured for save in database
      if (isset($this->provider->fields->saveInDatabase) && $this->provider->fields->saveInDatabase)
        //if setting is configured for save in database
        if (isset($this->setting->saveInDatabase) && $this->setting->saveInDatabase) {
          $this->create();
          $this->savedInDatabase = true;
        }
      
      
      if (method_exists($this, $this->provider->system_name)) {
        \Log::info("[Notification/send] notification to: {$this->recipient}, provider: {$this->provider->system_name}, saveInDatabase: " . ($this->savedInDatabase ? 'YES' : 'NO'));
        
        $this->{$this->provider->system_name}();
      }
    }
    
  }
  
  private function create()
  {
    $this->notification = $this->notificationRepository->create([
      'recipient' => $this->recipient ?? $this->auth->id(),
      'icon_class' => $this->data["icon"] ?? '',
      'type' => $this->provider->type ?? $this->type ?? '',
      'provider' => $this->provider->system_name ?? '',
      'link' => $this->data["link"] ?? url(''),
      'title' => $this->data["title"] ?? '',
      'message' => $this->data["message"] ?? ''
    ]);
    
  }
  
  private function loadConfigFromDatabase()
  {
    

    foreach ($this->providerConfig["fields"] as $field) {
      if (isset($field["configRoute"])) {
        config([$field["configRoute"] => $this->provider->fields->{$field["name"]}]);
      }
    }
  }
  
  private function pusher()
  {
    
    if ($this->savedInDatabase) {
      \Log::info('Notification pusher to notification.new.' . $this->recipient);
      broadcast(new BroadcastNotification($this->notification))->toOthers();
    } else {
      \Log::info("[Notification/pusher] Can't send the notification  to: {$this->recipient}, because it's not being saved in DB ");
    }
    
  }
  
  private function email()
  {
    
    // subject like notification title
    $subject = $this->data["title"] ?? '';
    
    //default notification view
    $defaultView = config("asgard.notification.config.defaultEmailView");
    
    //validating view from event data
    $view = $this->data["view"] ?? $defaultView;
    
    //Maiable
    $mailable = new NotificationMailable($this->data,
      $subject, (view()->exists($view) ? $view : $defaultView),
      $this->data["fromAddress"] ?? $this->provider->fields->fromAddress ?? null,
      $this->data["fromName"] ?? $this->provider->fields->fromName ?? null);
    
    \Log::info('Sending Email to ' . $this->recipient);
    Mail::to($this->recipient)->send($mailable);
  }
  
  private function firebase()
  {
    try {
      \Log::info('Notification firebase to topic: ' . ' notification.new.' . $this->recipient);
      fcm()->toTopic('notification.new.' . $this->recipient)// $topic must an string (topic name)
      ->priority('normal')
        ->timeToLive(0)
        ->data([
          'body' => $this->data["message"] ?? '',
        ])
        ->notification([
          'title' => $this->data["title"] ?? '',
          'body' => $this->data["message"] ?? '',
          'link' => $this->data["link"] ?? null,
          'image' => setting('isite::logo1')
        ])
        ->send();
    } catch (\Exception $e) {
      \Log::error($e);
    }
  }
  
  private function twilio()
  {
    \Log::info("Notification twilio to: " . $this->recipient);
    
    $account_sid = env("TWILIO_SID");
    $auth_token = env("TWILIO_AUTH_TOKEN");
    $twilio_number = env("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($this->recipient,
      ['from' => $twilio_number, 'body' => $this->data["message"] ?? '']);
    
  }
  
  
  private function labsMobile()
  {
    \Log::info("Notification labsMobile to: " . $this->recipient);
  
    $recipient = $this->recipient;
    //Service Providers Example
    \SMS::send(($this->data["title"] ?? '')." ".($this->data["message"] ?? '')." ".($this->data["link"] ?? ''), null, function($sms) use ($recipient) {
      $sms->to($recipient);
    });
  
  
  }

}
