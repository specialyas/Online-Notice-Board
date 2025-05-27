
# E-Notice Board System

## 📘 Project Overview

The **E-Notice Board System** is a web-based platform designed to streamline communication within Ahmadu Bello University. It enables administrators to publish important announcements digitally, making them instantly accessible to students and staff from any device, anytime.

---

## 🚀 Key Features

### 👨‍💼 Admin Dashboard
- Secure login for administrators.
- Dashboard displays total registered users and published notices.

### 👥 User Management
- View all registered users.
- Update or delete user profiles.

### 📢 Notice Management
- Add new notices (e.g., events, holidays, exams).
- Edit or delete notices.
- Notices include subject, description, date, and author info.

### 👨‍🎓 User Access
- Register and log in securely.
- View all notices in a user-friendly layout.
- Update profile and profile picture.

### 🔐 Security
- Only authenticated admins can manage users or notices.
- Passwords are hashed for secure storage.

---

## 🌟 Benefits

- **Paperless Communication**: Eliminates physical notice boards.
- **Real-time Updates**: Publish and view announcements instantly.
- **Accessibility**: Access notices remotely from any device.
- **User-Friendly Design**: Simple and intuitive interface.

---

## ⚙️ How It Works

1. **Admin Login**: Admins sign in using secure credentials.
2. **Posting Notices**: Admins create notices via a submission form.
3. **Viewing Notices**: Students and staff log in to view published notices.
4. **User & Notice Management**: Admins manage all content and users from their dashboard.

---

## 🔗 Access Points

- **Admin Portal**: [`http://localhost/OnlineNoticeBoardSystem/admin/index.php`](http://localhost/OnlineNoticeBoardSystem/admin/index.php)
- **User Portal**: [`http://localhost/OnlineNoticeBoardSystem/index.php`](http://localhost/OnlineNoticeBoardSystem/index.php)

---



## 🔧 Installation & Setup

1. **Clone the Repository**
   \`\`\`bash
   git clone https://github.com/your-username/specialyas-online-notice-board.git
   \`\`\`

2. **Install Dependencies**
   Make sure you have PHP and Composer installed. Run:
   \`\`\`bash
   composer install
   \`\`\`

3. **Set Up Database**
   - Import the SQL file (if provided) into your local MySQL server.
   - Update `/db/connection.php` with your database credentials.

4. **Configure Environment Variables**
   Create a `.env` file or manually configure:
   \`\`\`env
   DB_HOST=localhost
   DB_USER=your_db_user
   DB_PASSWORD=your_db_password
   DB_NAME=your_database_name
   \`\`\`

5. **Run Locally**
   - Start your local server (e.g., XAMPP or Laragon).
   - Visit: `http://localhost/OnlineNoticeBoardSystem/index.php`

---

## 🔑 Authentication & Roles

- **Users**: Can view notices and edit profile.
- **Admins**: Can add/edit/delete users and notices.

---

## 📌 Notes

- Images are organized by user email in the `/images` folder.
- Passwords are securely stored using PHP password hashing.

---

## 📃 License

This project is for academic and educational purposes.

---

## 🙋‍♂️ Author

**Yusuf A. Sani**  
Computer Science Student – Ahmadu Bello University  
📧 Email: holla2specialyusuf@gmail.com
