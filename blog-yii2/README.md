# Blog Yii2 Application

Simple blog management system built with Yii2 Framework featuring role-based access control.

## 🚀 Quick Start

### Default Login Accounts

After installation, you can login with these pre-configured accounts:

#### 👨‍💼 Admin Account
- **Username:** `admin`
- **Password:** `admin`
- **Permissions:** 
  - ✅ Full access to all blog posts (create, read, update, delete)
  - ✅ User account management (create, update, delete users)
  - ✅ Admin dashboard access
  - ✅ Can manage all users and posts

#### ✍️ Author Account  
- **Username:** `author`
- **Password:** `author`
- **Permissions:**
  - ✅ Manage own blog posts only (create, read, update, delete)
  - ❌ Cannot access user management
  - ✅ Author dashboard access
  - ❌ Cannot manage other users' posts

## 🛠️ Installation & Setup

1. **Start the development server:**
   ```bash
   cd c:\Users\AsusTuf\Videos\project\blog-yii2
   php -S localhost:8000 -t web
   ```

2. **Access the application:**
   - Open your browser and go to: `http://localhost:8000`

3. **Login:**
   - Click "Login" button in the navigation
   - Use one of the accounts above

## 📋 Features

- **🔐 Role-based Authentication System**
- **📝 Blog Post Management** with CRUD operations
- **👥 User Account Management** (Admin only)
- **📱 Responsive Design** with Bootstrap 5
- **🎨 Clean & Professional UI**
- **🔒 Secure Password Hashing**
- **✅ Form Validation**
- **💬 Flash Messages for User Feedback**

## 🏗️ Project Structure

```
blog-yii2/
├── controllers/         # Application controllers
│   ├── AccountController.php  # User management (Admin only)
│   ├── PostController.php     # Blog post CRUD operations
│   └── SiteController.php     # Login, homepage
├── models/             # Data models
│   ├── Account.php     # User authentication model
│   ├── Post.php        # Blog post model
│   └── LoginForm.php   # Login form validation
├── views/              # View templates
│   ├── layouts/main.php    # Main layout with navigation
│   ├── post/              # Post management views
│   ├── account/           # Account management views
│   └── site/              # Login, homepage views
├── web/               # Web accessible files
│   └── css/custom.css # Custom styling
└── migrations/        # Database structure
```

## 🎯 How to Use

### As Admin (admin/admin):
1. Login with admin credentials
2. Access "Manage" → "Manage Accounts" to create/edit users
3. Create new blog posts or edit any existing posts
4. Delete any posts or users as needed

### As Author (author/author):
1. Login with author credentials  
2. Access "Manage" → "My Posts" to see your posts
3. Create new blog posts via "Create New Post"
4. Edit or delete only your own posts

## 🔧 Technologies Used

- **Backend:** PHP 8.2+, Yii2 Framework
- **Database:** MySQL (blog_yii2)
- **Frontend:** Bootstrap 5, HTML5, CSS3
- **Authentication:** Yii2 built-in with password hashing
- **Server:** PHP Development Server

