-- Add new tables for dynamic categories
-- Run this SQL in phpMyAdmin or MySQL command line

-- Table for Project Categories
CREATE TABLE IF NOT EXISTS `project_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for Skill Categories
CREATE TABLE IF NOT EXISTS `skill_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-star',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add category_id column to projects table (skip if already exists)
-- If you get "Duplicate column name" error, it means column already exists - that's OK!

SET @dbname = DATABASE();
SET @tablename = 'projects';
SET @columnname = 'category_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (table_name = @tablename)
   AND (table_schema = @dbname)
   AND (column_name = @columnname)) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' int(11) DEFAULT NULL AFTER is_recent, ADD KEY category_id (category_id), ADD CONSTRAINT projects_category_fk FOREIGN KEY (category_id) REFERENCES project_categories (id) ON DELETE SET NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add category_id column to skills table (skip if already exists)
SET @tablename = 'skills';
SET @columnname = 'category_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (table_name = @tablename)
   AND (table_schema = @dbname)
   AND (column_name = @columnname)) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' int(11) DEFAULT NULL AFTER skill_name, ADD KEY category_id (category_id), ADD CONSTRAINT skills_category_fk FOREIGN KEY (category_id) REFERENCES skill_categories (id) ON DELETE SET NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Insert default categories
INSERT INTO `project_categories` (`name`, `description`) VALUES
('Web Apps', 'Full-stack web applications'),
('API Projects', 'RESTful APIs and backend services'),
('Data Science', 'Data analysis and machine learning projects'),
('Mobile Apps', 'Mobile application development');

INSERT INTO `skill_categories` (`name`, `icon`) VALUES
('Programming', 'fa-code'),
('Data', 'fa-database'),
('Tools', 'fa-wrench'),
('Backend Framework', 'fa-server'),
('Frontend Framework', 'fa-react');

-- Migrate existing skills data to new category system
-- Update skills based on old category ENUM values (with collation fix)
UPDATE `skills` s
JOIN `skill_categories` sc ON sc.name COLLATE utf8mb4_general_ci = s.category COLLATE utf8mb4_general_ci
SET s.category_id = sc.id
WHERE s.category IS NOT NULL;

-- Note: After migration is complete and verified, you can optionally drop the old category column:
-- ALTER TABLE `skills` DROP COLUMN `category`;
