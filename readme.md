# Education Platform - Laravel

A comprehensive education platform built with Laravel for course management, student enrollment, and assessment through quizzes.

## Features

### For Students
- **User Authentication**: Register and login securely
- **Course Browsing**: View available courses and their details
- **Course Enrollment**: Enroll in courses of interest
- **Progress Tracking**: Track your progress in each course
- **Quizzes**: Take quizzes to test your knowledge and receive immediate feedback
- **Dashboard**: View all your enrolled courses and overall progress

### For Educators
- **Specialized Authentication**: Separate educator registration and login
- **Course Management**: Create, edit, and manage your courses
- **Quiz Creation**: Create quizzes for your courses with customizable settings
- **Student Tracking**: Monitor student enrollment and progress
- **Admin Capabilities**: Educators with admin role have additional management options

## System Requirements

- PHP >= 7.3
- MySQL >= 5.7
- Composer
- Laravel 8.x

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/education-platform.git
   cd education-platform
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Create and configure your `.env` file:
   ```
   cp .env.example .env
   ```
   Update the database connection details in the `.env` file.

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Run migrations:
   ```
   php artisan migrate
   ```

6. (Optional) Seed the database with test data:
   ```
   php artisan db:seed
   ```

7. Start the development server:
   ```
   php artisan serve
   ```

## Usage

### Student Registration and Login
- Navigate to `/student/register` to create a new student account
- Log in at `/student/login` with your credentials

### Educator Registration and Login
- Navigate to `/educator/register` to create a new educator account
- Log in at `/educator/login` with your credentials

## Database Structure

### Key Models
- **Student**: Manages student profiles and enrollments
- **Educator**: Handles educator profiles and course management
- **Course**: Represents educational courses
- **Quiz**: Represents assessments tied to courses

### Relationships
- A Student can enroll in many Courses
- An Educator can create many Courses
- A Course can have many Quizzes
- A Student can attempt many Quizzes

## Security

- Authentication guards for different user types (students and educators)
- Middleware protection for routes based on user type
- CSRF protection for all forms
- Data validation on all inputs

## License

This project is licensed under the [MIT License](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Acknowledgements

- Built with [Laravel](https://laravel.com/)
- Styled with [Bootstrap](https://getbootstrap.com/)
