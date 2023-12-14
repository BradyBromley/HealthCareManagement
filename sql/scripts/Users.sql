CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL UNIQUE,
    passwordHash varchar(255) NOT NULL,
    firstName varchar(255) NOT NULL,
    lastName varchar(255) NOT NULL,
    address varchar(255) DEFAULT NULL,
    city varchar(255) DEFAULT NULL,
    isActive boolean DEFAULT 1,
    PRIMARY KEY (ID)
);