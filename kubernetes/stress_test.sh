#!/bin/bash
URL="http://localhost:30001/index.php?action=add"
WORKERS=20  # Number of parallel background loops

run_worker() {
    local worker_id=$1
    local cookie_file="cookies_w${worker_id}.txt"
    
    while true; do
        # 1. Fetch fresh page token
        CSRF_TOKEN=$(curl -s -c "$cookie_file" "$URL" | grep -oP 'name="csrf" value="\K[^"]+')
        
        if [ -n "$CSRF_TOKEN" ]; then
            # 2. Fire 5 rapid requests using this session token
            for i in {1..5}; do
                curl -s -b "$cookie_file" -c "$cookie_file" \
                    -X POST \
                    -d "csrf=$CSRF_TOKEN&title=StressTest&author=Bot${worker_id}&year=2026" \
                    "$URL" > /dev/null
            done
        fi
    done
}

echo "Spawning $WORKERS load workers... Press CTRL+C to kill all."

# Launch workers into the background
for id in $(seq 1 $WORKERS); do
    run_worker "$id" &
done

# Keep script alive and trap CTRL+C to clean up background processes cleanly
trap "echo 'Stopping workers...'; kill 0; exit" SIGINT SIGTERM
wait

