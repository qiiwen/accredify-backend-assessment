## How to test

1. Set up database

1.1. Postgres 9.0 is used for this project, the docker can be found here: https://hub.docker.com/_/postgres. Copy .env.example to a .env file and update with username and password
1.2. create a database named laravel
1.3. run migrations via php artisan migrate

2. Run `npm i` to install node modules

3. Run the application via `php artisan serve`

4. Create user via http://127.0.0.1:8000/register (login should automatically follow)

5. You can view the test cases for postman requests provided in app/postman-tests to test the endpoints

## Relevant files

1. routes/web.php for routes to patient and test endpoint
2. app/Http/Controllers/PatientController.php for patient creation function as well as validators' test function
3. app/helpers.php for helper functions involved in mapping country codes to ISO 3166 Alpha 2 Notation
4. storage/app/public/countries_codes_and_coordinates.csv for country code mappings
5. app/Rules.Nric.php for custom nric validator
6. database/2022_09_26_171606_create_patients_table.php for implementation of patients table in postgres database
7. routes/auth.php for routes to login and register functions
8. app/Http/Controllers/Auth for Laravel Breeze's login, register and authentication functions

## Test results and some design considerations

https://docs.google.com/document/d/1cveXTxIdPzsbvc9OgJMYSMtLimKzLMzS32KKPYzg7D4/edit?usp=sharing
