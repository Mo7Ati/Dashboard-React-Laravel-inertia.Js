
# MultiVendor Laravel + React + Inertia.js

This is a multi-vendor e-commerce platform built using **Laravel**, **React.js**, and **Inertia.js**, providing a seamless SPA experience with a robust backend and dynamic frontend.

## 🚀 Features

- Laravel 11 backend
- React.js with Inertia.js frontend
- Role-based access control
- Multi-vendor management system
- Dashboard for administrators and vendors

## 🛠 Installation Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/Mo7Ati/MultiVendor-React-Laravel-inertia.Js.git
   cd MultiVendor-React-Laravel-inertia.Js
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your database** in `.env`

5. **Run migrations**
   ```bash
   php artisan migrate --seed
   ```

6. **Run the development server**
   ```bash
   php artisan serve
   npm run dev
   ```

## 🔐 Accessing the Admin Dashboard

To access the admin dashboard:

- Visit: [http://localhost:8000/admin/dashboard](http://localhost:8000/admin/dashboard)
- Use the following default super admin credentials:

```
Email: admin@ps.com
Password: password
```

> **Note:** The default user `admin@ps.com` has full super admin privileges and can manage all aspects of the platform including users, roles, permissions, stores, products, and more.

## 📁 Project Structure Highlights

- `resources/js/` – React components and pages
- `routes/web.php` – Laravel routes
- `app/Http/Controllers/` – Backend controllers
- `resources/views/app.blade.php` – Inertia root Blade file

---

## 🧪 Contributing

Feel free to fork this repository and submit pull requests. Contributions are welcome!

## 📄 License

This project is open-sourced under the MIT license.
