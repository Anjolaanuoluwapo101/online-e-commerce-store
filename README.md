# Online E-Commerce Store - MVC Version

This is a PHP-based e-commerce website converted to MVC architecture with PSR-4 autoloading.

## Directory Structure

```
app/                    # Application source code
├── Controllers/        # Controller classes
│   └── Admin/          # Admin controllers
├── Models/             # Model classes
│   └── Admin/          # Admin models
├── Views/              # View templates
│   ├── layouts/        # Layout templates
│   ├── home/           # Home page views
│   ├── products/       # Product views
│   ├── cart/           # Cart views
│   ├── about/          # About page views
│   ├── contact/        # Contact page views
│   └── admin/          # Admin views
├── Core/               # Core framework classes
public/                 # Publicly accessible files
├── assets/             # CSS, JS, images
├── imgUpload/          # Uploaded product images
└── index.php           # Entry point
```

## Installation

1. Run `composer install` to install dependencies
2. Configure your web server to point to the `public/` directory
3. Ensure the database is set up with the required tables

## Routes

### Frontend Routes
- `/` - Home page
- `/about` - About page
- `/contact` - Contact page
- `/products` - All products
- `/products/{category}` - Products by category
- `/products/{category}/{name}/{id}` - Product details
- `/products/search` - Search products
- `/cart` - Shopping cart
- `/cart/add` - Add to cart
- `/cart/remove/{id}` - Remove from cart
- `/cart/clear` - Clear cart
- `/upvote/{category}/{name}/{id}` - Upvote product

### Admin Routes
- `/admin` - Admin dashboard
- `/admin/products/create` - Add new product
- `/admin/products/store` - Store new product
- `/admin/products/{category}/{id}/edit` - Edit product
- `/admin/products/{category}/{id}/update` - Update product
- `/admin/products/{category}/{id}/delete` - Delete product

## Architecture

This application follows the Model-View-Controller (MVC) pattern:

- **Models** handle data logic and database interactions
- **Views** handle presentation logic and templates
- **Controllers** handle user input and coordinate between models and views

The application uses PSR-4 autoloading for class loading and follows modern PHP practices.