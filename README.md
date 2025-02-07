Proyecto API NASA con Laravel 10

Este proyecto consume la API de la NASA (DONKI) y expone datos 
sobre instrumentos y actividades mediante una API REST construida en Laravel 10.

Requisitos Previos:

    - PHP 8.1 o superior
    - Composer 2.x
    - Laravel 10.x

Instalación

    1. Clonar el repositorio:
        git clone https://github.com/tuusuario/nasa-api.git
        cd nasa-api

    2. Instalar dependencias:
        composer install

    3. Copiar el archivo de entorno y configurar:
        cp .env.example .env
        - Configura tu archivo .env con la API Key de la NASA:
            NASA_API_KEY=tu_api_key
            NASA_BASE_URL=https://api.nasa.gov/DONKI

    4. Generar clave de aplicación:
        php artisan key:generate

    5. Levantar el servidor local:
        php artisan serve
        La aplicación estará disponible en http://127.0.0.1:8000.


Uso de la API

    Endpoints Disponibles

        Listar instrumentos usados
            - Método: GET
            - Ruta: /api/nasa/instruments

        Listar IDs de actividades
            - Método: GET
            - Ruta: /api/nasa/activities

        Porcentaje de uso de instrumentos
            - Método: GET
            - Ruta: /api/nasa/instruments/usage
        
        Porcentaje de uso por instrumento
            - Método: POST
            - Ruta: /api/nasa/instruments/usage
            - Ejemplo de Body:
                {
                    "instrument": "SOHO: LASCO/C2"
                }
        También se incluye la colección de Postman "nasa-api.postman_collection" en el repositorio.
