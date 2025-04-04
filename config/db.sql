-- Drop existing tables if they exist
DROP TABLE IF EXISTS job_applications;
DROP TABLE IF EXISTS job_posts;
DROP TABLE IF EXISTS company_branches;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS companies;

-- Create companies table
CREATE TABLE companies (
    company_id INT(11) NOT NULL AUTO_INCREMENT,
    company_name VARCHAR(255) NOT NULL,
    headquarters_address TEXT,
    company_description TEXT,
    logo_path VARCHAR(255),
    website_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create users table
CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'company_admin', 'applicant') NOT NULL DEFAULT 'applicant',
    company_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create job_posts table
CREATE TABLE job_posts (
    job_id INT(11) NOT NULL AUTO_INCREMENT,
    company_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    job_type ENUM('Full-time', 'Part-time', 'Contract', 'Internship') NOT NULL,
    location VARCHAR(255) NOT NULL,
    salary_min DECIMAL(12,2),
    salary_max DECIMAL(12,2),
    status ENUM('active', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (job_id),
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create job_applications table
CREATE TABLE job_applications (
    application_id INT(11) NOT NULL AUTO_INCREMENT,
    job_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    status ENUM('pending', 'reviewed', 'accepted', 'rejected') DEFAULT 'pending',
    resume_path VARCHAR(255),
    cover_letter TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (application_id),
    FOREIGN KEY (job_id) REFERENCES job_posts(job_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
