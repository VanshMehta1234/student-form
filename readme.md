# Student Registration System

A Laravel-Vue.js application for managing student records.

## Prerequisites

- PHP >= 8.1
- Node.js >= 14
- MySQL >= 5.7
- Composer

## Installation Steps

1. Clone the repository:
```bash
git clone <repository-url>
cd Registration-form-in-laravel
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Create a copy of the environment file:
```bash
cp .env.example .env
```

5. Configure your `.env` file:
- Set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_form
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Compile frontend assets:
```bash
npm run dev
```

9. Start the development server:
```bash
php artisan serve
```

The application should now be running at `http://127.0.0.1:8000`

## Features

- Student registration with fields for name, date of birth, email, phone, and course
- View list of all registered students
- Edit student information
- Delete student records
- Responsive design using Bootstrap

## Technology Stack

- Backend: Laravel 9.x
- Frontend: Vue.js 3.x with Vuex
- Database: MySQL
- Styling: Bootstrap 5.x

## Common Issues and Solutions

1. If you get a permission error, run:
```bash
chmod -R 777 storage bootstrap/cache
```

2. If you get a MySQL connection error, make sure:
- MySQL service is running
- Database credentials in `.env` are correct
- The database exists

3. If you get deprecation warnings, add to `.env`:
```
PHP_ERROR_REPORTING=32767
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request
