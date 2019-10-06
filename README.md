# AnimeCon Authentication
Pre-requisites:
* ^7.1.3
* Anplan database

## Generate certificates
```sh
openssl genrsa -passout pass:<PASSWORD> -out var/oauth/private.key 2048
openssl rsa -in var/oauth/private.key -passin pass:<PASSWORD> -pubout -out var/oauth/public.key
```

## Update configuration
Copy `.env` to `.env.local` and update to the values for your environment

## Create the database
```shell script
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force 
```

## Create a client
```shell script
php bin/console trikoder:oauth2:create-client --grant-type=password --scope=anplan  --grant-type=password --scope=anplan
```

Use the information shown in this command (or list-clients) in your authentication call.