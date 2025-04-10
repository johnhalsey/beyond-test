# Beyond Code Test

Application built with Laravel 12 and React that interacts with the Wonde.com API, allowing teachers to see who is in their classes for a given date.

## Local Installation

You will need some kind of local development environment running, for example Laravel Valet, Laravel Herd, MAMP, etc.

```bash
git clone git@github.com:johnhalsey/beyond-test.git
cd beyond-test
composer install
cp .env.example .env
```

Populate the `WONDE_API_KEY` and `WONDE_SCHOOL_ID` in the `.env` file with your token and ID:

```bash
php artisan key:generate
npm install
npm run dev
```

## Decisions Made

I have not implemented any app authentication, largely to save time.  
Currently, anyone can access the app and choose an employee of the school to view their classes and lessons.

In the real world, I would expect a user to log in and be linked to an employee via an `employee_id` in the users table. This would likely be set during the registration process or through an invitation from someone who **does** have access to all employees of the school.

I would also add the `auth:sanctum` middleware to the API routes and add the `HasApiTokens` trait to the `User` model.

## How Does It Work?

1. Users are first prompted to choose an employee from the dropdown (as discussed above).
2. They are then asked to select a date they would like to see their lessons for.
3. The application then hits the Wonde.com `lessons` API endpoint and sends the `include` parameter with `class`, `employee`, and `employees`, filtered by the selected date. It will automatically paginate if necessary to retrieve all lessons.
4. It then filters the lessons by that employee, checking both the `employee` object and the `employees` array.
5. The lessons are then displayed to the user, allowing them to select which one they wish to see the students for.
6. The application then hits the `classes/{classId}` endpoint with the `include` parameter for `students`.
7. The class is returned, and the students are displayed on screen.

## Running Tests

The test suite can be run for this application by running:

```bash
php artisan test
```
