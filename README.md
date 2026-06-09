# 🌟 Havmate: Breaking the Boundary for Farmers to the Market 🌱
This project was developed to help farmers in selling their crops from their farmland or
plantations without going through a middleman. With the system we made, it is hoped that farmers can sell directly to consumers/distributors at the agreed price. This is
intended so that farmers can get greater profits and consumers/distributors can get goods at a low price.

## 🚀 Features
- **Farm Management**: Comprehensive management of farm produce, including harvesting, inventory, and supply chain management.
- **Search Potential Customers**: Activity searching the potential customers for comparing the offering prices and distance of each customer, then the
Farmer will see a list of potential Customers based on parameter
recommendation. Those features will help the farmers to know their target
market before offering their products
- **Search Products**: Customers can search and compare price and distance
products according to their needs, and see a list of products based on
recommendations from the system.
- **Offering**:  Customers can search and compare price and distance products according to their needs, and see a list of products based on recommendations from the system.
- **Ordering**:This activity will be done by customers when they find products that suit their needs, then to do the order customer needs to fill
the Purchase Request first before sending the order.


## 🛠️ Tech Stack
- **Backend**: Laravel Framework (PHP)
- **Frontend**: JavaScript (with Bootstrap and custom CSS)
- **Database**: MySQL and PostgreSQL (with Laravel's database migration system)
- **Geocoding**: Google Maps, GeoPlugin (with Laravel's geocoding package)


## 📦 Installation
### Prerequisites
- PHP 8.0 or higher
- Composer installed
- Laravel Framework installed
- Database (SQLite, MySQL, or PostgreSQL) set up

### Setup Instructions
1. Clone the repository: `git clone https://github.com/devrikaaaf/Havmate-Farmer`
2. Install dependencies: `composer install`
3. Set up database: `php artisan migrate`
4. Seed database: `php artisan db:seed`
5. Start server: `php artisan serve`

## 💻 Usage
1. Access the consumer portal: `http://localhost:8000`
2. Browse and purchase farm produce
3. Manage farm and distributor accounts: `http://localhost:8000/dashboard`

## 📂 Project Structure
```markdown
Havmate/
app/
Console/
Commands/
Kernel.php
...
Http/
Controllers/
Middleware/
...
Models/
...
...
config/
app.php
auth.php
database.php
...
database/
migrations/
...
seeders/
...
resources/
js/
app.js
...
views/
dashboard/
layouts/
...
...
routes/
web.php
...
public/
index.php
...
vendor/
...
...
```


