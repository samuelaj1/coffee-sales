# Competence Development
Laravel Task

## Installation Guide

### Prerequisites

Ensure you have the following installed on your machine:

- Docker & Docker Compose
- Git

### 1. Cloning the Repository

```sh
git clone https://github.com/samuelaj1/coffee-sales.git
cd coffee-sales
```

### 2. Setting Up Environment Variables

Copy the example environment file:

```sh
cp .env.example .env
```

### 3. Running the Project with Docker

```sh
docker-compose up -d --build
```
This command will start the **app**, **MySQL database**, and **Nginx server**.

### 4. Updating composer and dependecies
```sh
docker-compose exec app composer install
```
This command will update the dependences for the project.

### 5. Running Migrations & Seeding Database

```sh
docker-compose exec app php artisan migrate --seed
```

### 6. View the project in the browser
The project should now be accessible at [**http://localhost:8000**](http://localhost:8000)

---

## Project Structure

```
├── app/              # Laravel application logic
├── bootstrap/        # Application bootstrap files
├── config/           # Configuration files
├── database/         # Migrations, seeders, factories
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
├── public/           # Public assets
├── resources/        # Views, Vue components
│   ├── js/
│   ├── sass/
├── routes/           # routes
├── storage/          # Logs, cached views
├── tests/            # Application tests
├── docker-compose.yml # Docker setup
├── nginx.conf        # Nginx configuration
└── README.md         # Project documentation
```

---

## Additional Docker Commands

### Checking Logs

```sh
docker-compose logs -f app
```

### Running Artisan Commands

```sh
docker-compose exec app php artisan <command>
```

### Running Composer Commands

```sh
docker-compose exec app composer <command>
```

### Stopping Containers

```sh
docker-compose down
```

---

## Database Seeding

The project includes a database seeder to populate initial data. To run the seeder:

```sh
docker-compose exec app php artisan db:seed
```

This will insert sample records into the database.

---

## Troubleshooting

If you encounter database connection errors, try running:

```sh
docker-compose exec app php artisan config:clear
```

If the issue persists, restart the containers:

```sh
docker-compose down
docker-compose up -d --build
```

---
