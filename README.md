
# Company Project

This project is a RESTful API for some operations related companies and users.

- Database: PostgreSQL
- PHP : 8.1
- Symfony : 6.4.*

## Install

        $ composer install

        $ bin/console doctrine:migrations:migrate

        $ bin/console doctrine:fixtures:load

        $ symfony serve

- Check this link : `http://127.0.0.1:8000/api`

### For running all tests

    $ composer test
