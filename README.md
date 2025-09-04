# InstaClone - A Simple Social Media Platform

InstaClone is a web application built with Laravel that mimics a simple social media platform. It allows users to create profiles, upload posts with images and captions, and interact with other users' posts by liking and commenting.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

-   **User Authentication**: Secure user registration and login.
-   **User Profiles**: Customizable user profiles with a name, username, bio, and profile picture.
-   **Post Management**: Create, edit, and delete posts with images and captions.
-   **Interactions**: Like or unlike posts and add comments.
-   **Feed**: A central feed to view posts from all users.

## Tech Stack

-   **Backend**: PHP, Laravel
-   **Database**: MongoDB
-   **Frontend**: Blade, JavaScript, CSS

## Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Make sure you have the following software installed on your system:

-   PHP (>= 8.2)
-   Composer
-   Node.js & npm
-   MongoDB

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/your-repository-name.git
    cd your-repository-name
    ```

2.  **Install backend dependencies:**
    ```bash
    composer install
    ```

3.  **Install frontend dependencies:**
    ```bash
    npm install
    ```

4.  **Set up your environment file:**
    -   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    -   Generate an application key:
        ```bash
        php artisan key:generate
        ```

5.  **Configure your `.env` file:**
    Open the `.env` file and update the following settings, especially your database credentials:
    ```
    DB_CONNECTION=mongodb
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=photosphere
    DB_USERNAME=
    DB_PASSWORD=
    ```

6.  **Run the database migrations:**
    This will create the necessary collections in your MongoDB database.
    ```bash
    php artisan migrate
    ```

7.  **Compile frontend assets:**
    ```bash
    npm run dev
    ```

8.  **Start the development server:**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

## Usage

-   **Register/Login**: Create a new account or log in with existing credentials.
-   **Update Profile**: Navigate to your profile to edit your name, bio, and profile picture.
-   **Create a Post**: Click the "New Post" button to upload an image and add a caption.
-   **Interact**: Browse the feed on the homepage, click on a post to view details, and leave likes or comments.

## Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
