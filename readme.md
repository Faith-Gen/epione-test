# EPIONE API SETUP
> Postman API Documentation

> [https://documenter.getpostman.com/view/7034853/Szzj8J4C](https://documenter.getpostman.com/view/7034853/Szzj8J4C)

### Installing project
* ```composer install``` to install dependencies
* ```cp .env.example .env``` to copy environment file to the project

### Preparing project
* Create a MySQL database and name it what you want eg ```innoflash_epione``` and open the ```.env``` file copied into the API folder root and configure your database at the DB section of the file ```line 11 - 13```
* ```php artisan setup``` Had to setup the command to speed up testing :)
> The `setup` command takes care of:
* Generating app key.
* Generating JWT secret.
* Migrating tables.
* Seeding books and some dummy users.

### Testing
After the data is seeded there is a test user.
* Test ```email = test@email.com```
* Test ```password = secret```
* Test ```user_id = 1```

### Issues found.
When I was working on the `User Management` and `User Books API` I realized that those endpoints are giving in a user in the route.

This usually posed a data leak because any logged in user can have access to any other user`s data. 

I created a [LibrarianMiddleware](./app/Http/Middleware/LibrarianMiddleware.php) that will keep the logic of permitting or blocking a certain user from accessing random data. 

I used the middleware on the API endpoints that carry the user in the request payload.


> The last endpoint queries for an individual book record but in reality there is more than one entry in the database where the user can possibly checkout the same book. <br/>
Anyways I have picked the last log of that user for the same user.