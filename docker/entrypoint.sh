#! /bin/sh
cd /var/www/auth

if [[ -z "$BIND_IP" ]]; then
    echo "No bind IP specified. Falling back to default"
    BIND_IP="0.0.0.0"
else
    :
fi

if [[ -z "$BIND_PORT" ]]; then
    echo "No bind PORT specified. Falling back to default"
    BIND_PORT="8081"
else
    :
fi

# create database if it does not exist
echo "Create database schema if it does not exist"
php bin/console doctrine:database:create --if-not-exists

# make sure the schema is up to date
echo "Update database schema if needed"
php bin/console doctrine:schema:update --force 

echo "Starting auth server"
php -S $BIND_IP:$BIND_PORT ./public/index.php