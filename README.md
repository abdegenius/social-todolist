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
```

## 🔐 Authentication
All authenticated routes use the Authorization: Bearer <token> header after logging in.

## 📡 API Endpoints


## 🔐 Auth Routes
```bash
Method	Endpoint	Description
POST	/api/register	Register a new user
POST	/api/login	Login and get JWT
```

## 👤 User Routes
```bash
Method	Endpoint	Description
GET	/api/users/profile	Get authenticated user
POST	/api/users/logout	Logout the user
```

## 📁 Todo Lists
```bash
Method	Endpoint	Description
GET	/api/todos	List all todos
POST	/api/todos	Create new todo list
GET	/api/todos/{id}	Show a specific todo list
DELETE	/api/todos/{id}	Delete a todo list
```

## 📝 Todo Items
```bash
Method	Endpoint	Description
POST	/api/todos/{todo}/items	Add item to a todo list
PUT	/api/items/{item}	Update a todo item
DELETE	/api/items/{item}	Delete a todo item
```

## 🔍 User Search
```bash
Method	Endpoint	Description
GET	/api/users/search	Search by username(partial)
GET	/api/users/complete-search	Complete username search
```

## 🤝 Todo Access & Invitations
```bash
Method	Endpoint	Description
POST	/api/todos/{todo}/invite	Invite a user to a todo list
PUT	/api/accesses/{access}	Accept or reject an invitation
GET	/api/invitations	List of user's invitations
```

## 📊 Dashboard Summary
```bash
Method	Endpoint	Description
GET	/api/dashboard-summary	Get total, pending, completed todos
```

## 🎨 UI & UX Enhancements

TailwindCSS: Modern and utility-first styling

Toastr: Clean toast notifications

Alpine.js: Lightweight frontend interactivity

Font Awesome: Icons for buttons and indicators

📄 License
This project is open-source and available under the MIT License.

## 👨‍💻 Author
- Johnnie B. Abijah
- GitHub: @abdegenius
- Email: abijahjohnnie@gmail.com

