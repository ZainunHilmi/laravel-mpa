# POS System Implementation Guide

This project has been updated with POS features.

## Core Features Used
- **Models**: Product, Category, Order, OrderItem.
- **Cart**: Session-based cart in `CartController`.
- **Checkout**: Database Transaction ensures stock is only reduced if the order is successful.

## Database Changes
- Added `categories` table.
- Updated `products` table to use `category_id`.

## How to Run

1.  **Install Dependencies**:
    ```bash
    composer install
    ```

2.  **Install Breeze** (Authentication):
    ```bash
    composer require laravel/breeze --dev
    php artisan breeze:install blade
    ```

3.  **Run Migrations**:
    ```bash
    php artisan migrate
    ```

4.  **Start Server**:
    ```bash
    php artisan serve
    ```

## Routes
- Cart: `/cart`
- Add to Cart: POST `/cart/add/{id}`
- Checkout: POST `/checkout`
