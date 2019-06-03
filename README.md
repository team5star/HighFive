# HighFive
[![All Contributors](https://img.shields.io/badge/all_contributors-3-orange.svg?style=flat-square)](#contributors) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT) [![Top Language](https://img.shields.io/github/languages/top/team5star/HighFive.svg?style=plastic)](#highfive) [![Languages](https://img.shields.io/github/languages/count/team5star/HighFive.svg?style=plastic)](#highfive) [![Open Issues](https://img.shields.io/github/issues/team5star/highfive.svg?style=plastic)](https://github.com/team5star/HighFive/issues) [![Open PRs](https://img.shields.io/github/issues-pr/team5star/highfive.svg?style=plastic)](https://github.com/team5star/HighFive/pulls) [![Last master Commit](https://img.shields.io/github/last-commit/team5star/highfive/master.svg?style=plastic)](https://github.com/team5star/HighFive/commit/master)

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

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore -->
<table><tr><td align="center"><a href="https://cstayyab.github.io"><img src="https://avatars2.githubusercontent.com/u/29598866?v=4" width="100px;" alt="Muhammad Tayyab Sheikh"/><br /><sub><b>Muhammad Tayyab Sheikh</b></sub></a><br /><a href="#projectManagement-cstayyab" title="Project Management">📆</a> <a href="#review-cstayyab" title="Reviewed Pull Requests">👀</a> <a href="https://github.com/team5star/HighFive/commits?author=cstayyab" title="Documentation">📖</a> <a href="https://github.com/team5star/HighFive/commits?author=cstayyab" title="Code">💻</a></td><td align="center"><a href="https://github.com/Moz125"><img src="https://avatars1.githubusercontent.com/u/46564535?v=4" width="100px;" alt="Moz125"/><br /><sub><b>Moz125</b></sub></a><br /><a href="https://github.com/team5star/HighFive/commits?author=Moz125" title="Documentation">📖</a> <a href="https://github.com/team5star/HighFive/commits?author=Moz125" title="Code">💻</a></td><td align="center"><a href="https://github.com/MajidKhanBurki"><img src="https://avatars0.githubusercontent.com/u/48506393?v=4" width="100px;" alt="MajidKhanBurki"/><br /><sub><b>MajidKhanBurki</b></sub></a><br /><a href="#design-MajidKhanBurki" title="Design">🎨</a></td></tr></table>

<!-- ALL-CONTRIBUTORS-LIST:END -->
