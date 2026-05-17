CREATE DATABASE IF NOT EXISTS library_management_system;
USE library_management_system;

CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    role ENUM('member', 'librarian', 'admin') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO members 
(id, name, email, password_hash, phone, role, created_at) 
VALUES
(1, 'admin', 'admin@aiub.edu', '$2y$10$Odl9ztKWJAAfBQ4cfPFKSe68BCipV1Qguo61QC3rdA.q2RJRCNlxC', '01303611380', 'admin', '2026-05-17 16:46:45'),

(2, 'librarian', 'librarian@aiub.edu', '$2y$10$Rlsn6n9Jb.P/hrZ8Gil4AugMvUoFt2woVaaFU4QOngemAipli2zTW', '01303611381', 'librarian', '2026-05-17 16:48:50'),

(3, 'member', 'member@aiub.edu', '$2y$10$7i4benZpTeNgW.A.kh0dhu/uvXz3X1pqT925NoBsLye1Y7VocBxg.', '01303611382', 'member', '2026-05-17 16:49:41');