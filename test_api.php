<?php

/**
 * API Test Script for Order Details API
 *
 * This script demonstrates how to test the Order Details API endpoints.
 * Make sure to replace the placeholder values with actual data.
 */

// Configuration
$baseUrl = 'http://localhost/api'; // Replace with your actual domain
$authorityToken = 'YOUR_AUTHORITY_TOKEN_HERE'; // Replace with actual authority token

// Test data
$testOrderId = 1; // Replace with actual order ID

echo "=== Order Details API Test ===\n\n";

// Test 1: Health Check
echo "1. Testing Health Check Endpoint...\n";
$healthResponse = makeRequest('GET', $baseUrl . '/health');
echo "Status: " . $healthResponse['status'] . "\n";
echo "Response: " . json_encode($healthResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

// Test 2: Get Order Details
echo "2. Testing Get Order Details Endpoint...\n";
$orderResponse = makeRequest('GET', $baseUrl . '/orders/' . $testOrderId, $authorityToken);
echo "Status: " . $orderResponse['status'] . "\n";
echo "Response: " . json_encode($orderResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

// Test 3: Get All Orders
echo "3. Testing Get All Orders Endpoint...\n";
$ordersResponse = makeRequest('GET', $baseUrl . '/orders', $authorityToken);
echo "Status: " . $ordersResponse['status'] . "\n";
echo "Response: " . json_encode($ordersResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

// Test 4: Get Orders with Filters
echo "4. Testing Get Orders with Filters...\n";
$filteredOrdersResponse = makeRequest('GET', $baseUrl . '/orders?type=main&per_page=5', $authorityToken);
echo "Status: " . $filteredOrdersResponse['status'] . "\n";
echo "Response: " . json_encode($filteredOrdersResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

// Test 5: Test Invalid Token
echo "5. Testing Invalid Token...\n";
$invalidTokenResponse = makeRequest('GET', $baseUrl . '/orders/' . $testOrderId, 'invalid_token');
echo "Status: " . $invalidTokenResponse['status'] . "\n";
echo "Response: " . json_encode($invalidTokenResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

// Test 6: Test Missing Token
echo "6. Testing Missing Token...\n";
$noTokenResponse = makeRequest('GET', $baseUrl . '/orders/' . $testOrderId);
echo "Status: " . $noTokenResponse['status'] . "\n";
echo "Response: " . json_encode($noTokenResponse['data'], JSON_PRETTY_PRINT) . "\n\n";

echo "=== Test Complete ===\n";

/**
 * Make HTTP request
 */
function makeRequest($method, $url, $token = null) {
    $ch = curl_init();

    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'API-Type: dwc_orders',
    ];

    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    if ($error) {
        return [
            'status' => 'error',
            'data' => ['error' => $error]
        ];
    }

    $data = json_decode($response, true);

    return [
        'status' => $httpCode,
        'data' => $data ?: ['raw_response' => $response]
    ];
}

/**
 * Instructions for running this test:
 *
 * 1. Replace $baseUrl with your actual API base URL
 * 2. Set the authority token in your .env file: API_AUTHORITY_TOKEN=your_token
 * 3. Replace $authorityToken with the actual authority token
 * 4. Replace $testOrderId with an actual order ID from your database
 * 5. Run this script: php test_api.php
 *
 * Expected results:
 * - Health check should return 200 OK
 * - Order details should return order data or 404 if order doesn't exist
 * - All orders should return paginated order list for both main and store orders
 * - Filtered orders should return only main orders
 * - Invalid token should return 401 Unauthorized
 * - Missing token should return 401 Unauthorized
 */
