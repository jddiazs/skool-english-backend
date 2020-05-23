


## Instalación para Desarrollo

1) Instalar dependencias de Composer (ejecutar desde el directorio raiz de este proyecto).
    ```
    composer install
    ```
2) Configurar base de datos:

    se ha creado un *MySQL dump* en este archivo `<REPO>/database/sql/laravel_funding_db.sql`.
    Este archivo contiene dos usuarios, un proyecto y una tarea de demostración.

    2.1 Importa esta base de datos usando algún cliente web como PHPMyAdmin o Sequel Pro.
    
    2.2 Crea un usuario que se pueda conectar a esta base de datos, por ejemplo:
        
      ```
        Base de datos:  laravel_funding_db
        Usuario:        laravel_funding_user
        Constraseña:    D5xNL5LpHPVTxwz4
      ```

    2.3 Crea un archivo llamado `.env` en la raíz de este proyecto, con los siguientes datos:
    
      ```
        APP_NAME=Laravel
        APP_ENV=local
        APP_KEY=base64:x0jrh73mp1nSWsXVNBus0NAGhyFw2C6zHlE6WumlyXU=
        APP_DEBUG=true
        APP_URL=http://localhost
        
        LOG_CHANNEL=stack
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=laravel_funding_db
        DB_USERNAME=laravel_funding_user
        DB_PASSWORD=D5xNL5LpHPVTxwz4
        
        BROADCAST_DRIVER=log
        CACHE_DRIVER=file
        QUEUE_CONNECTION=sync
        SESSION_DRIVER=file
        SESSION_LIFETIME=120
        
        REDIS_HOST=127.0.0.1
        REDIS_PASSWORD=null
        REDIS_PORT=6379
        
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.mailtrap.io
        MAIL_PORT=2525
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=null
        
        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        AWS_DEFAULT_REGION=us-east-1
        AWS_BUCKET=
        
        PUSHER_APP_ID=
        PUSHER_APP_KEY=
        PUSHER_APP_SECRET=
        PUSHER_APP_CLUSTER=mt1
        
        MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
        MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
      ```

      Lo importante en este caso son los datos de conexión a la base de datos y la generación de tu `APP_KEY` que puedes 
      generar usando este [Random Generator](https://webtraining.zone/random-generator).
       
      Para crear un usuario en MySQL podemos usar:

     ```
        CREATE DATABASE laravel_funding_db;
        CREATE USER 'laravel_funding_user'@'localhost' IDENTIFIED BY 'D5xNL5LpHPVTxwz4';
        GRANT ALL PRIVILEGES ON laravel_funding_db.* TO 'laravel_funding_user'@'localhost';
        FLUSH PRIVILEGES;
     ```

     **Nota para MySQL 8**

     Si estás usando MySQL 8, la forma de creación de tu base de datos es como sigue:

      ```
       CREATE SCHEMA `laravel_funding_db` DEFAULT CHARACTER SET utf8 ;
      ```
    
  3) Iniciar tu servidor en el puerto 8085
  
       ```
        php artisan serve
        ```

## Preguntas Frecuentes

**¿Por qué cuando visito un *end-point*, por ejemplo `/api/v1/projects` veo un código JSON de "Unauthorized"?**

Recuerda que todos los *end-points* de nuestro RESTful API sólo pueden ser llamados utilizando
el *header* **Content-Type** como **application/json** (es decir, con llamados AJAX
debería funcionar correctamente).


**Cuando intento arrancar el servidor en el puerto 8000 me dice que el puerto ya está ocupado ¿cómo lo soluciono?**

Simplemente cambia el puerto de conexión, por ejemplo si queremos arrancar el servidor en el puerto 8089:
```
php artisan serve --port=8080
```
