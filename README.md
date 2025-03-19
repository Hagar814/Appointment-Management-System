# Appointment Management System

## Tech Stack

- **Backend**: Laravel 11.x (PHP Framework)
- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **API**: RESTful API for CRUD operations (Appointments, Doctors, Patients, Admin)
- **Version Control**: Git, GitHub
- **Deployment Environment**: Localhost (you can specify if deployed on a live server)

### Specific Libraries and Versions
- Laravel Framework: 11.x
- Laravel Sanctum: ^2.11
- PHP: ^8.4
- Composer: ^2.0
- Mewebstudio/Captcha: ^4.0 (if used for Captcha)
- Google reCAPTCHA: Optional for login form validation

## Project Setup

### Prerequisites
- PHP >= 8.4
- Composer >= 2.x
- MySQL or any other database
- Node.js and npm (for managing front-end assets)

### Steps to Set Up Locally

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Hagar814/Appointment-Management-System.git
   
2. **install dependecies**:
install Breeze API
composer requir laravel/sactum
composer require saprie/laravel-permission
composer require mews/captcha

3. **in file .env**:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

3. **Generate application key**:
php artisan key:generate

3. **Run database migrations and seed the database**:
php artisan migrate --seed

3. **Serve the application**:
Serve the application

3. **Access the application**:
Open your browser and go to http://127.0.0.1:8000
->Authentication Notes
Admin login: Visit /login/admin to log in as an admin.
Doctor login: Visit /login/doctor to log in as a doctor.
Patient login: Visit /login/patient to log in as a patient.
->API Endpoints

POST    	/login/admin	                Admin login
GET	        /admin/doctors	                Retrieve all doctors
POST    	/admin/doctor/add	            Add a doctor
PUT     	/admin/doctor/update/{id}	    Update a doctor's information
DELETE	    /admin/doctor/delete/{id}	    Delete a doctor
GET	        /admin/patients	                Retrieve all patients
POST        /admin/patient/add	            Add a patient
PUT	        /admin/patient/update/{id}  	Update a patient's information
DELETE  	/admin/patient/delete/{id}	    Delete a patient
GET     	/patient/{id}/appointments	    Retrieve a patient's appointments
POST	    /doctor/appointments/{id}/status	Update an appointment status

**Approach**:
I started by breaking the project into its core components: authentication, doctor management, patient management, and appointment scheduling. I used Laravel Sanctum for authentication and session management, and created separate login forms for admins, doctors, and patients.

One of the main challenges was ensuring that each user (admin, doctor, or patient) only had access to the routes and resources appropriate for their role. Another important aspect was handling appointment scheduling conflicts, ensuring that patients could only book available slots and preventing double-booking.

I enjoyed working with Laravel Sanctum for API authentication as it provided a clean and simple solution for token-based authentication.

**Challenges Faced**:
Multi-user login management: Handling separate logins for different roles required careful planning of routes, middleware, and guards.
Managing time slots for appointments: Ensuring that appointments were not double-booked required extra validation logic.

**Pending Work**:
Advanced Validation: Adding Google reCAPTCHA or another form of captcha on the login forms for added security.
