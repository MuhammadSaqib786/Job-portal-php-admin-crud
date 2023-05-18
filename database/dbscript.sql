-- Create the jobdb database
CREATE DATABASE jobdb;


-- creating user

CREATE USER 'jobuser'@'localhost' IDENTIFIED BY 'jobs';
GRANT ALL PRIVILEGES ON jobdb.* TO 'jobuser'@'localhost';


CREATE USER 'jobuser'@'127.0.0.1' IDENTIFIED BY 'jobs';
GRANT ALL PRIVILEGES ON jobdb.* TO 'jobuser'@'127.0.0.1';

-- Use the jobdb database
USE jobdb;


-- Create the JobSeeker table
CREATE TABLE JobSeeker (
  jobseekerId INT PRIMARY KEY AUTO_INCREMENT,
  firstname VARCHAR(50),
  lastname VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  phoneNumber VARCHAR(15),
  password VARCHAR(100),
  username VARCHAR(50) UNIQUE
);


-- Create the Admin table
CREATE TABLE Admin (
  adminName VARCHAR(50) PRIMARY KEY,
  password VARCHAR(100)
);

INSERT INTO Admin (adminName, password)
VALUES ('admin', 'admin');


-- Create the Session table
CREATE TABLE Session (
  SessionId INT PRIMARY KEY AUTO_INCREMENT,
  session_name VARCHAR(50),
  session_time DATETIME
);

--adding few records

-- Insert 5 records into the Session table
INSERT INTO Session (session_name, session_time)
VALUES
  ('Session 1', '2023-05-17 10:00:00'),
  ('Session 2', '2023-05-18 14:30:00'),
  ('Session 3', '2023-05-19 09:45:00'),
  ('Session 4', '2023-05-20 16:15:00'),
  ('Session 5', '2023-05-21 11:30:00');

-- Create the Appointment table
CREATE TABLE Appointment (
  appId INT PRIMARY KEY AUTO_INCREMENT,
  appDate DATE,
  appTime TIME,
  AppDescription VARCHAR(255),
  sessionId INT,
  jobseekerId INT,
  FOREIGN KEY (sessionId) REFERENCES Session(SessionId),
  FOREIGN KEY (jobseekerId) REFERENCES JobSeeker(jobseekerId)
);
