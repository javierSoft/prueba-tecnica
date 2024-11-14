<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> <p align="center"> <a href="#"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
API de Prueba Técnica
Este proyecto es una API RESTful desarrollada con Laravel para una prueba técnica. La API permite gestionar recursos mediante operaciones CRUD y está documentada utilizando Swagger para facilitar la interacción y pruebas.

Tabla de Contenidos
Características
Tecnologías Utilizadas
Requisitos Previos
Instalación
Configuración
Ejecución
Documentación de la API
Ejemplos de Uso
Contribuciones
Licencia
Características
CRUD de Recursos: Permite crear, leer, actualizar y eliminar datos.
Autenticación: Integrada utilizando JWT (JSON Web Token).
Documentación Automática: Generada con Swagger para facilitar pruebas y comprensión.
Validaciones: Validaciones robustas para los datos de entrada.
Soporte para CORS: Permite el acceso desde diferentes orígenes.
Tecnologías Utilizadas
Laravel 10: Framework PHP para desarrollo web.
MySQL: Base de datos relacional.
JWT: Para autenticación segura.
Swagger: Para la documentación de la API.
Composer: Gestor de dependencias de PHP.
Requisitos Previos
PHP >= 8.1
Composer
MySQL
Node.js y npm (opcional, para ejecutar tareas de frontend)
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
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
Ejecuta las migraciones para crear las tablas:

bash
Copiar código
php artisan migrate
Si deseas poblar la base de datos con datos de prueba:

bash
Copiar código
php artisan db:seed
Ejecución
Inicia el servidor de desarrollo:

bash
Copiar código
php artisan serve
La API estará disponible en: http://localhost:8000.

Documentación de la API
La documentación completa de la API está disponible en Swagger. Para acceder a ella, visita:

Swagger UI
La documentación incluye todos los endpoints disponibles, métodos, parámetros de entrada y ejemplos de respuesta.

Endpoints Principales
Autenticación
POST /api/login: Iniciar sesión.
POST /api/register: Registrar un nuevo usuario.
POST /api/logout: Cerrar sesión.
Gestión de Usuarios
GET /api/users: Listar todos los usuarios.
GET /api/users/{id}: Obtener detalles de un usuario.
POST /api/users: Crear un nuevo usuario.
PUT /api/users/{id}: Actualizar un usuario.
DELETE /api/users/{id}: Eliminar un usuario.
Para ver todos los endpoints, consulta la documentación de Swagger.

Ejemplos de Uso
1. Crear un Usuario
Request:

bash
Copiar código
curl -X POST "http://localhost:8000/api/users" \
-H "Content-Type: application/json" \
-d '{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "password": "123456"
}'
Response:

json
Copiar código
{
  "message": "Usuario creado exitosamente",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com"
  }
}
2. Iniciar Sesión
Request:

bash
Copiar código
curl -X POST "http://localhost:8000/api/login" \
-H "Content-Type: application/json" \
-d '{
  "email": "juan@example.com",
  "password": "123456"
}'
Response:

json
Copiar código
{
  "access_token": "eyJhbGciOiJIUzI1NiIsInR...",
  "token_type": "bearer",
  "expires_in": 3600
}
Contribuciones
Las contribuciones son bienvenidas. Si deseas contribuir, sigue estos pasos:

Haz un fork del repositorio.
Crea una nueva rama (git checkout -b feature/nueva-funcionalidad).
Realiza tus cambios y haz commit (git commit -m 'Agrega nueva funcionalidad').
Envía un push a tu rama (git push origin feature/nueva-funcionalidad).
Abre un Pull Request.
Licencia
Este proyecto está licenciado bajo la licencia MIT. Consulta el archivo LICENSE para más detalles.

Con este README, los usuarios de tu API tendrán una guía clara para la instalación, configuración y uso de la API. Además, la referencia a Swagger les permitirá explorar y probar los endpoints fácilmente.











