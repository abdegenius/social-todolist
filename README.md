# 📝 Laravel Social Todo List

A modern, collaborative todo list application built with **Laravel**, **TailwindCSS**, **Alpine.js**, **Axios**, and **Toastr**. This app allows users to create and manage personal todo lists, invite others, track status (pending, completed), and collaborate efficiently — all with real-time feedback and an intuitive UI.

---

## 🚀 Features

- ✅ User Registration & Authentication (JWT)
- ✅ Create & manage Todo Lists
- ✅ Share todo access with others (Collaborative Access)
- ✅ Realtime UI feedback with Toastr
- ✅ Responsive UI with TailwindCSS
- ✅ Interactive components using Alpine.js
- ✅ Clean API structure using Laravel Controllers & Resources

---

## 🧰 Tech Stack

- **Backend:** Laravel 10+
- **Frontend:** TailwindCSS, Alpine.js, Toastr
- **Auth:** JWT (JSON Web Tokens)
- **Database:** MySQL / SQLite / PostgreSQL (any Laravel-supported DB)
- **API:** RESTful with API Resources

---

## 📦 Installation & Setup

Follow these steps to get the app running locally:

```bash
# 1. Clone the repository
git clone https://github.com/abdegenius/social-todolist.git
cd social-todolist

# 2. Install PHP dependencies
composer install

# 3. Create .env file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Set up your database credentials in `.env`

# 6. Run migrations
php artisan migrate

# 7. Generate JWT secret
php artisan jwt:secret

# 8. Install frontend dependencies
npm install

# 9. Compile assets
npm run dev

# 10. Serve the application
php artisan serve
