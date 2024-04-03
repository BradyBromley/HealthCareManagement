CREATE TABLE RolesToPermissions (
    ID int NOT NULL AUTO_INCREMENT,
    roleID int NOT NULL,
    permissionID int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (roleID) REFERENCES Roles(ID),
    FOREIGN KEY (permissionID) REFERENCES Permissions(ID)
) ENGINE=InnoDB CHARACTER SET utf8;