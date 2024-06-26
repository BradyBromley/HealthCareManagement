CREATE TABLE Availability (
    ID int NOT NULL AUTO_INCREMENT,
    physicianID int NOT NULL,
    availableTime time NOT NULL DEFAULT '00:00:00',
    PRIMARY KEY (ID),
    FOREIGN KEY (physicianID) REFERENCES Users(ID)
) ENGINE=InnoDB CHARACTER SET utf8;