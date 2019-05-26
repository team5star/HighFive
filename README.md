# HighFive
HighFive is a very simple social network coded in PHP Core, HTML, JavaScript (and its frameworks) and CSS (Bootstrap). 
## Features
It allows its users to:
* create their personal profile page
* add and remove friends
* create and manage groups
* post in groups
* chat privately with their friends
## Deployment
Move to your *htdocs* folder and execute following command: 
```bash
git clone https://github.com/team5star/highfive.git
```
Import `db-structure-dbhighfive.sql` to MySQL using phpmyadmin.
Now, move to `config` folder inside `highfive`.
Create a file named `database.php`
In `database.php` put the database credentials like this:
```php
<?php
$DB_HOST = "localhost";
$DB_NAME = "dbhighfive";
$DB_USER = "root";
$DB_PASSWORD = "<your_password_here>";
?>
```

## Coding Convention
All code must comply with coding convention specified in [CODING.md](CODING.md) file.
## License
This repository is licensed under the terms of [MIT](LICENSE.md) License file included in this repository.
## Contributors
* **Muhammad Tayyab Sheikh** ([@cstayyab](https://github.com/cstayyab))
* **Moazzam Hameed Paracha** ([@Moz125](https://github.com/Moz125))
* **Majid Khan Burki** ([@MajidKhanBurki](https://github.com/MajidKhanBurki))
* **Mubariz Shuaib** ([@Mbrzzz](https://github.com/Mbrzzz))
* **Muhammad Ali Jaffery** ([@Alijaffery5](https://github.com/Alijaffery5))
