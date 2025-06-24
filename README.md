# Teacher Appointment System

A full-stack web application for managing appointments between students and teachers, built with **Vue 3** on the frontend and **Laravel (PHP)** on the backend.

---

## Project Overview

This system allows:

- Students and teachers to register and log in.
- Role-based access to different views (student, teacher, admin).
- Students to view and book appointments with teachers based on their available schedules.
- Teachers to view, approve, or reject appointment requests.
- Admins to manage all users (students and teachers), view details, and remove users.
- Authentication and authorization with Laravel Sanctum API tokens.

---

## Technologies Used

- **Frontend:**
  - Vue 3 (Composition API, `<script setup>`)
  - Axios for HTTP requests
  - Tailwind CSS for styling

- **Backend:**
  - Laravel 8+ (API with Sanctum for authentication)
  - MySQL for database
  - Eloquent ORM for models and relationships

---

## Key Features

- **User Roles:** Student, Teacher, Admin with role-based rendering on frontend.
- **Authentication:** Laravel Sanctum token-based login and registration.
- **Dynamic Forms:** Signup form adapts based on role selected (student/teacher).
- **Appointments:**
  - Students can view, book, and see appointment statuses.
  - Teachers can view appointment requests and approve/reject them.
- **Admin Panel:** View all users, show detailed info with appointments, and remove users.
- **Clean UI:** Responsive and consistent styling using Tailwind CSS.

---

## Project Structure

- **Frontend (Vue):**
  - `LoginForm.vue`, `SignupForm.vue`
  - Views: `StudentView.vue`, `TeacherView.vue`, `AdminView.vue`
  - Components for appointments, booking modals, user detail modals
  - Central state for auth token and user data stored in `localStorage`

- **Backend (Laravel):**
  - Models: `User`, `Student`, `Teacher`, `Appointment`, `Schedule`
  - Controllers: `AuthController`, `RegisterController`, `AppointmentController`, `ScheduleController`, `StudentController`, `TeacherController`
  - API Routes protected with Sanctum middleware
  - Relationships in models to fetch related data (e.g., User → Student or Teacher, Appointment → Teacher and Student)

---

## Getting Started

### Prerequisites

Make sure you have the following installed on your machine:

- PHP >= 7.4
- Composer (PHP package manager)
- Node.js and npm (Node package manager)
- MySQL Server
- Git

---

### Backend Setup

1. **Clone the backend repository:**

   ```bash
   git clone https://github.com/yourusername/teacher-appointment-backend.git
   cd teacher-appointment-backend
  ```

HAPPY CODING !!