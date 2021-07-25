# Dockerfile-db

# Use MySQL 5.7 for the base image
FROM mariadb:latest

# Copy database initialisation scripts
COPY init.sql /docker-entrypoint-initdb.d/
COPY database.sql /db/