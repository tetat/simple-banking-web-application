# Simple Banking Web Application

This is a simple banking application with features for both 'Admin' and 'Customer' users.

## To run web application

The entry point is `public` folder. example,

```bash
php -S localhost:8888 -t public
```

## About ENV File

Copy the .env.example file and make the required configuration changes in the .env file

## DB Selection

This application has two types of DB. Select your desired DB in .env file

- File System: `DB_CONNECTION=file`
- MySQL DB: `DB_CONNECTION=mysql`

## Adding Tables

You can only add tables with the help of CLI. You need to run `php create-tables.php`.

## Adding an admin

You can only add an admin with the help of CLI. You need to run `php admin.php` then you can add an admin.

## Admin Features

- See all transactions made by all users.
- Search and view transactions by a specific user using their email.
- View a list of all registered customers.
- Can add a customer.

## Customer Features

- Customers can register using their `name`, `email`, and `password`.
- Customers can log in using their registered email and password.
- See a list of all their transactions.
- Deposit money to their account.
- Withdraw money from their account.
- Transfer money to another customer's account by specifying their email address.
- See the current balance of their account.

### To Start

Clone the repository to your local machine:

```bash
git clone https://github.com/tetat/simple-banking-web-application/tree/bank-with-db
```

### UI Credit

```bash
https://github.com/alnahian2003/bangubank
```
