# 🚀 Job Board API System

A professional, secure, and high-performance Backend API for a Job Board platform, built with Laravel. It supports role-based access for Employers and Candidates with automated notifications and background processing.

## ✨ Key Features
- **Authentication:** Secure login/register system using Laravel Sanctum.
- **Role-Based Access Control (RBAC):** Distinct functionalities for 'Employer' and 'Candidate'.
- **Job Management:** Full CRUD for vacancies with ownership protection.
- **Application System:** Candidates can apply for jobs; Employers can accept/reject applications.
- **Notifications:** Real-time email and database alerts powered by Laravel Notifications.
- **Security:** Strict authorization using Laravel Policies to prevent unauthorized data access.
- **Performance:** Optimized database queries with Eager Loading to solve N+1 issues.

## 🛠 Tech Stack
- **Framework:** Laravel 12.x
- **Database:** MySQL
- **Tooling:** Postman (API Documentation), Mailtrap (Email Testing)
- **Architecture:** API Resources, Form Requests, Policies, and Service-oriented approach.

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Yusufxon790/job-board-api.git](https://github.com/Yusufxon/job-board-api.git)

2. **Install dependencies:**
   ```bash
   composer install

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   #Update DB_DATABASE, MAIL_USERNAME, MAIL_PASSWORD etc. in .env

4. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate

5. **Link Storage:**
   ```bash
   php artisan storage:link

6. **Run the Server:**
   ```bash
   php artisan serve

## 📖 API Documentation
# The API is fully documented using a Postman Collection.

**To use the documentation:**
1. Navigate to the `docs/` folder.
2. Import `Job Board API.postman_collection.json` into your Postman application.
3. Set the `baseUrl` environment variable to `http://localhost/api`.
4. All requests include Examples for success and error responses.

## 👨‍💻 Author
- [MuhammadYusuf Akramov](https://github.com/Yusufxon790)  
- 📧 Email: akramovyusufxon590@gmail.com  