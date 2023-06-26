<?php

namespace Modules\Ibooking\Services;

//Events
use Modules\Ibooking\Events\ReservationWasCreated;

class ReservationService
{
    /**
     * @return cart service created
     */
    public function createCheckoutCart($data, $reservation = null): cart
    {
        $cartService = app("Modules\Icommerce\Services\CartService");
        $products = [];
        $items = $data['items'];

        // Add Reservation Item for ItemS
        foreach ($items as $item) {
            $reservationItemData = $this->createReservationItemData($item, $data);

            // Set Products to Cart
            $products[] = [
                'id' => $reservationItemData['service']->product->id, // OJO - getProductAttribute - Version que ya estaba
                'quantity' => 1,
                'options' => ['reservationId' => $reservation->id, 'reservationItemData' => $reservationItemData['reservationItem']],
            ];

            //\Log::info("Ibooking: Services|CheckoutService|Create: ".json_encode($products));
        }

        // Create the Cart
        $cart = $cartService->create(['products' => $products]);

        return $cartService;
    }

    /**
     * @return reservation
     */
    public function createReservation($data): reservation
    {
        // Get Customer Id if exist
        if (isset($data['customer_id'])) {
            $reservationData = ['customer_id' => $data['customer_id'], 'items' => []];
        }

        // If no exist is 0 (Pending)
        $reservationData['status'] = (int) setting('ibooking::reservationStatusDefault', null, 0);

        //\Log::info("Ibooking: Services|ReservationService|Create|reservationData ".json_encode($reservationData));
        $reservationRepository = app('Modules\Ibooking\Repositories\ReservationRepository');

        // Create Reservation and ReservationItem
        $reservation = $reservationRepository->create($reservationData);

        $reservationItemRepository = app('Modules\Ibooking\Repositories\ReservationItemRepository');
        // Add Reservation Item for ItemS
        foreach ($data['items'] as $item) {
            $reservationItemData = $this->createReservationItemData($item, $reservationData);
            $reservationItemData['reservationItem']['reservation_id'] = $reservation->id;
            $reservationItemRepository->create($reservationItemData['reservationItem']);
        }

        //Include items relation if entity
        $reservation->items;

        // Send Email and Notification Iadmin
        event(new ReservationWasCreated($reservation));

        return $reservation;
    }

    /**
     * Get data from each item and create one array with the information
     *
     * @return array - [service,reservationItem]
     */
    public function createReservationItemData($item, $reservationData): array
    {
        $reservationItem = [];
        $response = [];

        if (isset($item['service_id'])) {
            $service = app("Modules\Ibooking\Repositories\ServiceRepository")->find($item['service_id']);
            $reservationItem['service_id'] = $service->id;
            $reservationItem['service_title'] = $service->title;
            $reservationItem['price'] = $service->price;

            // Added service
            $response['service'] = $service;
        }

        if (isset($item['resource_id'])) {
            $resource = app("Modules\Ibooking\Repositories\ResourceRepository")->find($item['resource_id']);
            $reservationItem['resource_id'] = $resource->id;
            $reservationItem['resource_title'] = $resource->title;
            $reservationItem['organization_id'] = $resource->organization_id ?? null;

            //OJO CAMBIO A REVISAR
            $reservationItem['entity_type'] = "Modules\Ibooking\Entities\Resource";
            $reservationItem['entity_id'] = $resource->id;
        }

        if (isset($item['category_id'])) {
            $category = app("Modules\Ibooking\Repositories\CategoryRepository")->find($item['category_id']);
            $reservationItem['category_id'] = $category->id;
            $reservationItem['category_title'] = $category->title;
        }

        if (isset($item['start_date'])) {
            $reservationItem['start_date'] = $item['start_date'];
        }

        if (isset($item['end_date'])) {
            $reservationItem['end_date'] = $item['end_date'];
        }

        /*
        * OJO: Esto hay que revisarlo mejor xq la idea era que la Reservacion
        * agrupara todo, pero a nivel de frontend se dificulta
        */
        if (isset($reservationData['customer_id'])) {
            $reservationItem['customer_id'] = $reservationData['customer_id'];
        }

        if (isset($reservationData['status'])) {
            $reservationItem['status'] = $reservationData['status'];
        }

        // Save reservation item data
        // TODO: Revisar por que no estaba dejando todos los datos del item
        $response['reservationItem'] = array_merge($item, $reservationItem);

        return $response;
    }
}
