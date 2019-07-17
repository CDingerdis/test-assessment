if which docker >/dev/null; then
    echo 'docker found'
    if [[ ! -f "./.env" ]]; then
        cp .env.example .env
        docker-compose run composer
        docker-compose run php php artisan key:generate
    fi
    docker-compose up
    exit
fi

echo 'docker not found'
if which composer >/dev/null; then
    composer install
else
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    php composer.phar global require hirak/prestissimo
    php composer.phar install

    if [[ ! -f ".env" ]]; then
        cp .env.example .env
        php artisan key:generate
    fi
fi

if which yarn >/dev/null; then
    yarn install
    yarn run production
else
    if which npm >/dev/null; then
        npm install
        npm run production
    else
        echo 'Yarn and Npm not found please install yarn or npm';
        exit
    fi
fi

php artisan serve --port=8081



