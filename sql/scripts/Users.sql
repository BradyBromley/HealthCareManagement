CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    FirstName varchar(255) NOT NULL,
    LastName varchar(255) NOT NULL,
    Address varchar(255) DEFAULT NULL,
    City varchar(255) DEFAULT NULL,
    PRIMARY KEY (ID)
);