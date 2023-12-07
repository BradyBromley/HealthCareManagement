CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    Email varchar(255) NOT NULL UNIQUE,
    PasswordHash varchar(255) NOT NULL,
    Salt varchar(255) NOT NULL,
    FirstName varchar(255) NOT NULL,
    LastName varchar(255) NOT NULL,
    Address varchar(255) DEFAULT NULL,
    City varchar(255) DEFAULT NULL,
    IsActive boolean DEFAULT 1
    PRIMARY KEY (ID)
);