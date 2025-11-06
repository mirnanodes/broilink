# BroiLink Backend API

Backend API untuk sistem manajemen farm berbasis IoT menggunakan Laravel 12.

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Sanctum

## Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL/MariaDB

### Installation

1. Install dependencies
```bash
composer install
```

2. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=broilink_db
DB_USERNAME=root
DB_PASSWORD=
```

4. Run migrations
```bash
php artisan migrate
```

5. Start server
```bash
php artisan serve
```

API will be available at `http://localhost:8000`

## API Documentation

See [SETUP_GUIDE.md](../SETUP_GUIDE.md) for complete API documentation.

## Project Structure

```
app/
├── Http/
│   ├── Controllers/    # API Controllers
│   └── Middleware/     # Custom Middleware
├── Models/             # Eloquent Models
config/                 # Configuration files
database/
├── migrations/         # Database migrations
└── seeders/           # Database seeders
routes/
└── api.php            # API routes
```

## Available Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (drop all tables)
php artisan migrate:fresh

# Run seeders
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# List all routes
php artisan route:list
```

## Authentication

This API uses Laravel Sanctum for token-based authentication.

**Login**: `POST /api/login`
```json
{
  "username": "user@example.com",
  "password": "password"
}
```

**Response**:
```json
{
  "token": "1|abc123...",
  "user": { ... },
  "redirect": "admin"
}
```

All protected routes require `Authorization: Bearer {token}` header.

## User Roles

- **admin**: Full system access
- **owner**: Farm monitoring and analysis
- **peternak**: Daily data input and farm status

## CORS Configuration

Frontend URLs allowed in `config/cors.php`:
- http://localhost:5173
- http://127.0.0.1:5173

## License

Proprietary
