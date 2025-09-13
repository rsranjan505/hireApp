# Hire – Recruitment Management System

Hire is a recruitment management platform built with **Laravel 12** (backend) and **Vue 3** (frontend).  
It provides a smooth user experience using **Inertia.js**, **Vite**, and **TailwindCSS**.

## 🚀 Features

- 🔐 **Authentication** – Signup & Sign-in process
- 👤 **Role-based Access** – Users can be:
  - **Admin** – manage candidates, questions, reports
  - **Candidate** – participate in interviews, upload answers
- 🎥 **Video Answering** – Candidates can record and upload video responses
- 📊 **Reports** – Admins can review answers with comments & scores

---

## 🛠️ Tech Stack

### Backend
- [Laravel 12](https://laravel.com)
- PHP 8.2

### Frontend
- [Vue.js 3.5.13](https://vuejs.org/) with **TypeScript**
- [Inertia.js Vue 3 – ^2.1.0](https://inertiajs.com/)
- [Vite – ^5.4.20](https://vitejs.dev/)
- [TailwindCSS – ^4.1.1](https://tailwindcss.com/)
- [Lucide Vue Next – ^0.468.0](https://lucide.dev/)
- [VueUse – ^12.8.2](https://vueuse.org/)

### Dev Tools
- ESLint – ^9.17.0
- Prettier – ^3.4.2
- TypeScript – ^5.2.2
- Vue TSC – ^2.2.4

---

## ⚙️ Installation

### 1️⃣ Clone the repository

git clone https://github.com/rsranjan505/hireApp.git
cd hire



# Backend setup (Laravel)
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate 
php artisan serve

# Frontend setup (Vue + Vite)
npm install
npm run dev

# User Roles

# Admin

    Manage candidates

    Review interview answers

    Give scores & feedback

# Candidate

    Sign up & complete profile

    Record & upload video answers

    View interview results


# Demo Workflow
1️⃣ Candidate Signup & Login

Candidate creates an account and logs in.


2️⃣ Candidate Dashboard – View Questions

Candidates see available interview questions.


3️⃣ Record & Submit Video Answer

Candidate records an answer and uploads it.


4️⃣ Admin Dashboard – Review Answers

Admin reviews candidate answers (video + text).


5️⃣ Admin Scoring 

Admin submits score & comments.


#note :: i have also add question assign, but implementation is missing due to time bound
