# Fact Checkers

The Fact Checkers platform has been made for a masterthesis research about crowdsourced factchecking and personalized gamification.
You can always contact Robin Kelchtermans for more information on robin.kelchtermans@gmail.com.

## Installation
Copy the `.env.example` file and remove the `.example`. Here you will have to add the needed settings.

### Database
Install a MariaDB server. This can be done on the localhost or on a separte server. 
In the `.env` set the values to:
```
DB_CONNECTION=mysql
DB_HOST= <server ip or 127.0.0.1 for localhost>
DB_PORT=3306
DB_DATABASE= <database name>
DB_USERNAME= <username>
DB_PASSWORD= <password>
```
Change port if necessary.


### Laravel
Be sure to have to requirements of Laravel: https://laravel.com/docs/5.8

Run the following command
```
php artisan key:generate
```
And
```
npm install
```
And
```
composer install
```
Set `APP_DEBUG` to true or false depending on what you want.

Set the `public` folder as the root folder of the application. Further information on how to run Laravel can be found on https://laravel.com/docs/5.8

Please add an email service to be able to send emails (e.g. gmail).

## Run
Access your web app. Normally you should see the home page. 
Register to the application as user. 
Be sure to add yourself as admin user to your database (manually). This can be done by setting the `is_admin` value to `1` in the `users` table.

### Selenium
Only for admins! 
Run the `selenium-server-standalone-3.9.1.jar` in the `selenium`folder to launch a selenium instance. This is needed to retrieve the articles.
Go to `<your home page>/feedLoader`. This will take a few minutes and will load all the articles into the database.
Happy browsing!

## Problems?
Feel free to contact me on robin.kelchtermans@gmail.com.

