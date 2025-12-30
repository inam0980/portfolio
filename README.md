# 🎨 Professional Portfolio Website

A fully dynamic, professional portfolio website built with HTML5, CSS3, JavaScript, PHP (PDO), and MySQL. Features a complete admin panel for managing content, secure authentication, and responsive design.

## ✨ Features

### Frontend
- **Modern, Responsive Design** - Works perfectly on desktop, tablet, and mobile
- **Professional UI/UX** - Clean color palette and typography
- **SEO-Friendly** - Semantic HTML and optimized structure
- **Smooth Animations** - CSS and JavaScript animations
- **Dynamic Content** - All content fetched from MySQL database

### Pages
- **Home** - Hero section with name, role, tagline, and CTA
- **About Me** - Bio, career objective, profile image, experience timeline
- **Skills** - Categorized skills (Programming, Data, Tools) with animated progress bars
- **Recent Projects** - Latest 3-4 featured projects
- **All Projects** - Complete filterable project list
- **Certifications** - Courses and certifications with providers
- **Contact** - Form with validation that saves to database

### Admin Panel
- **Secure Login** - Password hashing with bcrypt
- **Dashboard** - Statistics and quick actions
- **Project Management** - CRUD operations with image upload
- **Skills Management** - Add/delete skills by category
- **Certifications Management** - Add/delete certifications
- **Message Management** - View and manage contact form submissions
- **Mark as Recent** - Feature projects on homepage

### Security Features
- ✅ PDO with prepared statements (SQL injection prevention)
- ✅ Password hashing (bcrypt)
- ✅ Input validation and sanitization
- ✅ XSS protection with htmlspecialchars()
- ✅ CSRF protection ready
- ✅ Session management
- ✅ File upload validation

## 📁 Folder Structure

```
portfolio/
├── index.php                    # Home page
├── about.php                    # About page
├── skills.php                   # Skills page
├── recent-projects.php          # Recent projects page
├── projects.php                 # All projects page
├── certifications.php           # Certifications page
├── contact.php                  # Contact page
├── database.sql                 # Database schema & sample data
├── README.md                    # This file
│
├── config/
│   └── db.php                   # Database configuration
│
├── admin/
│   ├── login.php                # Admin login
│   ├── dashboard.php            # Admin dashboard
│   ├── auth.php                 # Authentication helper
│   ├── header.php               # Admin header
│   ├── footer.php               # Admin footer
│   ├── projects.php             # Manage projects
│   ├── add-project.php          # Add new project
│   ├── edit-project.php         # Edit project
│   ├── skills.php               # Manage skills
│   ├── certifications.php       # Manage certifications
│   └── messages.php             # View contact messages
│
└── assets/
    ├── css/
    │   └── style.css            # Main stylesheet
    ├── js/
    │   └── main.js              # Main JavaScript
    └── images/
        ├── projects/            # Project images (auto-created)
        └── profile.jpg          # Your profile photo
```

## 🚀 Installation Guide

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- phpMyAdmin (optional but recommended)

### Local Installation (XAMPP/WAMP/MAMP)

1. **Download and Install XAMPP/WAMP/MAMP**
   - Download from official website
   - Install and start Apache and MySQL

2. **Clone/Extract Files**
   ```bash
   # Place files in your web server directory
   # XAMPP: C:/xampp/htdocs/portfolio
   # WAMP: C:/wamp64/www/portfolio
   # MAMP: /Applications/MAMP/htdocs/portfolio
   ```

3. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click "New" to create a database
   - Name it: `portfolio_db`
   - Click on the database
   - Go to "Import" tab
   - Select `database.sql` file
   - Click "Go" to import

