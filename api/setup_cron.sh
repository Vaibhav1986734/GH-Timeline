#!/bin/bash
crontab -l | { cat; echo "*/5 * * * * /usr/bin/php $(pwd)/cron.php"; } | crontab -
echo "CRON job set to run every 5 minutes."
