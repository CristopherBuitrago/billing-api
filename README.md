# Customer API (Laravel 11)

## Descripción

Esta es una API para gestionar clientes, desarrollada con Laravel 11.

Esta API incluye un sistema de autenticación mediante JWT (JSON Web Token) para proteger ciertos endpoints y restringir el acceso a usuarios autenticados. Todavía queda pendiente agregar un mensaje personalizado cuando un usuario no autenticado intenta acceder a una ruta protegida.

## Endpoints

### **Clientes (Customers)**

1. **Obtener todos los clientes:**
   - **URL:** `GET /api/customers`
   - **Descripción:** Retorna una lista con todos los clientes.
   - **Autenticación requerida:** Sí (JWT).

2. **Obtener cliente por nombre:**
   - **URL:** `GET /api/customers/by-name/{name}`
   - **Descripción:** Busca un cliente por su nombre.
   - **Autenticación requerida:** Sí (JWT).

3. **Obtener cliente por ID:**
   - **URL:** `GET /api/customers/{id}`
   - **Descripción:** Retorna los detalles de un cliente específico según su ID.
   - **Autenticación requerida:** Sí (JWT).

4. **Crear un nuevo cliente:**
   - **URL:** `POST /api/customers/create`
   - **Descripción:** Crea un nuevo cliente en la base de datos.
   - **Autenticación requerida:** Sí (JWT).
   - **Parámetros:**
     - `name`: Nombre del cliente.
     - `email`: Correo electrónico del cliente.
     - Otros parámetros adicionales según el esquema del modelo de cliente.

5. **Actualizar un cliente:**
   - **URL:** `PUT /api/customers/update/{id}`
   - **Descripción:** Actualiza la información de un cliente existente.
   - **Autenticación requerida:** Sí (JWT).
   - **Parámetros:** Cualquier campo que necesite ser actualizado, como `name`, `email`, etc.

6. **Eliminar un cliente:**
   - **URL:** `DELETE /api/customers/delete/{id}`
   - **Descripción:** Elimina un cliente específico de la base de datos.
   - **Autenticación requerida:** Sí (JWT).

### **Autenticación**

7. **Registro de usuarios:**
   - **URL:** `POST /api/register`
   - **Descripción:** Permite registrar un nuevo usuario.
   - **Autenticación requerida:** No.

8. **Inicio de sesión:**
   - **URL:** `POST /api/login`
   - **Descripción:** Inicia sesión con las credenciales de usuario y retorna un token JWT.
   - **Autenticación requerida:** No.

9. **Perfil del usuario autenticado:**
   - **URL:** `GET /api/profile`
   - **Descripción:** Muestra la información del perfil del usuario autenticado.
   - **Autenticación requerida:** Sí (JWT).

## JWT Token

Se ha integrado JWT para la autenticación en la API. Una vez que el usuario inicia sesión, recibe un token que debe ser enviado en el header de las peticiones HTTP a rutas protegidas.

### Ejemplo de uso del token JWT:
Al hacer una petición a cualquier endpoint protegido, se debe incluir el token JWT en el encabezado `Authorization` de la siguiente manera:

```
Authorization: Bearer {token}
```

## Tareas pendientes

- **Mensajes de error personalizados:** Falta agregar un mensaje personalizado cuando un usuario no autenticado intenta acceder a una ruta protegida. Actualmente, cuando se intenta acceder a una ruta sin un token válido, se retorna un error genérico de "Unauthorized". Se planea mejorar esto con una respuesta más clara y amigable para el usuario.

---

Este proyecto utiliza Laravel 11, por lo que debes tener PHP 8.2 o superior para su correcto funcionamiento. Para ejecutar este proyecto localmente, sigue los pasos de instalación de Laravel y configura las variables de entorno adecuadamente.
