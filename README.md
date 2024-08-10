<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# GoogleOneTapSignIn

## Description

This project provides a simple integration of Google One Tap sign-in for Laravel applications. Users can quickly and securely log in using their Google account with just one tap.

## Getting Started

Follow these steps to clone and set up the project:

### 1. Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/mitranoliya/GoogleOneTapSignIn.git
```

### 2. Navigate to the Project Directory

Change to the project directory:

```bash
cd GoogleOneTapSignIn
```

### 3. Install Dependencies

Install the required dependencies using Composer:

```bash
composer install
```

### 4. Set Up Environment Variables

Copy the .env.example file to a new .env file:

```bash
cp .env.example .env
```

### 5. Configure Google Credentials

-   Go to the [Google Cloud Console](https://console.cloud.google.com/).
-   Create a new project or select an existing one.
-   Navigate to APIs & Services > Credentials and create new OAuth 2.0 Client IDs.
-   Add your application's URL (e.g., http://localhost:8000) to the authorized JavaScript origins.
-   Set up the redirect URIs if necessary.
-   Copy the Client ID and update the .env file with the GOOGLE_CLIENT_ID value.

### 6. Update the Client ID

In the project directory, open the `.env` file and add the following lines:

```bash
GOOGLE_CLIENT_ID=YOUR_CLIENT_ID
```

### 7. Generate Application Key

Generate a new application key using the following command:

```bash
php artisan key:generate
```

### 8. Run Migrations

Run the database migrations:

```bash
php artisan migrate
```

### 9. Start the Laravel Development Server

Run the Laravel development server:

```bash
php artisan serve
```

### Contributing

Contributions are welcome! If you find any issues or have improvements, please open an issue or submit a pull request.
