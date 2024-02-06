# To install the project do the below: 

#### 1- create database using mysql and copy the name of it.

#### 2- go to backend folder and paste in the env file and paste the name in DB_DATABASE

#### 3- run composer install to install al dependencies then run php artisan migrate to migrate tables to database

#### 4- Run the server using command " php artisan migrate " and copy the url of it to paste it in frontend path

#### 5- back to frontend folder and install all node_modules using "npm i" and paste the url of server to .env.development

#### 6- run command "npm run dev" to make frontend server run and enjoy 


### Some Notes for Checking the app

#### * For the email job task you have to check Backend/App/Console/Kernel.php to see how the task scheduling work and the handling of the job which send emails to users.

#### also you can view the email template with dummy username "Yusuf" on "your-localhost-port/api/v1/mail".


#### And for your notes the categories part in front is not completed yet , so you can test the CRUD operations on posts until the categories one finished.