<?php

return [
    'sidebar' => [
        'adminGroup' => 'Reservations',
        'adminCategories' => 'Categories',
        'adminServices' => 'Services',
        'adminResources' => 'Resources',
        'adminReservations' => 'Reservations',
        'panelUserResource' => 'My Resource',
        'panelReservations' => 'Schedule',
        'panelNewReservation' => 'New Reservation',
        'panelUpdateReservation' => 'Update Reservation',
    ],
    'newCategory' => 'New Category',
    'updateCategory' => 'Update Category',
    'newService' => 'New Service',
    'updateService' => 'Update Service',
    'newResource' => 'New Resource',
    'updateResource' => 'Update Resource',
    'newReservation' => 'New Reservation',
    'updateReservation' => 'Update Reservation',
    'titleStepCategory' => 'What are you looking for?',
    'descriptionStepCategory' => 'Choose the category of your interest',
    'titleStepService' => 'Which service do you want?',
    'descriptionStepService' => 'Choose between all our services',
    'titleStepResource' => 'Do you have a favorite?',
    'descriptionStepResource' => 'Choose the one you prefer the most',
    'titleStepDate' => 'When do you want your reservation?',
    'descriptionStepDate' => 'Choose the date and time',
    'titleStepAvailability' => 'Select your reservation!',
    'descriptionStepAvailability' => 'Select the reservation of your preference',
    'chooseDateReservation' => 'Choose the day for your reservation',
    'chooseTimeReservation' => 'Choose the time for your reservation',
    'myResource' => 'My Resource',
    'meetingPlatform' => 'Meeting platform',
    'registerZoom' => "I don't have a zoom account",
    'termsZoom' => "When you are added to the new Zoom account, ownership of your existing Zoom account (and the information contained therein) will transfer and be assigned to the owner of the new Zoom account. All information and data currently contained in your Zoom account and all information or data saved once you accept the account switch will be viewable and available to the new Zoom account owner and administrators on that account to use and share with others subject to the said account owner's discretion",
    'message' => [
        'meet' => [
            'notFound' => 'Enter your Zoom account (email) to link and create meetings ...',
            'pending' => 'Almost there! Check your email and accept the link for your Zoom account ...',
            'success' => 'Everything is ready! We take care of creating Zoom meetings for you ...',
        ],
    ],
    'helpShareUserResource' => 'You can copy the links of your services and/or your resource to share them in an easier way',
    'documentation' => [
        'categories' => 'It is possible to create categories, with a name, description and organize them in tree mode
     (parent categories and child categories) in order to categorize all your services.',
        'services' => 'These are the services that your users can book within your application, these services include
     a time that can last each turn and a price in addition to all the necessary information to describe it',
        'resources' => 'The resource is in charge of executing a reserved service, each resource can have one or more
     assigned services but can perform only one at a time, in each resource it is possible to configure a schedule of
     availability so that one of your services can be reserved.',
        'reservations' => 'When a user purchases a service it is called a `Reservation` so the application is able to
     identify which service a user reserved next to her resource .',
    ],
];
