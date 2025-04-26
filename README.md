# Huntly - Job Listing Platform

## Overview

Huntly is a comprehensive job listing platform that connects job seekers with employers. The platform allows companies to post job listings and job seekers to search and apply for positions that match their skills and interests. Built with PHP using an MVC architecture, Huntly provides a robust solution for job recruitment needs.

## Features

- **User Authentication**: Separate login portals for job seekers, employers, and administrators
- **Job Management**: Post, edit, and delete job listings with detailed descriptions
- **Search Functionality**: Advanced search with filters for job title, location, job type, work model, etc.
- **Application System**: Apply for jobs with resume upload and cover letter submission
- **Admin Dashboard**: Approve/reject job postings and applications
- **Employer Dashboard**: Manage job postings and applicant tracking
- **Responsive Design**: Mobile-friendly interface for all devices
- **Notifications**: Email and in-app notifications for application updates

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional, for dependency management)

## Installation

1. **Clone the repository**
    - For XAMPP users, clone the repository to the `huntly` directory

2. **Set up your web server**
    - Configure your web server to point to the public directory as the document root

3. **Create the database**
    - Create a MySQL database named `huntly`
    - Import the database structure from `huntly.sql`

4. **Configure the application**
    - Open `config.php`
    - Update the database credentials and site URL if necessary

5. **Set proper permissions**
    - Ensure the `uploads` directory and its subdirectories are writable by the web server

## Usage

### Access the website
- Open your web browser and navigate to `http://localhost/huntly/public/`

### Admin Login
- URL: `http://localhost/huntly/admin/login`
- Default credentials:
  - Email: `admin@huntly.com`
  - Password: `admin123`

### Employer Login
- URL: `http://localhost/huntly/auth/`
- Select the "Employer" tab
- You can register a new employer account or use:
  - Email: `tiki@example.com`
  - Password: `admin123`

### Job Seeker Login
- URL: `http://localhost/huntly/auth/`
- Select the "Job Seeker" tab
- You can register a new job seeker account or use:
  - Email: `user1@example.com`
  - Password: `abcd1234@`

## Project Structure

### Key Files
- `index.php`: The main entry point for the application
- `config.php`: Configuration settings
- `Controller.php`: Base controller class
- `Model.php`: Base model class
- `HomeController.php`: Handles public pages
- `AdminController.php`: Handles admin functionality
- `EmployerController.php`: Handles employer functionality
- `JobController.php`: Handles job listing and application functionality

## Environment Setup

1. Copy `app/config/env.sample.php` to `app/config/env.php`
2. Update `env.php` with your actual Google OAuth credentials:
   - Get credentials from the Google Developer Console
   - Set authorized redirect URI to `http://localhost/huntly/auth/googlecallback`

## Dependencies and Setup

### Composer Dependencies

This project uses Composer to manage PHP dependencies. If you encounter errors related to missing vendor files:

1. Install Composer:

   - Download from [getcomposer.org](https://getcomposer.org/download/)
   - Follow installation instructions for your operating system

2. Install dependencies:

   ```bash
   cd /path/to/huntly
   composer require google/apiclient:"^2.0"
   ```

3. If you encounter memory limit issues:

   ```bash
   php -d memory_limit=-1 /path/to/composer.phar install
   ```

4. Update dependencies:
   ```bash
   composer update
   ```