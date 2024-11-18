<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> <p align="center"> <a href="#"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>

API de ordenes y productos

Este proyecto es una API RESTful desarrollada con Laravel. La API permite gestionar recursos mediante operaciones CRUD y está documentada utilizando Swagger para facilitar la interacción y pruebas.

Tabla de Contenidos

Características
Tecnologías Utilizadas
Requisitos Previos
Instalación
Documentación de la API
Ejecucion y Ejemplo de Uso
Licencia

Características
CRUD de Recursos: Permite crear, leer, actualizar y eliminar datos.
Documentación Automática: Generada con Swagger para facilitar pruebas y comprensión.
Validaciones: Validaciones robustas para los datos de entrada.
Soporte para CORS: Permite el acceso desde diferentes orígenes.

Tecnologías Utilizadas
PHP = 8.2
Laravel 10: Framework PHP para desarrollo web.
SQLITE: Base de datos relacional.
Swagger: Para la documentación de la API.
Composer: Gestor de dependencias de PHP.

Requisitos Previos
PHP >= 8.2
Composer

Instalación
Clona este repositorio y navega al directorio del proyecto:

bash
Copiar código
git clone https://github.com/tu-usuario/tu-proyecto.git
cd tu-proyecto
Instala las dependencias del proyecto:

bash
Copiar código
composer install
Configura el archivo .env:

bash
Copiar código
cp .env.example .env
Genera la clave de la aplicación:

bash
Copiar código
php artisan key:generate
Configuración
Configura la conexión a la base de datos en el archivo .env:

env
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
Ejecuta las migraciones para crear las tablas:

bash
php artisan migrate
Si deseas poblar la base de datos con datos de prueba:

bash
php artisan db:seed
Ejecución
Inicia el servidor de desarrollo:

bash
php artisan serve
La API estará disponible en: http://localhost:8000.

Documentación de la API
La documentación completa de la API está disponible en Swagger. Para acceder a ella, visita:
http://localhost:8000/api/documentation

Swagger UI
La documentación incluye todos los endpoints disponibles, métodos, parámetros de entrada y ejemplos de respuesta.
http://localhost:8000/api/documentation

Endpoints Principales

Gestión de Productos

GET /api/productos Obtener todos los productos.
POST /api/productos Crear un producto.
GET /api/productos/{id} Obtener un producto por ID.
PUT /api/productos/{id} Actualizar un producto por ID.
DELETE /api/productos/{id} Eliminar un producto por ID

Gestión de Productos

GET/api/ordenes Obtener todas las órdenes.
POST /api/ordenes Crear una nueva orden.
GET /api/ordenes/{id} Obtener una orden específica.
PUT /api/ordenes/{id} Actualizar una orden existente.
DELETE /api/ordenes/{id} Eliminar una orden.



Ejecucion y Ejemplo de Uso

Para ver todos los endpoints, consulta la documentación de Swagger.
http://localhost:8000/api/documentation

Crear un Producto

POST
/api/productos
Crear un producto

Este endpoint permite crear un nuevo producto. Requiere los campos 'name', 'category', 'description' y 'amount'. Devuelve el producto creado o un error en caso de fallo en la validación o creación.

seleccionar Try it out

En Request body cambiar los campos requeridos

{
  "name": "Producto A",
  "category": "Electrónica",
  "description": "Descripción del producto",
  "amount": 10
}

Y dar boton execute 

posibles respuestas Responses

Code	Description	Links
201	
Producto creado exitosamente

Media type

application/json
Controls Accept header.
Example Value
Schema
{
  "products": {
    "id": 1,
    "name": "Producto A",
    "category": "Electrónica",
    "description": "Descripción del producto",
    "amount": 10
  },
  "status": 201
}

400	
Error en la validación de datos

Media type

application/json
Example Value
Schema
{
  "message": "Error en la validación de datos",
  "errors": {
    "name": [
      "El campo name es obligatorio."
    ],
    "category": [
      "El campo category es obligatorio."
    ],
    "description": [
      "El campo description es obligatorio."
    ],
    "amount": [
      "El campo amount debe ser un número."
    ]
  },
  "status": 400
}
No links
500	
Error al crear el producto

Media type

application/json
Example Value
Schema
{
  "message": "Error al crear el producto",
  "status": 500
}

Autor
Este proyecto fue desarrollado por [Javier Garzon]. Para consultas o más información, puedes contactarme a través de [javierg.software@gmail.com].

Licencia y Términos de Uso
Este proyecto es solo para fines de visualización y estudio. Se prohíbe su uso, copia, modificación o distribución sin la autorización expresa del autor.

Nota Importante: Este proyecto fue desarrollado como parte de una prueba técnica y no está destinado para uso en producción ni para ser reutilizado sin el consentimiento previo del autor.












