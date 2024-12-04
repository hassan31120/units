# Laravel Unit Management API

This is a simple Laravel API for managing units (e.g., apartments, villas). It includes basic CRUD operations with authentication and file upload functionality.

## Features

- User registration and authentication using **Laravel Sanctum**.
- CRUD operations (Create, Read, Update, Delete) for managing units.
- Search functionality to filter units by name, area, address, and more.
- File upload support using **Spatie Media Library** for images and contract files.

## Installation

- git clone 
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
- php artisan migrate
- php artisan storage:link
- php artisan ser

