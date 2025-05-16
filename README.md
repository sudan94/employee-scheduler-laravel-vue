# Employee Scheduler

This is a demo application built with Laravel (API) and Vue.js, showcasing a basic scheduler for future data changes. The main feature allows users to schedule updates—such as changing an employee's address—that will automatically take effect on a specified future date.

The system uses the Laravel Scheduler with a cron job running every 5 minutes to check and apply scheduled changes. The project is containerized using Docker and uses MySQL for data storage.

## Prerequisites

- Docker and Docker Compose
- Git
- MySQL Server

## Environment Setup

1. Clone the repository:
```bash
git clone https://github.com/sudan94/hrpuls-test.git
cd hrpuls-test
```

2. Create Laravel environment file:

Copy `.env.example` to `.env` in the backend directory:
```bash
cp backend/.env.example backend/.env
```
> **_NOTE:_** The database connection settings in `.env` should match your MySQL server configuration. If you have MySQL already running locally, update the credentials for (DB_USERNAME and DB_PASSWORD) accordingly.
```bash
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=laravel-vue-db
DB_PORT=3306
DB_DATABASE=hrpuls_test
DB_USERNAME=root
DB_PASSWORD=
```

## Running the Application

1. Build and start the containers:
```bash
cd hrpuls-test
docker-compose up -d --build
```

2. Run the migration
```bash
docker-compose exec server php artisan migrate
```
> **_NOTE:_** If the database 'hrpuls_test' does not exist, you will be prompted with: "The database 'hrpuls_test' does not exist on the 'mysql' connection. Would you like to create it?". You can either enter 'yes' to create it automatically or create it manually in MySQL.

3. Run the Database seeder
```bash
docker-compose exec server php artisan db:seed --class=EmployeeSeeder
```

4. Access the frontend application:
- Frontend: `http://localhost:3000`

5. Access the backend API:
- Backend API: `http://localhost:8000`

## Scheduled Tasks

The application includes scheduled tasks that run daily. These are managed by the Laravel scheduler and Docker cron jobs.

## Manually Exectue Schedule Tasks
 ```bash
docker-compose exec server php artisan schedule:run
```
