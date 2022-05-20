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

    if ! $PHPCSFIXER fix -q --no-interaction --allow-risky=yes; then
        fatalError "PHP CS Fixer finished with errors"
    fi

    WAS_EXECUTED="$PHPCSFIXER"
}

prettier()
{
    checkExecutable "Prettier" $PRETTIER

    if ! $PRETTIER --loglevel=error --quiet --write .; then
        fatalError "Prettier finished with errors"
    fi

    WAS_EXECUTED="$PHPCSFIXER"
}

phpStan()
{
    checkExecutable "PHPStan" $PHPSTAN

    if ! $PHPSTAN analyse; then
        fatalError "PHPStan finished with errors"
    fi

    WAS_EXECUTED="$PHPCSFIXER"
}

blast()
{
    if ! $BLAST; then
        fatalError "Blast finished with errors"
    fi

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
        fatalError "FATAL ERROR: no commands were found for '$1'"
    fi
}

fatalError()
{
    echo "$1"

    exit 1
}

main "$@"
