CREATE TABLE Appointments (
    ID int NOT NULL AUTO_INCREMENT,
    patientID int NOT NULL,
    physicianID int NOT NULL,
    startTime datetime NOT NULL,
    endTime datetime NOT NULL,
    reason varchar(512),
    status varchar(255) DEFAULT 'Scheduled',
    PRIMARY KEY (ID),
    FOREIGN KEY (patientID) REFERENCES Users(ID),
    FOREIGN KEY (physicianID) REFERENCES Users(ID)
) ENGINE=InnoDB CHARACTER SET utf8;