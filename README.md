# Expense Tracker with Monthly Report

A simple **Laravel 12-based** Expense Management system allowing users to track their expenses, categorize them, and visualize monthly summaries with charts.

---

## ✨ Features

- **User authentication** (login, registration, forgot password).
- **Manage expenses**:
  - Add, view, and filter expenses by category, month, and year.
  - Group expenses by category with totals and counts.
- **Dashboard** with:
  - Expense charts (using **Chart.js**) by category and month.
  - Quick filtering by date and category.
- **Dynamic, reusable table components** for displaying expenses or categories.
- **Pagination and search** functionality.
- **Seeded users** for testing with password autofill on login.
- **Mail support** for notifications, such as password resets.

---

## 💻 Requirements

- **PHP** >= 8.2
- **Composer**
- **MySQL** / **MariaDB**

---

## 🚀 Installation

1.  **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd <project-folder>
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Set up environment file:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Update `.env` with your database and mail credentials:**

    ```makefile
    # Database Configuration
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=expense_db
    DB_USERNAME=root
    DB_PASSWORD=

    # Mail Configuration
    MAIL_MAILER=smtp
    MAIL_HOST=127.0.0.1
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

5.  **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

    > This will create all necessary tables and seed predefined users (password for all seeded users: `12341234`).

6.  **Run the project locally:**

    ```bash
    php artisan serve
    ```

    > Visit `http://127.0.0.1:8000` in your browser.

---

## 👥 Seeded Users

The project comes with predefined users for testing purposes. On the login page, you can use the autofill button to quickly log in with a random user.

| Name             | Email                 | Password |
| ---------------- | --------------------- | -------- |
| John Doe         | john@example.com      | 12341234 |
| Jane Smith       | jane@example.com      | 12341234 |
| Bob Johnson      | bob@example.com       | 12341234 |
| Alice Williams   | alice@example.com     | 12341234 |
| Charlie Brown    | charlie@example.com   | 12341234 |
| David Wilson     | david@example.com     | 12341234 |
| Emma Davis       | emma@example.com      | 12341234 |

---

## 🛠️ Usage

After logging in, you will see the **dashboard** with:

- A chart visualizing monthly expenses by category.
- Filters by year, month, and category.

Navigate to the **Expenses** page to:

- View the expense list (with pagination and search).
- Add new expenses via a modal form.
- View grouped expenses by category with an expandable accordion for category-specific details.

---

## 📂 Project Structure Highlights

- `app/Models` – Eloquent models for `User`, `Expense`, and `Category`.
- `app/Services` – Service classes for handling business logic.
- `app/Http/Controllers` – Controllers for the user dashboard and expenses.
- `app/Http/Resources` – API resource classes for `Expense` and `Category`.
- `resources/views/user` – Blade templates for the dashboard, expenses, and table components.
- `database/seeders` – Seeders, including `UserSeeder`, to populate test users.
- `config/settings.php` – Custom pagination and other settings.
- `config/users.php` – Predefined users for seeding.

---

## 📝 Notes

- Expenses are filtered by user, year, month, and category.
- Dynamic tables handle different columns and data types.
- The system is configured for mail support, which is used for features like the "forgot password" functionality.