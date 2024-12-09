-- Create the database
CREATE DATABASE IF NOT EXISTS online_store;
USE online_store;

-- Disable foreign key checks to drop tables safely
SET FOREIGN_KEY_CHECKS = 0;

-- Drop all dependent tables in reverse order of dependencies
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS stock_history;
DROP TABLE IF EXISTS price_history;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS employees;

-- Enable foreign key checks after dropping tables
SET FOREIGN_KEY_CHECKS = 1;

-- Recreate tables with cascading foreign keys
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create the employees table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_login TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES customers(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE stock_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    change_amount INT NOT NULL,
    change_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE price_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    old_price DECIMAL(10, 2) NOT NULL,
    new_price DECIMAL(10, 2) NOT NULL,
    change_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insert sample data for customers
INSERT INTO customers (username, password) VALUES
('john_doe', '$2y$10$E/wmqQ6Qs0QSczfgbOXbLeSkRT9UxdLD8YBjrmE3hjqAkCxdu.DdG'), -- password123
('jane_smith', '$2y$10$fyZz8TI7YSge.VtLgfYipuy.BT.1q7D7zI2rtOH.l78CSQH.q1uHK'), -- password456
('test_user', '$2y$10$VzUOclawDWyFRrnz6HbgxOBpGBCRNG1DpN/Mmy3c5cPqLvjIWXbSa'); -- password789

-- Insert sample data for employees
INSERT INTO employees (name, username, password, first_login) VALUES
('Admin User', 'admin_user', '$2y$10$bx8t0k1hVuHlkCGhivzmGeKppRfURyOhU05M6Zxo3RAuXuyroGp5m', 1), -- admin123
('Employee One', 'employee1', '$2y$10$3UJ6mFZHKoF3t9FuCiwlvOJYFt3RtaCixkcU5GpJeLvsQ.FUHRN12', 0), -- emp456
('Employee Two', 'employee2', '$2y$10$frlgwIHn.N5v29JmQOFpbe.wnSG6AcEXUIhZjsEUDFg20Un8BltwW', 0); -- emp789

-- Insert sample data for categories
INSERT INTO categories (name, description) VALUES
('Electronics', 'Devices and gadgets'),
('Books', 'Fiction and non-fiction books'),
('Clothing', 'Men\'s and women\'s clothing');

-- Insert sample data for products
INSERT INTO products (name, category_id, price, stock) VALUES
('Laptop', 1, 999.99, 10),
('Smartphone', 1, 699.99, 15),
('Headphones', 1, 49.99, 50),
('Novel', 2, 14.99, 20),
('T-shirt', 3, 19.99, 100);
