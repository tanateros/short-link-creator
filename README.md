Install
=
Download there files. Rename file `.env.dist` to `.env`. After run in console:
```
composer install
yarn install
yarn run encore production
```
Require
=
- PHP 7.0+
- composer
- yarn

Run server
=
```
composer run
```
After open in your browser <a href="http://127.0.0.1:8080">127.0.0.1:8080</a>

Stop server
=
```
composer stop
```

Example use with test data
=

Troubleshooting
=
If haven't sqlite driver then should install extension. Example in Linux:
```
sudo apt install php-sqlite3
```

Dropping data
=
Remove file `./data/shortlink.sqlite` and run in console:
```
php bin/console doctrine:migrations:migrate
```

Using technologies
=
- PHP 7.2
- Symfony 4.1
- Doctrine 2
- Twig
- SQLite
- composer
- Bootstrap Twitter 4
- Webpack
- yarn
