# Portfolio Website - Quick Start Guide

## 🚀 Quick Installation (5 Minutes)

### Step 1: Setup Local Environment
1. Install XAMPP/WAMP/MAMP
2. Start Apache and MySQL

### Step 2: Extract Files
```
Copy all files to:
- XAMPP: C:/xampp/htdocs/portfolio/
- WAMP: C:/wamp64/www/portfolio/
- MAMP: /Applications/MAMP/htdocs/portfolio/
```

### Step 3: Create Database
1. Open: http://localhost/phpmyadmin
2. Create database: `portfolio_db`
3. Import: `database.sql`

### Step 4: Configure
Open `config/db.php` and update if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Step 5: Access
- **Website:** http://localhost/portfolio/
- **Admin:** http://localhost/portfolio/admin/login.php
  - Username: `admin`
  - Password: `admin123`

## ✏️ First Steps After Installation

1. **Login to Admin Panel**
   - Change default password immediately
   - Update username for security

2. **Customize Content**
   - Edit personal information in pages
   - Add your profile photo: `assets/images/profile.jpg`
   - Update social media links

3. **Add Your Content**
   - Add projects with images
   - Add your skills
   - Add certifications

## 📝 Important Files to Edit

1. **index.php** - Change "Your Name" and personal info
2. **about.php** - Update bio, experience, education
3. **All PHP files** - Update social media URLs in footer
4. **config/db.php** - Database credentials

## 🔒 Security Checklist

- [ ] Change admin password
- [ ] Change admin username
- [ ] Update database credentials
- [ ] Set proper file permissions
- [ ] Enable HTTPS (on live server)
- [ ] Regular backups

## 🆘 Need Help?

Check `README.md` for detailed documentation.

**Common Issues:**
- Can't login? Check database connection
- Images not uploading? Check folder permissions
- Blank pages? Enable PHP error reporting

## 📞 Quick Links

- Frontend: http://localhost/portfolio/
- Admin Panel: http://localhost/portfolio/admin/
- phpMyAdmin: http://localhost/phpmyadmin/

---
**You're ready to go! 🎉**
