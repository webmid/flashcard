# Flashcard

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

**Note**: There are several ways to get username and I used argument. this way has some benefits such as we get username only one time from user during the process.

Please let me know if you have any problem or question.

omidrafati67@gmail.com

Regards
