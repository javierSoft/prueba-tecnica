<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API de Productos y Órdenes",
 *         version="1.0.0",
 *         description="Documentación  de la API, incluyendo los endpoints de gestión de productos y órdenes.",
 *
 *
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000",
 *         description="Servidor local de desarrollo"
 *     ),
 *     @OA\Server(
 *         url="https://api.example.com",
 *         description="Servidor de producción"
 *     ),
 *
 * )
 *
 * @OA\Tag(
 *     name="Productos",
 *     description="Endpoints para la gestión de productos"
 * )
 *
 * @OA\Tag(
 *     name="Órdenes",
 *     description="Endpoints para la gestión de órdenes"
 * )
 */

class SwaggerController extends Controller
{
    // Este controlador solo sirve para la configuración de Swagger.
}
