# Magento 2 Review API Extension

## Overview

The Magento 2 Review API extension is designed to give developers and integrators a convenient way to manage and manipulate product reviews programmatically via a robust API. This extension enables the creation, updating, fetching, and deleting of product reviews, as well as managing their associated ratings. It is built according to Magento standards, ensuring seamless integration with your existing Magento 2 store.
Features

    Create a new product review
    Update an existing product review
    Fetch product review(s) based on specific criteria
    Delete a product review
    Manage ratings associated with a product review

## Requirements

    Magento 2.x (tested up to 2.4)
    PHP 7.4 or later


## Usage

To use this extension, you need to make requests to specific endpoints with the appropriate request body. Each endpoint corresponds to a specific action on product reviews. Here are the available endpoints:

    POST /V1/reviews to create a new review.
    PUT /V1/reviews/{id} to update an existing review.
    GET /V1/reviews/{id} to fetch a review.
    DELETE /V1/reviews/{id} to delete a review.
    GET /V1/product/{productSku}/reviews to fetch reviews based on product SKU.

Please refer to the detailed API documentation for more information about request bodies, parameters, and responses for each endpoint.
Support

## License

This extension is licensed under the MIT License.
Acknowledgments

This project was developed by [Tweave].

In the detailed documentation, you can then provide more specifics about each endpoint, including example requests and responses. Remember to replace placeholders (like link-to-installation-guide) with actual links.
