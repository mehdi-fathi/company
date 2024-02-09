



bin/console doctrine:migrations:migrate


# Company Project

I assumed this project would be a large scale project, so I tried to implement robust and engineering structure.

- Database: PostgreSQL
- PHP : 8.1
- Symfony : 6.4.*

## Install

        $ composer install
        $ bin/console doctrine:migrations:migrate
        $ bin/console doctrine:fixtures:load
        $ symfony serve

- documentation `http://127.0.0.1:8000/api`

### For run all tests

    $ composer test
