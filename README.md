## Minify Url Service

For start service:
- clone repository
- run 'docker-compose up -d --build'
- run 'docker exec -it <php-cli-container> bash'
- run at container 'cp .env.example .env'
- run at container 'composer install'
- run at container 'php artisan migrate'
- go to https://localhost:8443/
- submit form
- go to https://localhost:8443/<minifyUrl> for redirect to original url