# Beyond Code Test

Application built with Laravel 12 and React that interacts with the wonde.com api, that allows teachers to see who is in their classes each week.

## Local Installation

You will need some kind of local development running, for example Laravel Valet, Laravel Herd, Mamp etc.

- `git clone git@github.com:johnhalsey/beyond-test.git`
- `cd beyong-test`
- `composer install`
- `cp .env.example .env`
- Populate the WONDE_API_KEY and WONDE_SCHOOL_ID in the .env with your token and ID
- `php artisan key:generate`
- `npm install`
- `npm run dev`

## Decisions made

I have not implemented any app authentication, largely to save time.  
Currently anyone can access the app, and choose an employee of the school to view the classes and lessons.  

in the real world, I would expect a user to have to log in, and be linked to an employee with an `employee_id` in the users table that would likely be set as pat of the registration process, or as part of an invitation from someone who **does** have access to all employees of the school.

I would also then add the `auth:sanctum` middleware to the api routes and add the `HasApiTokens` trait to the `User` model.

## Running Tests

The test suite can be run for this application by running `php artisan test`
