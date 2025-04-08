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

