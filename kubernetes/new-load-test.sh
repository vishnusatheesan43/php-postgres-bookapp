#!/bin/bash
URL="http://localhost:30001/index.php?action=add"
COOKIE_FILE="session_cookies.txt"

echo "Launching high-load test... Press [CTRL+C] to stop."

while true; do
    # Fetch token and cookie
    CSRF_TOKEN=$(curl -s -c "$COOKIE_FILE" "$URL" | grep -oP 'name="csrf" value="\K[^"]+')
    
    if [ -n "$CSRF_TOKEN" ]; then
        # Launch 20 parallel requests into the background using '&'
        for i in {1..20}; do
            curl -s -b "$COOKIE_FILE" -c "$COOKIE_FILE" \
                -X POST \
                -d "csrf=$CSRF_TOKEN&title=HighLoadTest&author=CurlBot&year=2026" \
                "$URL" > /dev/null &
        done
    fi
    # Briefly yield to keep your testing machine stable
    sleep 0.1
done

