#!/bin/sh

main()
{
    init "$@"

    if [ "$SERVICE" = "prettify" ]; then
        phpCsFixer
        prettier
    fi

    if [ "$SERVICE" = "phpstan" ]; then
        phpStan
    fi

    if [ "$SERVICE" = "blast" ]; then
        blast
    fi
}

init()
{
    SERVICE=$1

    if [ -z ${PHPCSFIXER+x} ]; then
        PHPCSFIXER=vendor/bin/php-cs-fixer
    fi

    if [ -z ${PRETTIER+x} ]; then
        PRETTIER=node_modules/prettier/bin-prettier.js
    fi

    if [ -z ${PHPSTAN+x} ]; then
        PHPSTAN=vendor/bin/phpstan
    fi
}

phpCsFixer()
{
    checkExecutable "PHP CS Fixer" $PHPCSFIXER

    $PHPCSFIXER fix -q --no-interaction --allow-risky=yes
}

prettier()
{
    checkExecutable "Prettier" $PRETTIER

    $PRETTIER --loglevel=error --quiet --write .
}

phpStan()
{
    checkExecutable "PHPStan" $PHPSTAN

    $PHPSTAN analyse
}

blast()
{
    php artisan blast:publish
}

checkExecutable()
{
    if [ ! -f "$2" ]; then
        echo
        echo "FATAL ERROR: The executable for $1 ($1) wa not found."
        echo

        exit 1
    fi
}

main "$@"
