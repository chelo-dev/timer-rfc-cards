## INSTRUCCIONES

#### CONFIGURAR LAS VARIABLES DE ENTORNO

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=kharma_check_nfc
DB_USERNAME=rocket
DB_PASSWORD=TheControl3d15_

MAIL_MAILER=smtp
MAIL_HOST=mail.warriorslabs.com
MAIL_PORT=587
MAIL_USERNAME=grcinfo@warriorslabs.com
MAIL_PASSWORD=GrWlb$2023.
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=grcinfo@warriorslabs.com
MAIL_FROM_NAME="${APP_NAME}"

#### COMANDOS A EJECUTAR
❯ composer update
❯ composer install
❯ php artisan key:generator
❯ php artisan migrate 
❯ php artisan migrate:fresh --seed
❯ php artisan storage:link

#### PERMISOS PARA EL PROYECTO
❯ chmod -R 775 storage
❯ sudo chown -R www-data:www-data storage

#### COMANDOS NECESARIOS PARA UTILIZAR UTILIDADES DE POSTGRESQL
❯ CREATE EXTENSION IF NOT EXISTS unaccent;