# Employee Attendance Management System

[cite_start]A full-stack web application developed during my internship at Digisnare Technologies[cite: 16]. This system provides a comprehensive solution for tracking daily employee attendance, with separate portals for employees and administrators.

## Key Features

- [cite_start]**Dual User Portals:** Secure and distinct login pages for both regular employees and administrators. [cite: 17]
- [cite_start]**Admin Dashboard:** A central control panel for administrators with full CRUD (Create, Read, Update, Delete) functionality for managing employee records. [cite: 19, 20]
- [cite_start]**Time-Slot Restricted Check-in:** Employees can only log their attendance within specific, managed time slots. [cite: 18]
- [cite_start]**Robust Reporting:** Features for viewing monthly attendance records and searching for specific employees. [cite: 21]
- [cite_start]**Data Export:** Functionality to download complete attendance data as a CSV file for record-keeping and analysis. [cite: 21]
- **Secure Password Handling:** Implemented one-way password hashing using `bcrypt` to ensure user credentials are stored securely in the database.

## Technologies Used

- [cite_start]**Frontend:** HTML, CSS, JavaScript [cite: 23]
- [cite_start]**Backend:** PHP [cite: 23]
- [cite_start]**Database:** MySQL [cite: 23]

## Project Structure

A brief overview of the key files in this repository:

- `db.php`: Handles the connection to the MySQL database.
- `login.php`: Manages the user authentication process.
- `admin_home.php`: The main dashboard for the administrator.
- `employee_home.php`: The main dashboard for the employee.
- `add_employee.php`, `edit_employee.php`, `delete_employee.php`: Scripts for managing employee data.
- `check_in.php`, `check_out.php`: Scripts to handle employee attendance logging.
- `monthly_report.php`: Generates and displays the monthly attendance report.
- `rehash_passwords.php`: A utility script to update existing passwords to a secure hashed format.
