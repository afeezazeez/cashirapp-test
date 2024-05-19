
# Payment Integration and Transaction Dashboard

## Description
This project integrates two payment platforms (Flutterwave and Paystack) into the system, with the ability to switch between them to accommodate downtime.
This project also exposed API endpoints to fetch banks, resolve account number and also fetch all transactions.
Additionally, it includes a basic dashboard to display transaction reports on a monthly, daily, or yearly basis.

## Key Features

### Multiple Payment Platform Integration
- Supports both Flutterwave and Paystack.

### Automatic Failover
- Switches to an alternative payment platform in case of downtime/failure.

### Transaction Dashboard
-  Displays transaction reports with search functionality and also filters for monthly, daily, and yearly views.


## Running the App
To run the App, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://www.mysql.com/downloads/)
- **Phpunit**

Clone the repository to your local machine using the command
```console
$ git clone *remote repository url*
```

## Configure app
Create an `.env` and copy `.env.example` content into it using the command.

```console
$ cp .env.example .env
```


### Environment
Configure environment variables in `.env` for dev environment based on your MYSQL database configuration


```  
DB_CONNECTION=<YOUR_MYSQL_TYPE>
DB_HOST=<YOUR_MYSQL_HOST>
DB_PORT=<YOUR_MYSQL_PORT>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>

```
Also, Ensure to set your PAYSTACK_SECRET and FLUTTERWAVE_SECRET.   `.env`
```
PAYSTACK_SECRET=
FLUTTERWAVE_SECRET=
```

Lastly, Ensure to set your base api url configuration in the `.env` for frontend usage. There will be issues if this is not set correctly.
Depending on if you use valet or artisan serve, it can be http://cashirapp.test/api/ or http://localhost:8000/api/

```
VITE_API_URL=http://localhost:8000/api/
```


### LARAVEL INSTALLATION
Install the dependencies and start the server and run app setup command.
Also Seeder was set up for Hmos. Hmos can be seeded into database  using
`php artisan db:seed` as stated below

```console
$ composer install (might need add --ignore-platform-reqs in case of compatitbity issues)
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve (if you don't use Valet)
```

### VUE INSTALLATION
Install the dependencies and start the server

```console
$ npm install && npm run dev
```


You should be able to visit the app dashboard at your laravel app base url e.g http://localhost:8000 or http://cashirapp.test/ (Provided you use Laravel Valet).

### PHPUNIT
To run general test, use command
```console
$ composer test
```


### POSTMAN API DOCUMENTATION
The postman documentation for the API can be found- https://documenter.getpostman.com/view/9428869/2sA3QmCu1C#57b6f9b0-1f36-4171-bbbd-91c9d235c570


## Programming Decisions, Assumptions, and Suggestions

### Simplified Implementation for Testing
- To keep it simple, the initial implementation includes fetching banks and resolving account numbers. These endpoints were chosen to test the payment gateway implementation and the auto-switch functionality.

### Specific Scope for Fetching Banks
- The Flutterwave fetch banks API was scoped specifically to Nigeria for this test. This helps to limit the scope and simplify the testing process.

### Configurable Default Provider
- For the test, the default payment provider can be set in the .env file. However, in a real-world scenario, this setting could be stored in the database to allow for dynamic updates without needing to change environment files.

### Transaction Data Seedin
- For the purpose of displaying transaction reports, the transaction data was seeded in the database. No real transfer operations were implemented, making it easier to test and demonstrate the functionality of the transaction dashboard.
