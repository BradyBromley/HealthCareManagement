CREATE TABLE RolesToPermissions (
    ID int NOT NULL AUTO_INCREMENT,
    RoleID int NOT NULL,
    PermissionID int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (RoleID) REFERENCES Roles(ID),
    FOREIGN KEY (PermissionID) REFERENCES Permissions(ID)
);