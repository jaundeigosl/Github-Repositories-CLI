# Github-Repositories-CLI
# GitHub Trending Repositories CLI

Una herramienta de línea de comandos (CLI) ligera y robusta escrita en PHP nativo. Permite consultar los repositorios más populares (trending) de GitHub basándose en la cantidad de estrellas, con filtros personalizables de tiempo y cantidad de resultados.

## ✨ Características

* **Cero Dependencias Externas:** Construido puramente con las funciones nativas de PHP. No requiere dependencias de Composer ni extensiones compiladas (usa `stream_context_create` y `file_get_contents` en lugar de cURL).
* **Validación Estricta:** Analizador de argumentos personalizado que evalúa banderas de entrada (`--duration`, `--limit`), previene parámetros duplicados y maneja errores tipográficos o de sintaxis.
* **Programación Defensiva:** Manejo robusto de caídas de red, límites de peticiones (Rate Limit) de la API de GitHub y protección contra datos incompletos usando el operador de fusión nula (`??`).
* **Orientado a Objetos:** Arquitectura limpia separada por responsabilidades mediante Namespaces, Excepciones personalizadas y un autoloader propio.

## 📋 Requisitos

* **PHP 7.4 o superior** (requerido para el uso del operador de fusión nula y tipado).
* La directiva `allow_url_fopen` habilitada en tu archivo `php.ini` (necesaria para el funcionamiento de las peticiones HTTP vía streams).

## ⚙️ Configuración Previa

Antes de ejecutar el script por primera vez, es obligatorio ajustar las credenciales de conexión para cumplir con las políticas de la API de GitHub:

1. Abre el archivo `app/Api/ApiConnection.php`.
2. Ubica el array del método `stream_context_create` dentro del constructor.
3. Modifica el encabezado `User-Agent`. Debes reemplazarlo con tu propio nombre de usuario de GitHub o el nombre de tu aplicación. 
   ```php
   // Cambiar esto:
   "User-Agent: "
   
   // Por tu usuario real:
   "User-Agent: tu_usuario_de_github"


## 🏗️ Estructura del Proyecto

El proyecto sigue una arquitectura orientada a objetos con el estándar PSR-4 (simulado) bajo el namespace `app\`.

📁 Github-Repositories-CLI/
├── 📁 Api/
│   └── 📄 ApiConnection.php      # Gestiona peticiones HTTP
├── 📁 Exceptions/
│   └── 📄 ValidationException.php # Excepciones para la CLI
├── 📁 Others/
│   └── 📄 Date.php               # Cálculos de fechas nativos con DateTime
└── 📁 Validators/
│   └── 📄 Validator.php          # Lógica de validación de argumentos
├── 📄 autoload.php               # Carga automática de clases
├── 📄 trending-repos             # Archivo principal y punto de entrada (CLI)
└── 📄 README.md                  # Documentación

## Como Usar

php index.php

## Sintaxis del comando a ejecutar dentro del programa

trending-repos --duration {day,week,month,year} --limit {1-20}

