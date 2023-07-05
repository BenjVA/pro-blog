# Pro-blog
Projet 5
Blog made with PHP, Twig and bootstrap

# Code quality

[![SymfonyInsight](https://insight.symfony.com/projects/e90c26c8-fd76-460c-9376-5f4e80f082fc/mini.svg)](https://insight.symfony.com/projects/e90c26c8-fd76-460c-9376-5f4e80f082fc)


 # Requires

 This project requires PHP 8.0, twig 3.5 and bootsrap 5.2 and an apache server 2.4.
 The DB is handled with PHPmyadmin 5.1.

 # Features

 This blog :
 
*   Contains articles listed in a page and a link to each article with its comments displaying the author, title and last update date if exists.
*   Each article have its own page, which display all the article content, its comments and a form to add comments for logged in users.
*   Can create member accounts.
*   Implements an admin interface with restricted access.
*   Possibility to create/update articles when connected.
*   Possibility to manually validate by admin each new comment and article sent.
*   Admin can suspend and activate members.
*   Have a form contact in homepage.

# INSTALLATION

### Clone / Download

1.  Git clone the repository from this page. **See** [GitHub Documentation](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository-from-github/cloning-a-repository)

### Database

1.  Create new Database in your favorite MySQL DMBS 
2.  Import ***problog.sql*** file in this new Database

### Config 

1.  Open ***app/Model/DatabaseConnection.php*** file, then replace Databse fields with your own information 

### Install all dependencies
1.  Install Composer if you don't have it yet. **See** [Composer Documentation](https://getcomposer.org/download/)
2.  Move on your project directory using cd command :
```sh
cd your/directory
```
    
3.  Run : 
```sh
composer install
```
All dependencies should be installed in a vendor directory.
