# Bus Reservation Management System

A Laravel-based Bus Reservation Management System for intercity travel with intermediate stops and seat booking features.

---

## Requirements

- PHP >= 8.1  
- Composer  
- MySQL  
- Node.js & NPM (for frontend assets)  
- Laravel 10+  
- Laravel Sail (optional, for Docker-based setup)

---

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/bus-reservation-system.git
cd bus-reservation-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy the .env File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure `.env` File

Set your database connection credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bus_reservation
DB_USERNAME=root
DB_PASSWORD=
```

*(Optional)* Configure mail, queue, and other settings as needed.

---

### 6. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

---

### 7. Install Frontend Dependencies

```bash
npm install
npm run dev
```

For production:

```bash
npm run build
```

---

### 8. Run the Application

```bash
php artisan serve
```

Visit the app at: [http://localhost:8000](http://localhost:8000)

---

## API Endpoints

- `POST /api/login` – Login and receive token  
- `GET /api/seats/available?trip_id={id}&station_from_id={id}&station_to_id={id}` – Check seat availability  

> All other endpoints are protected and require Bearer Token authentication.

---

## Features

- Trip management with intermediate stations  
- Bus and seat management  
- Dynamic seat availability checking  
- Booking and reservation logic  
- RESTful API with authentication  
- Clean service-based architecture

---

## Development Notes

- Business logic handled in service classes (e.g., `TripService`, `BookingService`)  
- API Resources used for consistent JSON responses  
- Policies and Gates used for access control  

---

## Optional: Run with Laravel Sail (Docker)

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```


