#!/bin/sh

set -eu

cd /var/www

if [ ! -f artisan ]; then
    exec "$@"
fi

if [ -n "${DB_CONNECTION:-}" ] && [ "${RUN_MIGRATIONS_AND_SEEDERS:-true}" = "true" ]; then
    max_attempts="${DB_WAIT_ATTEMPTS:-15}"
    attempt=1

    while [ "$attempt" -le "$max_attempts" ]; do
        if php artisan migrate --force --seed; then
            break
        fi

        if [ "$attempt" -eq "$max_attempts" ]; then
            echo "Migration/seed failed after ${max_attempts} attempts." >&2
            exit 1
        fi

        echo "Migration/seed attempt ${attempt}/${max_attempts} failed. Retrying in 3s..." >&2
        attempt=$((attempt + 1))
        sleep 3
    done
fi

exec "$@"
