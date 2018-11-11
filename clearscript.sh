#!/bin/bash

echo "clearing cache dev"
php ./app/console cache:clear
echo "clearing chache prod"
php ./app/console cache:clear --env=prod

echo "change group"
chgrp -R www-data ./app/cache/dev/
chgrp -R www-data ./app/cache/prod/

echo "change owner"
chown -R www-data ./app/cache/dev/
chown -R www-data ./app/cache/prod/
