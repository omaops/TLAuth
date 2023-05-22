# Authentication Module for PHP & MySQL
tlAuth is a simple and yet secure user authentication module for PHP applications. Making integration and configuration as easy and secure as possible for PHP applications.

I had so many reusable components on my shelf that a friend of mine made me realized I was already working with my own framework. Why not share it right? This authentication module will be the first of a large fully fledged PHP framework I am already working on.

## How to integrate
First thing is to configure your database settings.
1. Create a database called 'tlauth'. If you want to change the name of the database, make sure to also change the name of the database in 'includes/db_config.php' file as well.
2. Import the sql script inside ‘includes/db_config/create.sql’ into your database to create the table with its respected attributes. If you create the table manually, again make sure you match what is in that sql file.
3. Go to ‘includes/db_config.php’ and set up your connection strings to your database management system.
4. If you have an email server, go to ‘includes/config.php’ and change your app url and email sender address.
5. Once you are finished setting up your database, put the following code down at the top of all the pages you want accessed by logged in users only
```php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: signin.php');
}
```
6. Just keep an eye on the in-line comments to get more clarity.
7. The inline comments will make sure you have all the information you need on what is happening in the code.
8. If you still have problems setting up this module, email me at omaops@gmail.com and I’ll see if I can help.
9. Cheers!

## File Structure and Documentation
#### activate.php
#### forgot_password.php
#### index.php
#### README.md
#### reset.php
#### signin.php
#### signup.php
#### /images/loading.gif
#### /js/jquery-1.7.1.min.js
#### /js/jquery-1.7.1.min.js
#### /includes/db_config/create.sql
#### /includes/checkEmailExist.php
#### /includes/config.php
#### /includes/db_config.php
#### /includes/fnts.php
#### /includes/forgot_password.php
#### /includes/logout.php
#### /includes/reset.php
#### /includes/signin.php
#### /includes/signup.php

# DISCLAMER & PERMISSION

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above disclamer notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
