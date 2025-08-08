# E-commerce Platform

This project is a comprehensive e-commerce platform built with the Laravel framework. It provides a complete solution for online shopping, including a customer-facing storefront and an admin panel for managing products, orders, and users. The project is named `sieuthi-to-lv`, which translates to "Supermarket To LV", suggesting a focus on a wide range of products.

## Features

### Customer-Facing Features
- **User Authentication**: Customers can register, log in, and manage their accounts.
- **Product Catalog**: Browse products by category, search for specific items, and view detailed product pages.
- **Shopping Cart**: Add products to a shopping cart, update quantities, and remove items.
- **Checkout Process**: A seamless checkout process for placing orders.
- **Order Tracking**: Customers can view their order history and track the status of their orders.
- **User Profile**: Manage personal information, shipping addresses, and view order history.

### Admin Panel Features
- **Dashboard**: An overview of key metrics such as sales, orders, and new customers.
- **Product Management**: Add, edit, and delete products. Manage product images, stock levels, and pricing.
- **Category Management**: Organize products into categories for easy navigation.
- **Order Management**: View and manage customer orders, update order statuses, and handle payments.
- **User Management**: View and manage customer accounts.
- **Admin Profile**: Manage admin user profiles.

## Technologies Used

- **Backend**: PHP 8.2, Laravel 12
- **Frontend**: JavaScript, Tailwind CSS, Vite
- **Database**: SQLite (for development), configurable for other databases like MySQL or PostgreSQL.
- **Authentication**: Laravel's built-in authentication system.
- **Routing**: Laravel's routing system for defining application endpoints.
- **ORM**: Eloquent ORM for database interactions.
- **Templating**: Blade templating engine for creating dynamic views.

## Setup and Installation

To get the project up and running on your local machine, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/sieuthi-to-lv.git
   cd sieuthi-to-lv
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set up environment variables**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate an application key:
     ```bash
     php artisan key:generate
     ```

4. **Configure the database**:
   - Create a database for the application.
   - Update the database credentials in your `.env` file.

5. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

6. **Seed the database** (optional):
   - If you want to populate the database with sample data, run the database seeders:
     ```bash
     php artisan db:seed
     ```

7. **Build frontend assets**:
   ```bash
   npm run build
   ```

8. **Run the development server**:
   ```bash
   php artisan serve
   ```

The application should now be running at `http://localhost:8000`.

## Usage

- **Admin Panel**: Access the admin panel by navigating to `/admin`.
- **Customer Storefront**: The main storefront is accessible at the root URL (`/`).

## API Endpoints

The application's routes are defined in `routes/web.php`. Key route groups include:
- `/`: Customer-facing routes.
- `/admin`: Admin panel routes.
- `/cart`: Shopping cart operations.
- `/checkout`: Checkout process.
- `/order`: Order management.

## Database Schema

The database schema is defined by the migration files in the `database/migrations` directory. The main tables include:
- `users`
- `products`
- `categories`
- `orders`
- `order_details`
- `carts`
- `cart_details`
- `vouchers`
- `product_reviews`

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any bugs or feature requests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
