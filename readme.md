### Installation
1. Clone the repository first
   ```sh
   git clone https://github.com/Digital-Envision/mine-care
   ```
2. Install composer by run 
    ```sh
    composer intall
    ```
3. Install NPM packages
   ```sh
   npm install
   ```
4. Dont forget to set the connection on .env file, change on DB_Connection section
    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1 <- Your site IP
    DB_PORT=3306 <- Dont forget the port of your hosting databases
    DB_DATABASE=envision
    DB_USERNAME=root
    DB_PASSWORD=
    ```

## Instructions how to run the code
The first is the database, so I've included SQL files in this repo. You can download it and import it into your SQL software. You can use XAMPP, SQLite, or others.
And the next is:
- Open this workspace/repo on your Visual Studio Code or you can use notepad++ or others.
- Input php artisan serve on your terminal for the backend.
- And the last you can open another tab on your terminal (Command + T).
- Input npm run watch for the frontend, i use vue.js.
- You can see on your browser by localhost:8000. It should be worked because on .env file i set it up to localhost, 127.0.0.1 with port 3306.

## How it works?
- You can login it with email: admin@admin.com, password: admin.
- And then you will see the dashboards, and then you can go to Your Sites.
- As your assignment, i've been already completed that, with you can add your website, update it and delete on Account page.

## Docker setup
- Navigate to root directory
- Make sure that `.env` is created with the following db setup at the minimum
```
DB_CONNECTION=mysql
DB_HOST=mine-care-db
DB_PORT=3306
```
- Run `docker-compose --env-file .env up`
- From your local (or inside container), run `npm run dev` to build frontend assets
- Go into Laravel container and run `composer run-script migrate`
- (only for first time setup) run `composer run-script seed`
- Access the website via `http://localhost:8081`
