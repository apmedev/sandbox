
## Backend with Rest Service

——————————————————————————————————

The backend should be secure and fast with database seeding enabled as well as CORS for each endpoint.

1. Authentication Middleware
2. Controllers should be written in a clean, approachable coding style.
3. Query Filters implementation
4. Users should be able to follow a selected movie
5. API Pagination
6. Slugs
7. Database Migrations
8. Database Seeds
9. Routes
10. API Postman Collection

The API should be accessible in a local environment from ( example ).

-   <http://localhost:8000/api>

JWT Token reference docs:

-   <https://jwt.io/introduction/>
-   <https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html>

## Setup (DDEV)

1. `ddev config`
2. `copy .env.example into .env`
3. `ddev start`
4. `ddev composer install`
5. `ddev php artisan jwt:secret`
6. `ddev php artisan migrate --seed`
7. Import requests for insomnia: `app_template_requests.json`
8. Import requests for postman: `postman_collection.json`
9. `npm install`
10. `npm run dev`

## User

```
"email": "test2@example.com",
"password": "password456"
```

## Info

Fetches most popular movies in year 2020 from <http://www.omdbapi.com/> with `API_Key: 49733682`
