# Bus Reservation Management System

A Laravel-based Bus Reservation Management System for intercity travel with intermediate stops and seat booking features.

---


## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/hatemghaly230/fleet_management.git
cd fleet_management
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
DB_DATABASE=fleet_management
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


## Admin And User Accounts Example

- email : ali.hamed@golyv.co , password:12345678 ----admin
- email : mohamed.saeed@golyv.co , password:12345678 ----admin
- email : user1@example.com , password:12345678 ----user
- email : user2@example.com , password:12345678 ----user
- email : user3@example.com , password:12345678 ----user


---

## API Endpoints

- `POST /api/login` – Login and receive token  
- `POST /api/register` – Register 
- `GET /api/seats/available?trip_id={id}&from={id}&to={id}` – Check seat availability  
- `GET /api/bookings?trip_id={id}&seat_id={id}&from_station_id={id}&to_station_id={id}` –   Booking


---
