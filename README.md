# 📚 Library Management System (PHP + MySQL)

This is a web-based Library Management System built using **PHP**, **MySQL**, and **HTML/CSS**. It supports book management, user registrations, issuing/returning books, and activity logging using SQL triggers.

---

## 📁 Folder Structure
```
:\xampp\htdocs\LIBRARY\
│
├── dashboard\              # Main dashboard UI
│   ├── css\                # Dashboard styles
│   └── dashboard.html      # Dashboard page
│
├── database\               # PHP files for DB operations
│
├── home\                   # Home page UI
│
├── login\                  # Login page UI and logic
│
├── signup\                 # Signup/registration page
│
├── SQL\                    # SQL schema & triggers
│   └── commands.sql   
```

---

## ⚙️ Features

- 📖 Book Management (add, issue, return)
- 👨‍💼 Staff Authentication
- 🧑‍💼 Customer Registration
- 📚 Borrowing Limit (3 books per customer)
- 🔁 Auto update of book availability
- 🧾 Logging of transactions (borrowing/returning)
- 🕵️‍♂️ Triggers ensure rules are followed at DB level

---

## 🛠️ Setup Instructions

### Step 1: Clone or Download Project

```bash
git clone https://github.com/HARDIK-JINDAL/library-management-web-app.git
```
Place the project folder inside:```C:\xampp\htdocs\LIBRARY\```

### Step 2: Start Apache & MySQL

- Open XAMPP Control Panel
- Start Apache and MySQL

### Step 3:  Import SQL Schema

- Open phpMyAdmin ```http://localhost/phpmyadmin/```
- Click Import
- Select the file: ```C:\xampp\htdocs\LIBRARY\SQL\commands.sql```
- Click Go

This will create the database LibraryManagement with all tables and triggers.

### Step 4:  Configure Database Connection:
- in the dp.php files , add your credentials

## 🖥️ Access the App
Once everything is set:

Visit http://localhost/LIBRARY/home
(or navigate to your home directory depending on your index page)

## ✨ Credits

Developed by Hardik Jindal
Powered by PHP + MySQL + HTML/CSS
