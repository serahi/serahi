cp cront_config /var/spool/cron/crontabs/`users | awk '{print $1}'`
