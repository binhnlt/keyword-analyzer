# Keyword Analyzer Demo App
Hi there! XD 

This app currenty for demo pupose only. You can upload a csv file that contains keywords, then the app will search these keyword on Google and get some basic information such as Total result, total adwords displayed, execution time...


# Installation

 1. Create database with default collation `utf8mb4_unicode_ci`
 2. Create `.env` file at project root and config database connection
 3. Run `composer install` to install necessary libraries
 4. Run command to create all database schema `php bin/console doctrine:migrations:migrate`
 5. To start keyword file consumer, there're 2 ways to start
	 -  To test, just run this command and leave it there `php bin/console app:app:process-keyword-files`
	 - To run on server, I would suggest to use Supervisor to manage this process. Sample configuration as bellow

```
[program:ka-demo-keyword-consummer]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/keyword-analyzer/bin/console app:process-keyword-files
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/keyword-analyzer/var/log/worker.log
```
 
 6. That's it!
