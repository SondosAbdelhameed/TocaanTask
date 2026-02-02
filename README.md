1- open terminal and run "git clone git@github.com:SondosAbdelhameed/OrderTask.git"
2- after project downloaded open it's folder 
3- copy .env.examble and rename it to .env then open it and update database configration
4- open new terminal for project folder
6- run "composer install"
7- run "php artisan migrate:fresh --seed"
8- run "php artisan serve"
// in postman
9- import postman collection to test apis - attatched with project in "postman collection" folder 
10- add new environmint to 
    base_url => "http://127.0.0.1:8000/api"
    
