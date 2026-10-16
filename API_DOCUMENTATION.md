# Order Details API Documentation

## Overview
This API provides access to order details with custom token-based authentication. The authority provides a single token that anyone can use to access the data. The API follows RESTful principles and returns JSON responses.

## Base URL
```
https://your-domain.com/api
```

## Authentication
All API endpoints require a Bearer token provided by the authority.

### Headers Required
```
Authorization: Bearer YOUR_AUTHORITY_TOKEN
Content-Type: application/json
Accept: application/json
```

## Configuration
Set the authority token in your `.env` file:
```
API_AUTHORITY_TOKEN=your_custom_token_here
```

## Endpoints

### 1. Get Order Details
Retrieve detailed information about a specific order.

**Endpoint:** `GET /api/orders/{orderId}`

**Parameters:**
- `orderId` (required): The ID of the order to retrieve

**Response:**
```json
{
    "success": true,
    "message": "Order details retrieved successfully",
    "data": {
        "order": {
            "id": 123,
            "order_no": "ORD-001",
            "status": {
                "id": 1,
                "name": "Pending"
            },
            "organization": {
                "id": 1,
                "name": "Sample Organization",
                "sport": "Basketball"
            },
            "contact": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "phone": "123-456-7890"
            },
            "financial": {
                "sub_total": 100.00,
                "sales_tax": 8.00,
                "shipping": 10.00,
                "order_total": 118.00
            },
            "dates": {
                "open_date": "2024-01-01",
                "due_date": "2024-01-15",
                "created_at": "2024-01-01T10:00:00Z",
                "updated_at": "2024-01-01T10:00:00Z"
            },
            "order_items": [
                {
                    "id": 1,
                    "product": {
                        "id": 1,
                        "product_name": "Team Jersey",
                        "product_code": "TJ-001"
                    },
                    "quantity": 10,
                    "unit_price": 25.00,
                    "total_price": 250.00
                }
            ]
        },
        "order_type": "main_order"
    },
    "timestamp": "2024-01-01T10:00:00Z"
}
```

### 2. Get All Orders
Retrieve all orders (both main orders and store orders).

**Endpoint:** `GET /api/orders`

**Query Parameters:**
- `page` (optional): Page number for pagination (default: 1)
- `per_page` (optional): Number of items per page (default: 20, max: 100)
- `status` (optional): Filter by order status ID
- `date_from` (optional): Filter orders from this date (YYYY-MM-DD)
- `date_to` (optional): Filter orders to this date (YYYY-MM-DD)
- `type` (optional): Filter by order type - 'main', 'store', or 'all' (default: 'all')

**Example:** `GET /api/orders?page=1&per_page=10&type=main&date_from=2024-01-01`

**Response:**
```json
{
    "success": true,
    "message": "Orders retrieved successfully",
    "data": {
        "main_orders": {
            "orders": [
                {
                    "id": 123,
                    "order_no": "ORD-001",
                    "status": {
                        "id": 1,
                        "name": "Pending"
                    },
                    "organization": {
                        "id": 1,
                        "name": "Sample Organization"
                    },
                    "created_at": "2024-01-01T10:00:00Z"
                }
            ],
            "pagination": {
                "current_page": 1,
                "last_page": 5,
                "per_page": 20,
                "total": 100,
                "from": 1,
                "to": 20
            }
        },
        "store_orders": {
            "orders": [
                {
                    "id": 456,
                    "order_no": "STORE-001",
                    "status": {
                        "id": 2,
                        "name": "Processing"
                    },
                    "customer": {
                        "id": 1,
                        "name": "Jane Smith"
                    },
                    "created_at": "2024-01-01T10:00:00Z"
                }
            ],
            "pagination": {
                "current_page": 1,
                "last_page": 3,
                "per_page": 20,
                "total": 50,
                "from": 1,
                "to": 20
            }
        }
    },
    "timestamp": "2024-01-01T10:00:00Z"
}
```

### 3. Health Check
Check if the API is running.

**Endpoint:** `GET /api/health`

**Response:**
```json
{
    "status": "ok",
    "timestamp": "2024-01-01T10:00:00Z",
    "version": "1.0.0"
}
```

## Error Responses

### Authentication Errors

**Missing Token (401):**
```json
{
    "success": false,
    "message": "Authorization token is required",
    "error_code": "MISSING_TOKEN"
}
```

**Invalid Token (401):**
```json
{
    "success": false,
    "message": "Invalid or unauthorized token",
    "error_code": "INVALID_TOKEN"
}
```

### Client Errors

**Invalid Order ID (400):**
```json
{
    "success": false,
    "message": "Invalid order ID provided",
    "error_code": "INVALID_ORDER_ID"
}
```

**Order Not Found (404):**
```json
{
    "success": false,
    "message": "Order not found",
    "error_code": "ORDER_NOT_FOUND"
}
```

### Server Errors

**Internal Server Error (500):**
```json
{
    "success": false,
    "message": "An error occurred while retrieving order details",
    "error_code": "INTERNAL_ERROR",
    "error_details": "Detailed error message (only in debug mode)"
}
```

## Rate Limiting
The API implements rate limiting to prevent abuse. Default limits are:
- 60 requests per minute per IP address
- 1000 requests per hour per authenticated user

## Setup Instructions

### 1. Configure Authority Token
Add the authority token to your `.env` file:
```bash
API_AUTHORITY_TOKEN=your_custom_token_from_authority
```

### 2. Test the API
Test the health endpoint:
```bash
curl -X GET https://your-domain.com/api/health
```

Test with authentication:
```bash
curl -X GET https://your-domain.com/api/orders/1 \
  -H "Authorization: Bearer YOUR_AUTHORITY_TOKEN" \
  -H "Accept: application/json"
  -H "API-Type: YOUR_API_TYPE_KEY"
```

## Security Considerations

1. **Token Security**: Keep the authority token secure and don't expose it in client-side code.

2. **HTTPS**: Always use HTTPS in production to protect tokens in transit.

3. **Token Management**: The authority manages the token. Contact them for token updates or revocation.

4. **Access Control**: Anyone with the valid token can access all order data.

5. **Rate Limiting**: Implement appropriate rate limiting to prevent abuse.

## Support
For API support or questions, please contact the authority or development team.
