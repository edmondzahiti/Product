# Train App

## Installation

Clone the repo: ``` git clone https://github.com/edmondzahiti/Product.git ```

```cd``` into the folder generated

Run ```copy .env.example .env``` and after that update database credentials in ```.env``` file

Execute commands as below:

```sh 
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

```sh 
You can use user with credentials:
email: test@example.com
password: 12345678
to Login
or you can create new user using route 'register'
```

```sh 
Routes:
  POST            api/register ....... Auth\AuthController@register
  POST            api/login ....... Auth\AuthController@login
  GET|HEAD        api/products ....... products.index › ProductController@index
  POST            api/products ....... products.store › ProductController@store
  GET|HEAD        api/products/{product} ....... products.show › ProductController@show
  PUT|PATCH       api/products/{product} ....... products.update › ProductController@update
  DELETE          api/products/{product} ....... products.destroy › ProductController@destroy
```

```sh
Unit Test
Execute command to run all the tests: ``` php artisan test ```  
Or Execute each test individually: ``` php artisan test --filter TestName ```  
```

#### I've implemented the following components in your Laravel application:

```sh 
- JWT Authorization: I've used JWT (JSON Web Tokens) for secure user authorization.

- Controller: ProductController manages HTTP requests and delegates operations to the service layer.

- Service Layer (ProductService): It contains product-related business logic, such as creating, updating, and deleting products.

- Repository Layer (ProductRepository): This layer abstracts database operations for products, ensuring separation of concerns.

- Request Validation: Laravel's request validation classes ensure incoming data meets specified criteria.

- Collections and Resources: I've employed collections and resources to format and structure API responses consistently.
```
