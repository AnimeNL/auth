# AnimeCon Authentication
Pre-requisites:
* ^7.3
* Anplan database

## Generate certificates
```sh
mkdir -p var/oauth
openssl genrsa -passout pass:<PASSWORD> -out var/oauth/private.key 2048
openssl rsa -in var/oauth/private.key -passin pass:<PASSWORD> -pubout -out var/oauth/public.key
composer install
```

## Update configuration
Copy `.env` to `.env.local` and update to the values for your environment

## Create the database
```shell script
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force 
```

## Create a client
```shell script
php bin/console trikoder:oauth2:create-client --grant-type=password --scope=anplan
```

Use the information shown in this command (or list-clients) in your authentication call.

## Get a token
```shell script
curl --location --request POST 'http://127.0.0.1:8001/token' \
--header 'Content-Type: application/json' \
--form 'grant_type=password' \
--form 'client_id=~' \
--form 'client_secret=~' \
--form 'username=~' \
--form 'password=~'
```
