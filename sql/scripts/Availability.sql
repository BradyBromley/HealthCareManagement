CREATE TABLE Availability (
    ID int NOT NULL AUTO_INCREMENT,
    physicianID int NOT NULL,
    startTime time NOT NULL DEFAULT '00:00:00',
    endTime time NOT NULL DEFAULT '23:59:59',
    PRIMARY KEY (ID),
    FOREIGN KEY (physicianID) REFERENCES Users(ID)
) ENGINE=InnoDB CHARACTER SET utf8;