# Shipment Tracker

Shipment Tracker is a Laravel-based web application for managing and tracking shipments. It provides a searchable and filterable list of shipments, detailed shipment status logs, and supports both DataTables and custom views for shipment listings.

## Features

- List all shipments with tracking number, receiver, destination, status, and date
- Search and filter shipments by tracking number, receiver, address, or date
- View detailed shipment status history
- Paginated and DataTables-powered shipment lists
- Status badges for quick status identification (Pending, In Transit, Delivered)
- Database seeding for demo data

## Requirements

- PHP >= 8.0
- Laravel Framework 12.51.0
- Composer
- MySQL or compatible database
- Node.js & npm (for frontend assets, optional)

## Installation
1. Clone the repository:
   git clone <your-repo-url>
   cd shipment-tracker

2. Install PHP dependencies:
   composer install

3. Copy the example environment file and set your configuration:
   cp .env.example .env
   # or manually create .env from .env.example

   Edit `.env` to set your database credentials.
4. Generate application key:
   php artisan key:generate

5. Run migrations and seeders:
   php artisan migrate --seed OR php artisan migrate:fresh --seed

6. (Optional) Install and build frontend assets:
   npm install
   npm run dev


## Usage

Start the local development server:

 php artisan serve 


Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Main Routes

- `/shipments` — DataTables-powered shipment list
- `/custom-shipments` — Custom paginated shipment list with search
- `/shipments/{id}` — Shipment details and status logs
