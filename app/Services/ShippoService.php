<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ShippoService
{
    protected $client;
    protected $apiKey;
    public function __construct()
    {
        $this->apiKey = env('SHIPPO_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://api.goshippo.com/',
            'timeout'  => 30,
        ]);
    }

    /**
     * Set the Shippo API key.
     *
     * @param string $apiKey
     * @return void
     */
    public function setApiKey(string $apiKey): void
    {
        \Shippo::setApiKey($apiKey);
    }

    /**
     * Create an address.
     *
     * @param array $addressData
     * @return object
     */
    public function createAddress(array $addressData): object
    {
        return \Shippo_Address::create($addressData);
    }

    /**
     * Retrieve an address by its object ID.
     *
     * @param string $addressId
     * @return object
     */
    public function retrieveAddress(string $addressId): object
    {
        return \Shippo_Address::retrieve($addressId);
    }

    /**
     * Validate an address using its ID.
     *
     * @param string $addressId
     * @return object
     */
    public function validateAddress(string $addressId): object
    {
        return \Shippo_Address::validate($addressId);
    }

    /**
     * Create a parcel.
     *
     * @param array $parcelData
     * @return object
     */
    public function createParcel(array $parcelData): object
    {
        return \Shippo_Parcel::create($parcelData);
    }

    /**
     * Retrieve a parcel by its object ID.
     *
     * @param string $parcelId
     * @return object
     */
    public function retrieveParcel(string $parcelId): object
    {
        return \Shippo_Parcel::retrieve($parcelId);
    }

    /**
     * Create a shipment.
     *
     * @param array $shipmentData
     * @param array $lineItems
     * @return object
     */
    public function createShipment(array $shipmentData, array $lineItems): object
    {
        if (
            isset($shipmentData['address_to']['country']) &&
            strtoupper($shipmentData['address_to']['country']) !== 'US'
        ) {
            $customsItems = array_map(function ($item) {
                $qty = max(1, (int) ($item['quantity'] ?? 1));
                $unitWeight = max(0.1, (float) ($item['weight'] ?? 0.1));

                return [
                    'description'    => $item['description'] ?? 'Product',
                    'quantity'       => $qty,
                    'net_weight'     => $unitWeight,
                    'mass_unit'      => 'oz',
                    'value_amount'   => $item['value'] ?? 10,
                    'value_currency' => 'USD',
                    'origin_country' => 'US',
                ];
            }, $lineItems);

            $totalCustomsWeight = array_reduce($customsItems, function ($carry, $item) {
                return $carry + ($item['net_weight'] * $item['quantity']);
            }, 0);

            $parcelWeight = max($shipmentData['parcels'][0]['weight'] ?? 1.0, $totalCustomsWeight, 1.0);

            $shipmentData['parcels'] = [[
                'weight'        => $parcelWeight,
                'mass_unit'     => 'oz',
                'length'        => 10,
                'width'         => 10,
                'height'        => 10,
                'distance_unit' => 'in',
            ]];

            $customsDeclarationData = [
                'contents_type'       => 'MERCHANDISE',
                'non_delivery_option' => 'RETURN',
                'certify'             => true,
                'certify_signer'      => 'Encore Custom',
                'items'               => $customsItems,
            ];

            $customsDeclaration = $this->createCustomsDeclaration($customsDeclarationData);
            $shipmentData['customs_declaration'] = $customsDeclaration['object_id'];
        }

        // Ensure carrier accounts exist
        $shipmentData['carrier_accounts'] = $shipmentData['carrier_accounts'] ?? [env('CAREER_ACC_ID')];

        // Create shipment
        return \Shippo_Shipment::create($shipmentData);
    }


    /**
     * Create a customs declaration (required for international shipments).
     *
     * @param array $declarationData
     * @return object
     */
    public function createCustomsDeclaration(array $declarationData): object
    {
        // Create and return the customs declaration
        return \Shippo_CustomsDeclaration::create($declarationData);
    }

    /**
     * Create a shipment (domestic only).
     *
     * @param array $shipmentData
     * @param array $lineItems (optional, unused here but kept for consistency or future use)
     * @return object
     */
    public function getShippingFee(array $shipmentData, array $lineItems = []): object
    {
        // Create and return the shipment
        return \Shippo_Shipment::create($shipmentData);
    }

    /**
     * Retrieve a shipment by its object ID.
     *
     * @param string $shipmentId
     * @return object
     */
    public function retrieveShipment(string $shipmentId): object
    {
        return \Shippo_Shipment::retrieve($shipmentId);
    }

    /**
     * Purchase a shipping label for a shipment.
     *
     * @param string $rateId
     * @return object
     */
    public function purchaseLabel(array $transactionData): object
    {
        return \Shippo_Transaction::create($transactionData);
    }

    /**
     * Retrieve a transaction (label purchase) by its object ID.
     *
     * @param string $transactionId
     * @return object
     */
    public function retrieveTransaction(string $transactionId): object
    {
        return \Shippo_Transaction::retrieve($transactionId);
    }

    /**
     * Track a shipment.
     *
     * @param string $carrier
     * @param string $trackingNumber
     * @return object
     */
    public function trackShipment(string $carrier, string $trackingNumber): object
    {
        return \Shippo_Track::get_status($carrier, $trackingNumber);
    }

    /**
     * Get details of a carrier account.
     *
     * @param string $carrierAccountId
     * @return object
     * @throws \Exception
     */
    public function getCarrierAccountDetails(string $carrierAccountId): object
    {
        try {
            // Use Shippo's CarrierAccount class to retrieve account details
            $carrierAccount = \Shippo_CarrierAccount::retrieve($carrierAccountId);

            return $carrierAccount;
        } catch (\Exception $e) {
            // Log and rethrow the exception for debugging
            \Log::error('Error retrieving carrier account details: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createOrder(array $orderData): array
    {
        try {
            $shippoOrder = \Shippo_Order::create($orderData);

            return [
                'status' => 'success',
                'shippo_order' => $shippoOrder
            ];
        } catch (\Exception $e) {
            \Log::error('Shippo Order Creation Failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get shipping rates without purchasing a label.
     *
     * @param array $shipmentData
     * @return array
     */
    public function retrieveShippingFee(array $shipmentData): array
    {
        try {
            // Create a shipment object to retrieve rates, but DO NOT buy a label
            $shipment = \Shippo_Shipment::create([
                "address_from" => $shipmentData['address_from'],
                "address_to" => $shipmentData['address_to'],
                "parcels" => $shipmentData['parcels'],
                "carrier_accounts" => $shipmentData['carrier_accounts'], // Carrier accounts as an array of strings (IDs)
                "async" => false,
                "test" => $shipmentData['test']
            ]);

            dd($shipment);

            // Extract rates from the shipment response
            $rates = $shipment["rates"] ?? [];

            return ['status' => 'success', 'rates' => $rates];

        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Retrieve order details from Shippo API.
     *
     * @param string $shippoOrderId
     * @return object
     * @throws Exception
     */
    public function orderDetail(string $shippoOrderId): object
    {
        try {
            return \Shippo_Order::retrieve($shippoOrderId);
        } catch (Exception $e) {
            \Log::error('Error retrieving order details: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Fetch packing slip URL from Shippo via HTTP request.
     */
    public function getPackingSlipUrl(string $shippoOrderId): ?string
    {
            $response = $this->client->get("orders/{$shippoOrderId}/packingslip/", [
                'headers' => [
                    'Authorization' => 'ShippoToken ' . $this->apiKey,
                    'Accept'        => 'application/json',
                ],
            ]);

            $payload = json_decode($response->getBody()->getContents(), true);
            return $payload['slip_url'] ?? null;
    }





}
