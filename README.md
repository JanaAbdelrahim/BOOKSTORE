#  Book Store

A web-based bookstore application built with **PHP** using the MVC (Model-View-Controller) architecture. The project is designed to organize books, authors, categories, users, and orders through a structured and maintainable codebase.

## ✨ Features

- **Authentication:** User login and registration.
- **Books Management:** Browse books and view book details.
- **Authors & Categories:** Organize books by authors and categories.
- **User Profile:** Manage user profile information.
- **Order Management:** Handle customer orders and order items.
- **Admin Dashboard:** Manage books, users, and orders.
- **MVC Architecture:** Separate controllers, models, views, and core application logic.

##  Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Apache
- MVC Architecture

## 📁 Project Structure

```text
book-store/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│       ├── layouts/
│       ├── home/
│       ├── auth/
│       ├── books/
│       ├── profile/
│       └── admin/
├── core/
│   ├── App.php
│   ├── Controller.php
│   ├── Database.php
│   └── Model.php
├── config/
│   └── config.php
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── assets/
│   └── uploads/
│       └── books/
└── routes/
    └── web.php
```

## ⚙️ Installation & Setup

### Prerequisites

Make sure you have the following installed:

- PHP 8.0 or later (or the version required by your project).
- MySQL.
- Apache server, such as XAMPP or Laragon.
- Git (optional).

### Steps

1. **Clone the repository**

   ```bash
   git clone <YOUR_REPOSITORY_URL>
   ```

2. **Move into the project directory**

   ```bash
   cd book-store
   ```

3. **Configure the database**

   - Create a MySQL database for the project.
   - Update the database connection settings in `config/config.php`.
   - Import the database schema and required data if an SQL file is provided.

4. **Configure the web server**

   Configure Apache to serve the project through its `public/` directory.

   Make sure URL rewriting is enabled if your application relies on `.htaccess`.

5. **Run the application**

   Open the local URL configured for your project in your browser.

## 🗂️ Main Components

| Component | Responsibility |
|---|---|
| `app/controllers/` | Handle requests and application logic |
| `app/models/` | Manage data and database interactions |
| `app/views/` | Render the user interface |
| `core/` | Provide core MVC functionality |
| `config/` | Store application configuration |
| `public/` | Entry point and public assets |
| `routes/` | Define application routes |

## Security Notes

- Do not commit database passwords or other secrets.
- Keep private configuration files out of public repositories.
- Validate and sanitize user input.
- Use secure password hashing.
- Validate uploaded files before storing them.

##  Future Improvements

- Add online payment integration.
- Implement book search, filtering, and pagination.
- Add product reviews and ratings.
- Improve responsive design.
- Add automated testing.

##  Author

**Jana Abdelrahim**

---

*This project was developed as a web application project to practice PHP, database integration, and MVC architecture.*
