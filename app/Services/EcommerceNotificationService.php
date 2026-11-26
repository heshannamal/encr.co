<?php

namespace App\Services;

use App\Models\InventoryAddedOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcommerceNotificationService
{
    /**
     * Notify the Encorecustom_ecomerce system when an inventory order is sent to inventory.
     *
     * This call is intentionally non-blocking/fail-safe: any configuration or HTTP error
     * is logged and returns false without interrupting the Encore-Cloud workflow.
     */
    public function notifyInventoryOrderSent(Order $order, InventoryAddedOrder $inventory, $sentByUser = null): bool
    {
        $baseUrl  = rtrim((string) config('services.ecommerce.api_url'), '/');
        $apiKey   = (string) config('services.ecommerce.api_key', 'admin_data_api');
        $apiToken = (string) config('services.ecommerce.api_token');
        $timeout  = (int) config('services.ecommerce.timeout', 5);

        if ($baseUrl === '' || $apiKey === '' || $apiToken === '') {
            Log::warning('EcommerceNotificationService skipped: ECOM_API_URL, ECOM_API_KEY, or ECOM_API_TOKEN is not configured.', [
                'order_id' => $order->id,
            ]);
            return false;
        }

        $endpoint = $baseUrl . '/api/v1/notifications/inventory-order-sent';

        $itemsCount = isset($order->order_items_count)
            ? (int) $order->order_items_count
            : $order->orderItems()->count();

        $organizationName = $order->organizationDetails->organization_name ?? null;

        $payload = [
            'ec_order_id'       => (int) $order->id,
            'order_no'          => (string) ($order->order_no ?? $order->id),
            'inventory_type_id' => $inventory->inventory_type_id ? (int) $inventory->inventory_type_id : null,
            'sent_by_id'        => $sentByUser ? (int) $sentByUser->id : ($inventory->sent_by ? (int) $inventory->sent_by : null),
            'sent_by_name'      => $sentByUser ? (string) ($sentByUser->name ?? 'Encore Cloud Staff') : 'Encore Cloud Staff',
            'items_count'       => $itemsCount,
            'organization_name' => $organizationName,
        ];

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withHeaders([
                    'API-Key'   => $apiKey,
                    'API-Token' => $apiToken,
                ])
                ->withOptions(['connect_timeout' => min($timeout, 5)])
                ->timeout($timeout)
                ->post($endpoint, $payload);

            if (!$response->successful()) {
                Log::warning('EcommerceNotificationService received non-2xx response.', [
                    'order_id' => $order->id,
                    'endpoint' => $endpoint,
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('EcommerceNotificationService request failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'endpoint' => $endpoint,
            ]);
            return false;
        }
    }
}
