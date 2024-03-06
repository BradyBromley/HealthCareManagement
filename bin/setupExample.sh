#!/bin/bash
echo 'Executing SQL commands'

mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/Roles.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/Users.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/Permissions.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/RolesToPermissions.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/Availability.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/scripts/Appointments.sql

mysql -u USER -p PASSWORD HealthCareManagement < sql/data/RolesData.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/data/PermissionsData.sql
mysql -u USER -p PASSWORD HealthCareManagement < sql/data/RolesToPermissionsData.sql