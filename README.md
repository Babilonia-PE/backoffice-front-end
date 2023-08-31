# Proyecto Backoffice para Consulta de Registros - Babilonia.io

## Descripción
Este proyecto consiste en desarrollar un backoffice en PHP puro para permitir a la empresa Babilonia.io consultar registros privados de manera eficiente y segura.

## Características
- Autenticación de usuarios para acceder al backoffice.
- Listado de registros con información relevante.
- Funcionalidad de búsqueda y filtrado de registros.
- Detalles de registro en una vista individual.
- Diseño simple y amigable para el usuario.

## Tecnologías Utilizadas
- PHP 8.x
- HTML5 y CSS3 para la interfaz de usuario.
- Sesiones de PHP para la autenticación de usuarios.

## Estructura de Carpetas

``` 
backoffice/
│
├── .env.example
├── .gitignore
├── .htaccess
├── composer.json
├── package.json
├── README.md
│
├── assets/
│   ├── css/
│   │   └── styles.css
│   └── js/
│        └── script.js
├── app/
│   ├── Controllers/
│   ├── Middlewares/
│   ├── Models/
│   └── Services/        
│
├── cache/
├── config/
├── logs/
│   ├── access/
│   └── errors/   
│  
├── public/
│   ├── assets/
|   |   ├── css/
|   |   ├── img/
|   |   └── js/
│   └── plugins/
│
├── routes/
└── views/

```

## Instrucciones de Uso
1. Clona este repositorio en tu servidor web.
2. Ejecutar  ```composer install ``` y configurar las principales variables de entorno, copiando .env.example
3. Personaliza el diseño y los estilos según las necesidades de la empresa.
4. Accede al backoffice a través de la carpeta de su localhost ``` http://localhost/{ruta}/login ```  y autentica tu usuario.
5. Explora la lista de registros, realiza búsquedas y visualiza los detalles de cada registro.

## Configuracion de LDAP para XAMPP

1. Buscar y editar ```C:\xampp\php\php.ini``` y descomentar ```extension = php_ldap.dll``` alrededor de la línea 965.
2. Reiniciar el servicio apache

## Contribuciones
Las contribuciones son bienvenidas. Si deseas mejorar o agregar características al backoffice, no dudes en hacer un fork del repositorio y enviar un pull request.

## Notas
- Este es un proyecto de ejemplo y no garantiza la seguridad completa. Es recomendable implementar medidas adicionales de seguridad en un entorno de producción.
- Este proyecto está diseñado para ser simple y fácil de entender, especialmente para desarrolladores nuevos en PHP.
