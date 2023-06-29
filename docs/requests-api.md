## Magento 2 Review API Extension: Detailed API Documentation

Welcome to the detailed API documentation of the Magento 2 Review API extension. This document provides in-depth information about each endpoint offered by this extension, and demonstrates how to interact with them to perform various actions on product reviews.

The Magento 2 Review API extension provides a robust set of endpoints designed to give integrators full control over the product reviews in a Magento store. These endpoints follow RESTful conventions, accept JSON payloads, and return JSON responses.

Whether you're creating a new review, fetching existing reviews, updating a review, deleting a review, or managing review ratings, this document is your comprehensive guide to understanding how to correctly format your requests and interpret the responses.

## Authentication

Before diving into the specifics of each endpoint, note that all API endpoints provided by the Magento 2 Review API extension require authentication. You must include an Authorization: Bearer {token} header in each request.
Obtaining the Bearer Token

The Bearer token can be obtained through your Magento admin panel by creating a new integration. Follow these steps:

1. Log into your Magento 2 admin dashboard.
2. Navigate to System > Extensions > Integrations.
3. Click Add New Integration and fill in the required fields.
4. In the API section, select the permissions required by the Review API extension:
- Create Review
- Delete Review
- List Reviews
- Get Review
- Update Review
    
5. Click Save & Activate to get your Access Token, which is your Bearer token.

Remember, the Bearer token should be kept secure, as anyone with the token can access your API resources. Let's now dive into how to interact with each API endpoint using authenticated requests.

## Creating a Review

The `create` endpoint allows you to create a review on a specific product. This endpoint requires the `POST` HTTP method and the URL should be `http://yourmagento2website/rest/V1/reviews`.

### HTTP Request

The request body should contain the review data as JSON. Here's an example of a request body:

```json
{
  "reviewData": {
    "title": "Amazing Product",
    "content": "This product is the best I have ever used!",
    "customerName": "John Doe",
    "productSku": "my-product-sku",
    "storeId": 1,
    "rating": 5,
    "status": 1
  }
}
```

Or, you can specify a registered customer email:

```json
{
    "reviewData": {
        "title": "Great Product",
        "content": "The quality of this product is outstanding!",
        "customerEmail": "johndoe@example.com",
        "productSku": "my-product-sku",
        "storeId": 1,
        "rating": 5,
        "status": 1
    }
}

```
The reviewData object should include:

- title: The title of the review.
- content: The content of the review.
- customerName: The name of the customer who is making the review. This should be provided if customerEmail is not available.
- customerEmail: The email address of the registered customer who is making the review. This should be provided if customerName is not available.
- productSku: The SKU of the product that is being reviewed.
- storeId: The ID of the store view where the review will be displayed.
- rating: The rating given by the customer (an integer between 1 and 5).
- status: The status of the review (1 for pending, 2 for approved, 3 for not approved).

Having both customerName and customerEmail the email will have priority. The nickname of the review will be either the customerName if the email is missing or invalid customer or the name added by the user if the email is a valid customer.

### Response

The response will be a JSON object containing the newly created review data. Here's an example of a response:

```json
[
    {
        "success": true,
        "review": {
            "id": "63",
            "title": "Amazing Product",
            "detail": "This product is the best I have ever used!",
            "nickname": "John Doe",
            "customerId": null
        }
    }
]
```

## Fetching a Review

This endpoint allows you to fetch a review by its unique ID.

### HTTP Request

GET http://yourmagento2website/rest/V1/reviews/{id}

### URL Parameters

| Parameter  | Description                             |
|------------|-----------------------------------------|
| `reviewId` | **Required**. The ID of the review you want to fetch. |

The endpoint returns an object containing the review's data. The review object has the following properties:


### Response

The response will be a JSON object containing the review data. Here's an example of a response:

```json
[
    {
        "success": true,
        "review": {
            "id": "63",
            "title": "Amazing Product",
            "detail": "This product is the best I have ever used!",
            "nickname": "John Doe",
            "status": "1",
            "customerId": null,
            "rating": "5"
        }
    }
]

```

## Update a Review

This endpoint updates an existing review based on the given review data.

### HTTP Request

PUT http://magento2.lh/rest/V1/reviews/{reviewId}


### URL Parameters

| Parameter  | Description                             |
|------------|-----------------------------------------|
| `reviewId` | **Required**. The ID of the review to update. |

### Body Parameters

The `reviewData` object contains the information to be updated. None of the fields are mandatory, which means you can provide any combination of them in the request. If a field is not provided, it will not be updated.

The `reviewData` object contains the following fields:

- `status`: The status of the review.
- `title`: The title of the review.
- `content`: The content of the review.
- `customerEmail`: The email of the customer who made the review.
- `customerName`: The name of the customer who made the review.
- `rating`: The rating given to the product.

Note:
1. The `customerId` can be changed. If the `customerEmail` provided does not correspond to the current `customerId`, it will be updated accordingly. Even make it a guest if the email is not longer an customer.
2. The `storeId` and `productSku` fields cannot be updated.


## Delete a Review

This endpoint allows you to delete a review based on the given review ID.

### HTTP Request

DELETE http://magento2.lh/rest/V1/reviews/{reviewId}


### URL Parameters

| Parameter  | Description                             |
|------------|-----------------------------------------|
| `reviewId` | **Required**. The ID of the review to delete. |

### Response

The endpoint returns a JSON object containing a success status and a corresponding message.

#### Successful Deletion

If the review was successfully deleted, the response would be as follows:

```json
{
    "success": true,
    "message": "Review successfully deleted."
}
```

#### Failed Deletion

If the deletion fails due to the review not existing or any other reason, the response would be as follows:

```json
{
    "success": false,
    "message": "Failed to delete review. Error: No such entity with id [reviewId]"
}
```

## Get All Reviews by Product SKU

This endpoint allows you to retrieve all reviews for a specific product, given the product's SKU.

### HTTP Request

GET http://magento2.lh/rest/V1/product/{productSku}/reviews


### URL Parameters

Parameter     | Description
------------- | -------------
`productSku`  | **Required**. The SKU of the product to fetch reviews for.

### Response

The endpoint returns an object that contains an array of review objects for the specified product. Each review object has the following properties:

- `id`: The unique identifier of the review.
- `nickname`: The nickname of the reviewer.
- `title`: The title of the review.
- `detail`: The detailed review content.
- `status`: The status of the review. "1" indicates that the review is approved.
- `customerId`: The ID of the customer who wrote the review. If the review was written by a guest, this field will be `null`.
- `rating`: The rating given in the review. If there is no rating, this field will be `null`.

If the provided product SKU does not match any existing product, the endpoint will return a `NoSuchEntityException`.

Example response:

```json
{
    "success": true,
    "reviews": [
        {
            "id": "124",
            "nickname": "Jack Sparrow",
            "title": "Excellent Product",
            "detail": "This product exceeded my expectations.",
            "status": "1",
            "customerId": null,
            "rating": "5"
        },
        {
            "id": "125",
            "nickname": "Jane Doe",
            "title": "Satisfactory",
            "detail": "Decent product for the price.",
            "status": "1",
            "customerId": "2",
            "rating": "3"
        }
    ]
}
```
