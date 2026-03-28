CREATE DATABASE IF NOT EXISTS gesfin;
USE gesfin;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  profile_pic VARCHAR(255) NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  type ENUM('income', 'expense') NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

CREATE TABLE recurrence_groups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  months_generated INT NOT NULL DEFAULT 12,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

CREATE TABLE entries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  recurrence_group_id INT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  due_date DATE NOT NULL,
  competence_year SMALLINT NOT NULL,
  competence_month TINYINT NOT NULL,
  status ENUM('pending', 'paid') NOT NULL DEFAULT 'pending',
  notes TEXT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  CONSTRAINT fk_entries_category
    FOREIGN KEY (category_id) REFERENCES categories(id),
  CONSTRAINT fk_entries_recurrence_group
    FOREIGN KEY (recurrence_group_id) REFERENCES recurrence_groups(id)
);

CREATE INDEX idx_entries_competence ON entries (competence_year, competence_month);
CREATE INDEX idx_entries_status ON entries (status);
CREATE INDEX idx_entries_due_date ON entries (due_date);
CREATE INDEX idx_entries_category_id ON entries (category_id);
CREATE INDEX idx_entries_recurrence_group_id ON entries (recurrence_group_id);