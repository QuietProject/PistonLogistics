#!/bin/bash

# Define the backup directory
backup_dir="/home/nacho/respaldos/config"

# Create the backup directory if it doesn't exist
mkdir -p "$backup_dir"

# Get the current date and time in a specific format (e.g., YYYY-MM-DD_HHMMSS)
current_datetime=$(date +"%Y-%m-%d_%H%M%S")

# Define the backup filename with the current datetime
backup_filename="${current_datetime}_etc_respaldo.tar.gz"

# Backup the /etc folder and compress it
tar -czf "$backup_dir/$backup_filename" /etc

# Check if the backup was successful
if [ $? -eq 0 ]; then
  tput setaf 2
  echo "Respaldo realizado correctamente."
  echo -e "Respaldo: $backup_dir/$backup_filename \n\n"
  tput sgr 0
else
  tput setaf 1
  echo "Respaldo fallido."
  tput sgr 0
  exit 1
fi

# Clean up old backup files (keep the most recent 3)
backup_files=$(ls -t "$backup_dir" | tail -n +4)

if [ -n "$backup_files" ]; then
  tput setaf 3
  echo "Eliminando respaldos antiguos..."
  for file in $backup_files; do
    rm "$backup_dir/$file" -f
    echo "Eliminado: $backup_dir/$file"
    tput sgr 0
  done
fi
