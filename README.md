
## installation

- Go to the project directory.

    `cd /var/www/project_dir`
- Copy .env.example to .env

    `cp .env.example .env`
    
- Generate application key

    `php artisan key:generate`
  
- Install dependencies

    `compose instsall`
    
 - Run docker
 
    `docker-compose up -d`
    
 - Run migration
    
    `docker-compose exec app bash`
    
    `php artisan migrate`
