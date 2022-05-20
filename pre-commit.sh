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

    checkStatus "$@"
}

init()
{
    SERVICE=$1

    if [ -z ${PHPCSFIXER+x} ]; then
        PHPCSFIXER="vendor/bin/php-cs-fixer"
    fi

    if [ -z ${PRETTIER+x} ]; then
        PRETTIER="node_modules/prettier/bin-prettier.js"
    fi

    if [ -z ${PHPSTAN+x} ]; then
        PHPSTAN="vendor/bin/phpstan"
    fi

    if [ -z ${BLAST+x} ]; then
        BLAST="php artisan blast:publish"
    fi
}

phpCsFixer()
{
    checkExecutable "PHP CS Fixer" $PHPCSFIXER

    $PHPCSFIXER fix -q --no-interaction --allow-risky=yes

    WAS_EXECUTED="$PHPCSFIXER"
}

prettier()
{
    checkExecutable "Prettier" $PRETTIER

    $PRETTIER --loglevel=error --quiet --write .

    WAS_EXECUTED="$PHPCSFIXER"
}

phpStan()
{
    checkExecutable "PHPStan" $PHPSTAN

    $PHPSTAN analyse

    WAS_EXECUTED="$PHPCSFIXER"
}

blast()
{
    $BLAST

    WAS_EXECUTED="$BLAST"
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

checkStatus()
{
    if [ -z ${WAS_EXECUTED+x} ]; then
        echo "FATAL ERROR: no commands were found for '$1'"
    fi
}

main "$@"
