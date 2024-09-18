<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h2 align="center">Yii 2.0 </h2>
    <br>
</p>

Project Information
-------------------
This project is a service for creating and listing customers and books, utilizing Yii 2.0.


Directory Structure
-------------------

      assets/             contains assets definition
      config/             contains application configurations
      migrations/         contains migrations
      factories/          contains database factories
      
      src/
         controllers/        contains controller classes
         components/         contains controller classes
         commands/           contains console commands (controllers)
         models/             contains model classes
         repositories/       contains repositories classes
         services/           contains services classes

      runtime/            contains files generated during runtime
      tests/              contains unit tests
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


Installation
------------

### Getting started with docker

1. Copy `docker-compose.example.yml` to `docker-compose.yml`
2. Run `docker compose up -d`
3. Make sure all containers are running
4. Run `docker exec -it php-books-api bash` to access docker container
5. Inside container run `php yii testDb/create-test-db` to create tests database
6. Make sure you have all databases created (production and test)
7. Inside container run `php yii migrate` to apply migrations
8. Inside container run `php yii migrate --db=testdb` to apply migrations in database tests

You can then access the application through the following URL:

    http://10.10.0.22:80


Using the project
-------

#### Create a user:

Endpoint(POST): http://10.10.0.22/user/signup

```
{
   "username": "mynickname",
   "name": "Renato Moura",
   "password": "mypassword",
}
```

#### After you must authenticate to get your bearer token:

Endpoint(POST): http://10.10.0.22/user/signin

```
{
   "username": "mynickname",
   "password": "mypassword",
}
```

Now you are logged and can access others endpoints

-----

#### If you want to signout (invalidate token):

Endpoint(POST): http://10.10.0.22/user/signout

-----

#### Examples of valid requests:

- `To create a customer`:

Endpoint(POST): http://10.10.0.22/customer/create

```
{
   "name":"John Doe",
   "cpf":"123.456.789-01",
   "address_zip":12345678,
   "address_street":"Main St",
   "address_number":123,
   "address_city":"Springfield",
   "address_state":"IL",
   "address_complement":"Apt 4B",
   "gender":"M"
}
```
Obs: You can add up to 10 customers per request (there is no queue processing)

-----

- `To get a list of customers`:

Endpoint(GET): http://10.10.0.22/customer/list

With query params:
```
http://10.10.0.22/customer/list?limit=5&offset=0&order=address_city&filter=Alice
```
Obs: You can filter by name or cpf

-----

- `To delete a customer`:

Endpoint(DELETE): http://10.10.0.22/customer/delete

```
{
   "cpf":"123.456.789-01",
}
```
Obs: You can only delete 1 customer per request

-----

- `To add a book`:

Endpoint(POST): http://10.10.0.22/book/add

```
{
    "isbn": "9783161484100",
    "title": "Sample Book Title",
    "author": "John Doe",
    "price": 19.99,
    "stock": 100
}
```
Obs: You can add up to 10 books per request (there is no queue processing)

-----

- `To get a list of books`:

Endpoint(GET): http://10.10.0.22/book/list

With query params:
```
http://10.10.0.22/book/list?limit=5&offset=0&order=name&filter=Bob
```
Obs: You can filter by name, author and title

-----

- `To delete a book`:

Endpoint(DELETE): http://10.10.0.22/book/delete

```
{
   "isbn": "9783161484100",
}
```
Obs: You can only delete 1 book per request

-----

Testing
-------

Tests can be executed by running

```
vendor/bin/phpunit ./tests
```