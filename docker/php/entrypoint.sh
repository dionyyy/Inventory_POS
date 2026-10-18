#!/usr/bin/env bash
set -e

cd /var/www/html

# Install PHP dependencies on first boot, or re-install when the vendor
# directory was built for a different PHP version than this container
# (common when vendor/ is bind-mounted from the host).
if [ ! -f vendor/autoload.php ] || ! php vendor/composer/platform_check.php >/dev/null 2>&1; then
    echo "[entrypoint] Installing Composer dependencies for this container's PHP version..."
    composer install --no-interaction --prefer-dist --no-progress
fi

# Create .env from the example on first boot.
if [ ! -f .env ]; then
    echo "[entrypoint] Creating .env from .env.example..."
    cp .env.example .env
fi

# Ensure framework-writable directories exist and are writable.
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache

# Generate the application key if it is not set.
if ! grep -qE '^APP_KEY=base64:' .env; then
    echo "[entrypoint] Generating application key..."
    php artisan key:generate --no-interaction --force
fi

# Generate the JWT secret if it is not set.
if ! grep -qE '^JWT_SECRET=.+' .env; then
    echo "[entrypoint] Generating JWT secret..."
    php artisan jwt:secret --no-interaction --force
fi

# Wait for the database to accept connections before continuing.
if [ -n "${DB_HOST:-}" ]; then
    echo "[entrypoint] Waiting for database at ${DB_HOST}:${DB_PORT:-3306}..."
    until php -r "exit(@fsockopen(getenv('DB_HOST'), (int)(getenv('DB_PORT') ?: 3306)) ? 0 : 1);" 2>/dev/null; do
        sleep 2
    done
    echo "[entrypoint] Database is reachable."

    # Run migrations on boot (idempotent).
    php artisan migrate --no-interaction --force || true
fi

exec "$@"
