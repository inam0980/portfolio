-- Portfolio Website Database Schema
-- Execute this SQL file to create the database structure

CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- Projects Table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    tech_stack VARCHAR(300) NOT NULL,
    github_link VARCHAR(255),
    live_link VARCHAR(255),
    image VARCHAR(255) DEFAULT 'default-project.jpg',
    is_recent TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_recent (is_recent),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Skills Table
CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Programming', 'Data', 'Tools') NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    level INT NOT NULL CHECK (level >= 0 AND level <= 100),
    display_order INT DEFAULT 0,
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Certifications Table
CREATE TABLE IF NOT EXISTS certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    provider VARCHAR(150) NOT NULL,
    year INT NOT NULL,
    certificate_url VARCHAR(255),
    display_order INT DEFAULT 0,
    INDEX idx_year (year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contacts Table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_read (is_read),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(150),
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (username: admin, password: admin123)
-- IMPORTANT: Change this password after first login!
INSERT INTO admin (username, password_hash, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@portfolio.com');

-- Sample Data for Testing

-- Sample Skills
INSERT INTO skills (category, skill_name, level, display_order) VALUES
('Programming', 'HTML5', 95, 1),
('Programming', 'CSS3', 90, 2),
('Programming', 'JavaScript', 85, 3),
('Programming', 'PHP', 80, 4),
('Programming', 'Python', 75, 5),
('Data', 'MySQL', 85, 1),
('Data', 'MongoDB', 70, 2),
('Data', 'PostgreSQL', 65, 3),
('Tools', 'Git & GitHub', 90, 1),
('Tools', 'VS Code', 95, 2),
('Tools', 'Docker', 70, 3);

-- Sample Projects
INSERT INTO projects (title, description, tech_stack, github_link, live_link, is_recent) VALUES
('E-Commerce Platform', 'Full-featured online shopping platform with payment integration and admin dashboard', 'PHP, MySQL, JavaScript, Bootstrap', 'https://github.com/username/ecommerce', 'https://demo.ecommerce.com', 1),
('Task Management App', 'Collaborative task management application with real-time updates', 'React, Node.js, MongoDB, Socket.io', 'https://github.com/username/taskmanager', 'https://taskmanager.demo.com', 1),
('Weather Dashboard', 'Real-time weather information dashboard with location-based forecasts', 'HTML, CSS, JavaScript, OpenWeather API', 'https://github.com/username/weather', 'https://weather.demo.com', 1),
('Blog Management System', 'Content management system for blogs with markdown support', 'PHP, MySQL, TinyMCE', 'https://github.com/username/blog', 'https://blog.demo.com', 0),
('Portfolio Generator', 'Automated portfolio website generator with customizable templates', 'Python, Flask, SQLite', 'https://github.com/username/portfolio-gen', 'https://portfolio-gen.demo.com', 0);

-- Sample Certifications
INSERT INTO certifications (name, provider, year, display_order) VALUES
('Full Stack Web Development', 'Coursera', 2024, 1),
('Advanced JavaScript Concepts', 'Udemy', 2024, 2),
('PHP for Beginners', 'freeCodeCamp', 2023, 3),
('MySQL Database Administration', 'LinkedIn Learning', 2023, 4),
('Responsive Web Design', 'freeCodeCamp', 2023, 5);
