# MarketLink — eGreen Basket 🌿

A Laravel-based farmers' market and pre-order platform that connects local farmers with customers looking to buy fresh, organic produce.

MarketLink allows customers to browse products and farmers, add items from different stalls to a basket, choose a pickup time, and collect their orders directly from the selected market.

---

## About the Project

**MarketLink** is a full-stack Laravel application built for the **eGreen Basket** farmers' market concept.

The main goal of the project is to make it easier for local farmers to manage their products and pre-orders while giving customers a simple way to discover fresh produce and reserve it for pickup.

The application uses Laravel, MySQL, Blade, Bootstrap, and a few frontend libraries for maps and charts.

---

## Main Features

### Customer

Customers can:s

* Browse available markets and farmers
* View products and their current stock
* Search through the product catalog
* Add products from different farmers to one basket
* Select a pickup market and available time slot
* Place orders using the pay-at-pickup option
* Track order status
* Save favorite farmers and products
* Leave reviews after completing an order
* Receive order and status notifications

### Farmer

Farmers have their own dashboard where they can:

* Manage their farm profile
* Add, edit, and remove products
* Update product stock
* Upload product and stall images
* View incoming orders
* Update order status
* Set available pickup slots
* Set pickup capacity
* View sales and revenue information
* See their customer reviews
* Respond to customer reviews

### Admin

The admin panel provides tools to manage the platform, including:

* Approving and managing farmer accounts
* Managing customers
* Managing markets and locations
* Managing product categories
* Reviewing marketplace products
* Monitoring all orders
* Moderating customer reviews
* Viewing platform statistics and reports

---

## How Orders Work

MarketLink is designed around **pickup orders instead of home delivery**.

Customers can add products from multiple farmers to their basket. During checkout, the system separates the basket into individual farmer orders so each farmer can manage their own products and pickup arrangements.

The normal order flow is:

```text
Placed → Accepted → Ready for Pickup → Completed
```

Payments are made directly at the market during pickup. The project does not use online payment gateways such as Stripe or PayPal.

---

## Market Map

The project includes an interactive market map built with **Leaflet.js** and **OpenStreetMap**.

Market locations are stored in the database along with their latitude and longitude. The map loads these locations dynamically, allowing customers to find the markets available on the platform.

---

## User Roles

MarketLink currently has three main types of users:

| Role     | Description                                                        |
| -------- | ------------------------------------------------------------------ |
| Customer | Browses products, places orders, manages favorites and reviews     |
| Farmer   | Manages products, orders, pickup slots and farm information        |
| Admin    | Manages farmers, customers, markets, products, reviews and reports |

Each role has its own dashboard and protected routes.

---

## Demo Accounts

The project includes seeded demo accounts that can be used to test the different parts of the application.

| Portal   | Email                  | Password   |
| -------- | ---------------------- | ---------- |
| Admin    | `admin@marketlink.com` | `password` |
| Farmer   | `ahmed@farmer.com`     | `password` |
| Farmer   | `fatima@farmer.com`    | `password` |
| Farmer   | `hassan@farmer.com`    | `password` |
| Farmer   | `sara@farmer.com`      | `password` |
| Customer | `customer@demo.com`    | `password` |

The seeded data also includes example products, orders, reviews, stock information, and other records used throughout the application.

---

## Technology Stack

* **Framework:** Laravel 11
* **PHP:** 8.2+
* **Database:** MySQL 8.0+
* **Frontend:** Blade
* **CSS:** Bootstrap 5.3.3 + custom CSS
* **Icons:** Bootstrap Icons 1.11
* **Maps:** Leaflet 1.9.4 + OpenStreetMap
* **Charts:** Chart.js 4.4.0
* **ORM:** Laravel Eloquent
* **Authentication:** Laravel authentication and role-based middleware
* **Sessions:** Database-backed sessions
* **Notifications:** Database notifications

---

## Main Routes

### Public Pages

```text
/                     Home page
/markets               Market directory
/markets/{market}      Market details
/farmers               Farmer directory
/farmers/{farmer}      Farmer details
/products              Product catalog
/products/{product}    Product details
/map                   Market map
```

### Customer Portal

```text
/customer/dashboard
/customer/cart
/customer/checkout
/customer/orders
/customer/orders/{order}
/customer/favorites
/customer/reviews
/customer/notifications
```

### Farmer Portal

```text
/farmer/dashboard
/farmer/orders
/farmer/products
/farmer/pickup-slots
/farmer/insights
/farmer/reviews
/farmer/profile
```

### Admin Portal

```text
/admin/dashboard
/admin/farmers
/admin/farmers/{farmer}
/admin/customers
/admin/customers/{customer}
/admin/markets
/admin/categories
/admin/products
/admin/orders
/admin/reviews
/admin/reports
```

---

## Installation

Follow these steps to run the project locally.

### 1. Clone the Project

Open your terminal and move into the project directory:

```bash
cd "techwiz sameer"
```

### 2. Install Dependencies

Install the Laravel/PHP dependencies using Composer:

```bash
composer install
```

### 3. Configure the Database

Create a MySQL database named:

```text
marketlink_db
```

Then update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketlink_db
DB_USERNAME=root
DB_PASSWORD=
```

Update the username and password if your local MySQL setup uses different credentials.

### 4. Run Migrations and Seed the Database

To create the tables and load the demo data:

```bash
php artisan migrate:fresh --seed
```

> **Note:** `migrate:fresh` will remove existing tables and recreate them, so don't use it if you have important data in the database.

### 5. Create the Storage Link

The application uses Laravel storage for product and farmer/stall images.

Run:

```bash
php artisan storage:link
```

### 6. Start the Laravel Server

Run:

```bash
php artisan serve
```

Then open:

```text
http://127.0.0.1:8000
```

in your browser.

---

## Testing

A PowerShell smoke-test script is included to check the main role-based routes.

Run:

```powershell
powershell -ExecutionPolicy Bypass -File test_roles.ps1
```

The script checks routes for the Customer, Farmer, and Admin portals.

---

## Project Structure

The project follows the standard Laravel structure, with the main application logic organized into:

```text
app/
├── Http/
├── Models/
├── Notifications/
└── ...

database/
├── migrations/
└── seeders/

resources/
├── views/
└── css/

routes/
└── web.php

public/
└── ...

storage/
└── ...
```

---

## Notes

* All marketplace data is stored in MySQL and loaded through Laravel's Eloquent models.
* Orders are pickup-only; there is no home delivery system.
* Payments are handled at pickup rather than through an online payment gateway.
* The application supports multiple farmers in a single customer basket.
* Farmer, customer, and admin areas are protected using role-based access control.

---

## Project

**MarketLink — eGreen Basket**

A simple way to connect local farmers with customers and make farmers' market pre-orders easier to manage.
