ALTER TABLE Availability DROP COLUMN endTime;
ALTER TABLE Availability RENAME COLUMN startTime TO availableTime;