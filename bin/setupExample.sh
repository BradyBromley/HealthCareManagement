#!/bin/bash
echo 'Executing SQL commands'

mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/Roles.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/Users.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/Permissions.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/RolesToPermissions.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/Availability.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/setupScripts/Appointments.sql

mysql -u USER -p PASSWORD HealthCareManagement < sql/data/RolesData.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/data/PermissionsData.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/data/RolesToPermissionsData.sql