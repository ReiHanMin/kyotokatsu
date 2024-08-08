#!/bin/bash

# Check for a commit message argument
if [ -z "$1" ]
then
  echo "You must provide a commit message."
  exit 1
fi

# Add all changes to the staging area
git add .

# Commit changes with the provided message
git commit -m "$1"

# Push changes to the remote repository
git push origin main