4. **Configure Database Connection**
   - Open `config/db.php`
   - Update these values if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'portfolio_db');
   define('DB_USER', 'root');        // Change if needed
   define('DB_PASS', '');            // Change if needed
   ```

5. **Create Upload Directory**
   ```bash
   mkdir assets/images/projects
   chmod 755 assets/images/projects  # On Linux/Mac
   ```

6. **Access Your Site**
   - Frontend: http://localhost/portfolio/
   - Admin Panel: http://localhost/portfolio/admin/login.php
   - **Default Login:**
     - Username: `admin`
     - Password: `admin123`
     - ⚠️ **Change this immediately after first login!**

### cPanel Hosting Deployment

1. **Upload Files**
   - Compress all files into a ZIP
   - Login to cPanel
   - Go to File Manager
   - Navigate to `public_html/`
   - Upload and extract the ZIP

2. **Create Database**
   - Go to cPanel → MySQL Databases
   - Create new database: `username_portfolio`
   - Create new user with strong password
   - Add user to database with ALL PRIVILEGES
   - Note down database name, username, and password

3. **Import Database**
   - Go to cPanel → phpMyAdmin
   - Select your database
   - Click Import tab
   - Choose `database.sql`
   - Click Go

4. **Update Configuration**
   - Edit `config/db.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'username_portfolio');
   define('DB_USER', 'username_dbuser');
   define('DB_PASS', 'your_strong_password');
   ```

5. **Set Permissions**
   - Set `assets/images/projects/` to 755
   - Ensure PHP files are 644

6. **Access Your Site**
   - Frontend: https://yourdomain.com/
   - Admin: https://yourdomain.com/admin/login.php

## 🎯 Usage Guide

### Customization

1. **Update Personal Information**
   - Edit `index.php`, `about.php` - Replace "Your Name" with your name
   - Replace placeholder text with your information
   - Add your profile photo as `assets/images/profile.jpg`

2. **Update Social Links**
   - Edit footer section in all PHP files
   - Replace social media URLs with yours

3. **Color Theme (Optional)**
   - Edit `assets/css/style.css`
   - Modify CSS variables in `:root` section

4. **Add Content via Admin Panel**
   - Login to admin panel
   - Add your projects, skills, certifications
   - Upload project images

### Admin Features

**Projects:**
- Add new projects with title, description, tech stack
- Upload project images (recommended: 800x400px)
- Add GitHub and live demo links
- Mark projects as "Recent" to feature on homepage
- Edit or delete existing projects

**Skills:**
- Add skills in three categories: Programming, Data, Tools
- Set proficiency level (0-100%)
- Skills appear with animated progress bars

**Certifications:**
- Add certification name, provider, and year
- Optional: Add certificate URL

**Messages:**
- View all contact form submissions
- Mark messages as read
- Delete messages

### Security Best Practices

1. **Change Default Password**
   ```php
   // In phpMyAdmin or MySQL, run:
   UPDATE admin SET password_hash = '$2y$10$YourNewHashedPassword' WHERE username = 'admin';
   ```
   Or use PHP to generate:
   ```php
   echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
   ```

2. **Change Admin Username**
   ```sql
   UPDATE admin SET username = 'your_secure_username' WHERE id = 1;
   ```

3. **Secure Upload Directory**
   - Add `.htaccess` to `assets/images/projects/`:
   ```apache
   Options -Indexes
   <Files *.php>
       deny from all
   </Files>
   ```

4. **Enable HTTPS**
   - Install SSL certificate (Let's Encrypt is free)
   - Force HTTPS in `.htaccess`

5. **Regular Backups**
   - Backup database regularly
   - Backup uploaded images

## 🛠️ Database Schema

### Tables

**projects**
- `id` - Primary key
- `title` - Project name
- `description` - Project details
- `tech_stack` - Technologies used (comma-separated)
- `github_link` - GitHub repository URL
- `live_link` - Live demo URL
- `image` - Image filename
- `is_recent` - Featured on homepage (0/1)
- `created_at` - Timestamp

**skills**
- `id` - Primary key
- `category` - Programming, Data, or Tools
- `skill_name` - Skill name
- `level` - Proficiency (0-100)
- `display_order` - Sort order

**certifications**
- `id` - Primary key
- `name` - Certification name
- `provider` - Course provider
- `year` - Year obtained
- `certificate_url` - Link to certificate

**contacts**
- `id` - Primary key
- `name` - Sender name
- `email` - Sender email
- `message` - Message content
- `is_read` - Read status (0/1)
- `created_at` - Timestamp

**admin**
- `id` - Primary key
- `username` - Admin username
- `password_hash` - Bcrypt hashed password
- `email` - Admin email
- `last_login` - Last login timestamp

## 📱 Responsive Breakpoints

- **Desktop:** > 768px
- **Tablet:** 768px - 480px
- **Mobile:** < 480px

## 🎨 Color Palette

- Primary: `#2563eb` (Blue)
- Secondary: `#7c3aed` (Purple)
- Accent: `#f59e0b` (Amber)
- Text: `#1f2937` (Dark Gray)
- Background: `#ffffff` (White)

## 🐛 Troubleshooting

**Database Connection Error:**
- Check `config/db.php` credentials
- Ensure MySQL service is running
- Verify database exists

**Images Not Uploading:**
- Check folder permissions (755)
- Verify `assets/images/projects/` exists
- Check file size (max 5MB)
- Ensure allowed extensions (jpg, png, gif, webp)

**Admin Login Not Working:**
- Clear browser cache
- Check database connection
- Verify admin table has user
- Check session.save_path in php.ini

**Blank Pages:**
- Enable error reporting in `config/db.php`:
  ```php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  ```

## 📞 Support

For issues or questions:
1. Check this README first
2. Review error logs
3. Check database connection
4. Verify file permissions

## 📄 License

This project is open source and available for personal and commercial use.

## 🔄 Updates & Maintenance

- Regularly update PHP and MySQL
- Keep database backed up
- Monitor security updates
- Update dependencies as needed

## 🎓 Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript (ES6)
- **Backend:** PHP 7.4+ (PDO)
- **Database:** MySQL 5.7+
- **Fonts:** Google Fonts (Inter, Poppins)
- **Icons:** Font Awesome 6.5
- **Server:** Apache/Nginx

## 📊 Features Checklist

- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Dynamic content from database
- ✅ Admin authentication
- ✅ CRUD operations
- ✅ Image upload
- ✅ Form validation
- ✅ SQL injection prevention
- ✅ XSS protection
- ✅ Password hashing
- ✅ SEO-friendly structure
- ✅ Smooth animations
- ✅ Contact form with database storage

---

**Built with ❤️ for developers by developers**

*Last Updated: December 2024*
# portfolio
