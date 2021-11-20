# Flashcard

## Description
This project written by Laravel and artisan cli that you can add your flash card and answer all flash card question and see your report, etc.

The purpose of this project is that you learn writing code in command line Laravel.
## Installation
after clone project:

```
composer install
```

then:

```
php artisan key:generate
```

then edit .env file and set your database information.

after set database information:

```
php artisan migrate
```

## Usage

run this command:

```
php artisan flashcard:interactive your_email
```

for example:

```
php artisan flashcard:interactive omid@omid.com
```

**Note**: There are several ways to get username and authenticate user.


Regards
