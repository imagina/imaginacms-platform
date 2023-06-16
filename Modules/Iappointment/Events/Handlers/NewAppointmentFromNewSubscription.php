<?php

namespace Modules\Iappointment\Events\Handlers;

class NewAppointmentFromNewSubscription
{
    private $appointmentService;

    private $notificationService;

    private $userRepository;

    public function __construct()
    {
        $this->appointmentService = app('Modules\Iappointment\Services\AppointmentService');
        $this->notificationService = app("Modules\Notification\Services\Inotification");
        $this->userRepository = app('Modules\Iprofile\Repositories\UserApiRepository');
    }

    public function handle($event)
    {
        try {
            $userDriver = config('asgard.user.config.driver');

            $subscription = $event->model;

            if (isset($subscription->options) && isset($subscription->options->appointmentCategoryId)) {
                \Log::info('Appointment category: '.$subscription->options->appointmentCategoryId);

                if ($subscription->entity === "Modules\\User\\Entities\\{$userDriver}\\User") {
                    $this->appointmentService->assign($subscription->options->appointmentCategoryId, $subscription);
                }
            } else {
                if ($subscription->entity === "Modules\\User\\Entities\\{$userDriver}\\User") {
                    $customerUser = $this->userRepository->getItem($subscription->entity_id, json_decode(json_encode(['include' => [], 'filter' => []])));
                    $this->notificationService->to([
                        'email' => $customerUser->email,
                        'broadcast' => [$customerUser->id],
                        'push' => [$customerUser->id],
                    ])->push(
                        [
                            'title' => trans('iappointment::appointments.messages.newAppointmentSubscription'),
                            'message' => trans('iappointment::appointments.messages.newAppointmentSubscriptionContent', ['name' => $customerUser->present()->fullName]),
                            'icon_class' => 'fas fa-list-alt',
                            'buttonText' => trans('iappointment::appointments.button.take'),
                            'withButton' => true,
                            'link' => url(trans('iappointment::routes.appointmentCategory.index')),
                            'setting' => [
                                'saveInDatabase' => 1, // now, the notifications with type broadcast need to be save in database to really send the notification
                            ],
                            'options' => [
                                'isImportant' => true,
                                'action' => [
                                    [
                                        'toVueRoute' => [
                                            'name' => 'qappointment.panel.appointments.index',
                                        ],
                                    ],
                                ],
                            ],
                        ]
                    );
                }
            }
        } catch(\Exception $e) {
            \Log::info($e->getMessage().' - '.$e->getFile().' - '.$e->getLine());
        }
    }
}
