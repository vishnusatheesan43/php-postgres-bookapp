#!/bin/bash

URL="http://localhost:30001/index.php?action=add"
COOKIE_FILE="session_cookies.txt"

while true; do
    # 1. Fetch the form, save the fresh session cookie, and extract the CSRF token
    CSRF_TOKEN=$(curl -s -c "$COOKIE_FILE" "$URL" | grep -oP 'name="csrf" value="\K[^"]+')

    if [ -z "$CSRF_TOKEN" ]; then
        echo "Failed to retrieve CSRF token. Retrying..."
        sleep 1
        continue
    fi

    # 2. Submit the form data alongside the matching CSRF token and cookie jar
    curl -s -b "$COOKIE_FILE" -c "$COOKIE_FILE" \
        -X POST \
        -d "csrf=$CSRF_TOKEN&title=LoadTest&author=CurlBot&year=2026" \
        "$URL" > /dev/null

    echo "Book added successfully with token: ${CSRF_TOKEN:0:8}..."
    
    # Optional: Add a brief sleep to avoid crashing the local server instance
    sleep 0.5
done
