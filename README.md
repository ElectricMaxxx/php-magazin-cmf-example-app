# CMF Beispiel für den PHP Magazin Artikel

## Usage

```bash
git clone git@github.com:ElectricMaxxx/php-magazin-cmf-example-app.git my-app
cd my-app
composer install

docker run -d \
--network host \
--env MYSQL_ALLOW_EMPTY_PASSWORD=yes \
--env MYSQL_DATABASE=cmf \
--env MYSQL_ROOT_PASSWORD=root \
--env MYSQL_USER="cmf" \
--env MYSQL_PASSWORD="cmf" \
--volume data_mag_mysql:/var/lib/mysql \
mysql:5.7 .

bin/console doctrine:phpcr:init:dbal --drop --force --env=dev
bin/console doctrine:phpcr:workspace:create prb --env=dev
bin/console doctrine:phpcr:repository:init --env=dev
bin/console doctrine:phpcr:fixtures:load

bin/console server:run
``` 

# Funktionen:

.tbd