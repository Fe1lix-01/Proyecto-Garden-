# Arquitectura del Proyecto - Dream Garden Polanco

Este documento sirve como guia para explicar el proyecto al profesor. La idea es que el equipo pueda describir como esta construido el sistema, donde se crean las tablas, donde estan los endpoints, como se conectan los controladores con las paginas y como fluye una orden desde el cliente hasta cocina.

## 1. Resumen del sistema

El proyecto es una aplicacion web en Laravel para administrar ordenes de un restaurante/bar llamado Dream Garden Polanco.

El sistema tiene dos tipos de usuario:

- Cliente: ve el menu, agrega productos al carrito, confirma ordenes, ve su historial y puede cancelar ordenes pendientes.
- Cocinero: ve las ordenes de todos los clientes, filtra por estado, cambia el estado de las ordenes, cancela ordenes pendientes y administra productos del menu.

La aplicacion usa:

- Laravel como framework backend.
- MySQL como base de datos.
- Laravel Breeze para autenticacion.
- Blade para construir paginas HTML.
- Tailwind CSS y Vite para estilos y assets.
- Eloquent ORM para consultar y relacionar tablas.

## 2. Patron de arquitectura

Laravel trabaja principalmente con el patron MVC:

- Modelos: representan tablas de la base de datos y relaciones.
- Vistas: son las paginas Blade que ve el usuario.
- Controladores: reciben solicitudes, ejecutan logica y regresan vistas o redirecciones.

En este proyecto:

- Las rutas estan en `routes/web.php`.
- La autenticacion base esta en `routes/auth.php`.
- Los controladores estan en `app/Http/Controllers`.
- Los modelos estan en `app/Models`.
- Las vistas estan en `resources/views`.
- Las migraciones estan en `database/migrations`.
- Los datos iniciales estan en `database/seeders`.

## 3. Base de datos

Las tablas se crean con migraciones. Una migracion es un archivo PHP que define la estructura de una tabla usando `Schema::create` o modifica una tabla con `Schema::table`.

Las migraciones principales del proyecto son:

| Tabla | Archivo donde se crea | Funcion |
| --- | --- | --- |
| `users` | `database/migrations/0001_01_01_000000_create_users_table.php` | Usuarios del sistema, login y roles. |
| `categorias` | `database/migrations/2026_04_18_022900_create_categorias_table.php` | Categorias del menu: Bebidas, Promociones, Botellas, Comida, Extras. |
| `platillos` | `database/migrations/2026_04_18_022911_create_platillos_table.php` | Productos de la carta. Aunque se llama platillos, se usa para bebidas, botellas, comida y extras. |
| `ordenes` | `database/migrations/2026_04_18_022919_create_ordens_table.php` | Orden principal creada por un cliente. |
| `detalle_orden` | `database/migrations/2026_04_18_022927_create_detalles_ordens_table.php` | Productos dentro de una orden. |
| `platillos.imagen` | `database/migrations/2026_06_07_000001_add_imagen_to_platillos_table.php` | Campo extra para guardar la imagen del producto. |

### Tabla `users`

La tabla `users` viene de Laravel Breeze, pero se modifico para manejar roles.

Campos importantes:

- `id`
- `name`
- `email`
- `password`
- `role`

Valores posibles de `role`:

- `cliente`
- `cocinero`

El modelo que representa esta tabla es:

```text
app/Models/User.php
```

Funciones importantes del modelo:

- `ordenes()`: un usuario tiene muchas ordenes.
- `esCliente()`: valida si el usuario es cliente.
- `esCocinero()`: valida si el usuario es cocinero.

### Tabla `categorias`

Campos:

- `id`
- `categoria`
- `descripcion`
- `created_at`
- `updated_at`

Modelo:

```text
app/Models/Categoria.php
```

Relacion:

- Una categoria tiene muchos productos mediante `platillos()`.

### Tabla `platillos`

Campos:

- `id`
- `nombre`
- `descripcion`
- `precio`
- `disponible`
- `imagen`
- `categoria_id`
- `created_at`
- `updated_at`

Modelo:

```text
app/Models/Platillo.php
```

Relaciones:

- Un producto pertenece a una categoria.
- Un producto puede aparecer en muchos detalles de orden.

Nota importante:

Aunque la tabla se llama `platillos`, en el proyecto se usa como tabla general de productos. Por eso ahi estan bebidas, promociones, botellas, comida y extras.

### Tabla `ordenes`

Campos:

- `id`
- `user_id`
- `estado`
- `total`
- `created_at`
- `updated_at`

Modelo:

```text
app/Models/Orden.php
```

Estados posibles:

- `pendiente`
- `en_preparacion`
- `lista`
- `cancelada`

Relaciones:

- Una orden pertenece a un usuario.
- Una orden tiene muchos detalles.

Funciones importantes del modelo:

- `puedeAvanzar()`: valida si una orden puede pasar al siguiente estado.
- `siguienteEstado()`: regresa el siguiente estado correcto.
- `puedeCancelarse()`: solo permite cancelar si la orden esta pendiente.

### Tabla `detalle_orden`

Campos:

- `id`
- `orden_id`
- `platillo_id`
- `cantidad`
- `precio_unitario`
- `subtotal`
- `created_at`
- `updated_at`

Modelo:

```text
app/Models/DetalleOrden.php
```

Relaciones:

- Un detalle pertenece a una orden.
- Un detalle pertenece a un producto.

Esta tabla es importante porque permite que una orden tenga varios productos.

## 4. Relaciones de la base de datos

Las relaciones principales son:

```text
User 1 --- N Orden
Orden 1 --- N DetalleOrden
Platillo 1 --- N DetalleOrden
Categoria 1 --- N Platillo
```

Explicacion:

- Un cliente puede crear muchas ordenes.
- Una orden tiene muchos renglones de detalle.
- Cada renglon de detalle apunta a un producto.
- Cada producto pertenece a una categoria.

## 5. Datos iniciales o seeders

Los datos iniciales se cargan con seeders.

Archivos:

```text
database/seeders/DatabaseSeeder.php
database/seeders/RestauranteSeeder.php
```

`DatabaseSeeder.php` crea usuarios de prueba:

- `cliente@example.com`
- `cocinero@example.com`

Ambos usan password:

```text
password
```

`RestauranteSeeder.php` crea:

- Categorias.
- Productos de Dream Garden Polanco.
- Algunas ordenes de prueba.

Comando para borrar todo y cargar datos nuevos:

```bash
php artisan migrate:fresh --seed
```

Comando para solo ejecutar seeders:

```bash
php artisan db:seed
```

## 6. Rutas y endpoints

En este proyecto los endpoints son rutas web, no una API separada. Eso significa que muchas rutas regresan paginas Blade y otras hacen acciones como guardar, editar o cancelar.

Archivo principal:

```text
routes/web.php
```

Archivo de autenticacion:

```text
routes/auth.php
```

Para ver todas las rutas se usa:

```bash
php artisan route:list --except-vendor
```

### Rutas generales

| Metodo | Ruta | Nombre | Funcion |
| --- | --- | --- | --- |
| GET | `/` | `inicio` | Pagina de bienvenida. |
| GET | `/dashboard` | `dashboard` | Redirige segun rol. Cliente va a menu, cocinero va a cocina. |
| GET | `/profile` | `profile.edit` | Editar perfil. |
| PATCH | `/profile` | `profile.update` | Guardar cambios de perfil. |
| DELETE | `/profile` | `profile.destroy` | Eliminar cuenta. |

### Rutas de autenticacion

Laravel Breeze crea rutas como:

| Metodo | Ruta | Funcion |
| --- | --- | --- |
| GET | `/login` | Mostrar login. |
| POST | `/login` | Iniciar sesion. |
| GET | `/register` | Mostrar registro. |
| POST | `/register` | Crear usuario. |
| POST | `/logout` | Cerrar sesion. |

Estas rutas estan en:

```text
routes/auth.php
```

Los controladores estan en:

```text
app/Http/Controllers/Auth
```

### Rutas del cliente

Estas rutas usan middleware:

```text
auth
verified
role:cliente
```

| Metodo | Ruta | Nombre | Controlador | Funcion |
| --- | --- | --- | --- | --- |
| GET | `/cliente/menu` | `cliente.menu` | `MenuController@index` | Muestra el menu disponible. |
| GET | `/cliente/carrito` | `cliente.carrito` | `CarritoController@index` | Muestra el carrito. |
| POST | `/cliente/carrito/agregar` | `cliente.carrito.agregar` | `CarritoController@agregarAjax` | Agrega productos al carrito usando AJAX. |
| DELETE | `/cliente/carrito/{platillo}` | `cliente.carrito.eliminar` | `CarritoController@eliminar` | Elimina producto del carrito. |
| GET | `/cliente/ordenes` | `cliente.ordenes.index` | `OrdenController@index` | Muestra historial de ordenes del cliente. |
| POST | `/cliente/ordenes` | `cliente.ordenes.store` | `OrdenController@store` | Crea una orden con los productos del carrito. |
| PATCH | `/cliente/ordenes/{orden}/cancelar` | `cliente.ordenes.cancelar` | `OrdenController@cancelarOrden` | Cancela una orden propia si esta pendiente. |

### Rutas del cocinero

Estas rutas usan middleware:

```text
auth
verified
role:cocinero
```

| Metodo | Ruta | Nombre | Controlador | Funcion |
| --- | --- | --- | --- | --- |
| GET | `/cocina/ordenes` | `cocina.ordenes.index` | `CocinaController@index` | Panel de cocina con ordenes FIFO. |
| GET | `/cocina/ordenes/{orden}` | `cocina.ordenes.show` | `CocinaController@show` | Detalle de una orden. |
| PATCH | `/cocina/ordenes/{orden}/avanzar` | `cocina.ordenes.avanzar` | `CocinaController@avanzarEstado` | Cambia estado de pendiente a preparacion o de preparacion a lista. |
| PATCH | `/cocina/ordenes/{orden}/cancelar` | `cocina.ordenes.cancelar` | `CocinaController@cancelarOrden` | Cancela orden pendiente. |
| GET | `/cocina/platillos` | `cocina.platillos.index` | `PlatilloController@index` | Lista productos e inventario. |
| GET | `/cocina/platillos/create` | `cocina.platillos.create` | `PlatilloController@create` | Formulario para crear producto. |
| POST | `/cocina/platillos` | `cocina.platillos.store` | `PlatilloController@store` | Guarda producto nuevo. |
| GET | `/cocina/platillos/{platillo}/edit` | `cocina.platillos.edit` | `PlatilloController@edit` | Formulario para editar producto. |
| PUT/PATCH | `/cocina/platillos/{platillo}` | `cocina.platillos.update` | `PlatilloController@update` | Guarda cambios de producto. |
| DELETE | `/cocina/platillos/{platillo}` | `cocina.platillos.destroy` | `PlatilloController@destroy` | Elimina producto. |
| PATCH | `/cocina/platillos/{platillo}/disponibilidad` | `cocina.platillos.disponibilidad` | `PlatilloController@toggleDisponibilidad` | Activa o desactiva disponibilidad. |

## 7. Middleware y roles

El middleware de roles esta en:

```text
app/Http/Middleware/RoleMiddleware.php
```

Su funcion es:

1. Revisar si el usuario inicio sesion.
2. Comparar el rol del usuario con el rol requerido.
3. Si el rol no coincide, redirigir al dashboard con mensaje de error.
4. Si coincide, permitir continuar.

Ejemplo:

```php
Route::middleware('role:cocinero')
```

Eso significa que solo usuarios con `role = cocinero` pueden entrar a esas rutas.

## 8. Controladores principales

### `MenuController`

Archivo:

```text
app/Http/Controllers/MenuController.php
```

Responsabilidad:

- Consultar categorias con productos disponibles.
- Enviar esos datos a la vista del menu del cliente.

Vista relacionada:

```text
resources/views/cliente/menu_platillos.blade.php
```

### `CarritoController`

Archivo:

```text
app/Http/Controllers/CarritoController.php
```

Responsabilidad:

- Mostrar carrito.
- Agregar productos al carrito.
- Eliminar productos del carrito.

El carrito se guarda en la sesion del navegador, no en una tabla propia. Por eso el cliente puede seleccionar productos antes de confirmar la orden.

### `OrdenController`

Archivo:

```text
app/Http/Controllers/OrdenController.php
```

Responsabilidad:

- Mostrar historial del cliente.
- Crear una orden.
- Cancelar una orden propia si esta pendiente.

Cuando se crea una orden:

1. Lee productos del carrito en sesion.
2. Consulta cada producto en base de datos para tomar precio real.
3. Calcula `subtotal = cantidad * precio_unitario`.
4. Suma subtotales para calcular `total`.
5. Usa una transaccion con `DB::transaction`.
6. Inserta en `ordenes`.
7. Inserta cada producto en `detalle_orden`.
8. Limpia el carrito.

### `CocinaController`

Archivo:

```text
app/Http/Controllers/CocinaController.php
```

Responsabilidad:

- Mostrar todas las ordenes para cocina.
- Ordenarlas FIFO, de la mas antigua a la mas nueva.
- Filtrar por estado.
- Mostrar contador de pendientes.
- Cambiar estados.
- Cancelar ordenes pendientes.

Estados:

```text
pendiente -> en_preparacion -> lista
```

La vista de cocina se recarga casi en tiempo real con JavaScript cada 10 segundos.

Vista relacionada:

```text
resources/views/cocina/ordenes/index.blade.php
```

### `PlatilloController`

Archivo:

```text
app/Http/Controllers/PlatilloController.php
```

Responsabilidad:

- Listar productos.
- Filtrar inventario por categoria.
- Crear productos.
- Editar productos.
- Eliminar productos.
- Activar o desactivar disponibilidad.
- Guardar imagenes de productos.

Imagenes:

- Si se sube archivo desde el formulario, se guarda en `public/uploads`.
- Si se escribe un nombre de archivo que ya esta en `public/uploads`, se usa ese archivo.
- Si se escribe un archivo que esta en `uploads` en la raiz, se copia a `public/uploads`.

## 9. Paginas y vistas

Las paginas se construyen con Blade, que es el motor de plantillas de Laravel.

La estructura general de pagina esta en:

```text
resources/views/layouts/app.blade.php
resources/views/layouts/navigation.blade.php
```

`app.blade.php` define:

- HTML base.
- Fuentes.
- Vite.
- Mensajes de success/error.
- Espacio principal donde se renderiza cada pagina.

`navigation.blade.php` define:

- Barra superior.
- Menu lateral del cocinero.
- Links segun rol.
- Boton de cerrar sesion.

### Vistas publicas y autenticacion

| Vista | Funcion |
| --- | --- |
| `resources/views/welcome.blade.php` | Pagina inicial. |
| `resources/views/auth/login.blade.php` | Login. |
| `resources/views/auth/register.blade.php` | Registro. |

### Vistas del cliente

| Vista | Ruta relacionada | Funcion |
| --- | --- | --- |
| `resources/views/cliente/menu_platillos.blade.php` | `/cliente/menu` | Muestra menu por categorias y permite agregar al carrito. |
| `resources/views/cliente/carrito.blade.php` | `/cliente/carrito` | Muestra productos seleccionados y permite confirmar orden. |
| `resources/views/cliente/historial_ordenes.blade.php` | `/cliente/ordenes` | Muestra historial y estados de ordenes del cliente. |

### Vistas del cocinero

| Vista | Ruta relacionada | Funcion |
| --- | --- | --- |
| `resources/views/cocina/ordenes/index.blade.php` | `/cocina/ordenes` | Tablero principal de cocina con filtros, contador y auto-recarga. |
| `resources/views/cocina/ordenes/show.blade.php` | `/cocina/ordenes/{orden}` | Detalle completo de una orden. |
| `resources/views/cocina/platillos/index.blade.php` | `/cocina/platillos` | Inventario y CRUD de productos. |
| `resources/views/cocina/platillos/create.blade.php` | `/cocina/platillos/create` | Formulario para crear producto. |
| `resources/views/cocina/platillos/edit.blade.php` | `/cocina/platillos/{platillo}/edit` | Formulario para editar producto. |

## 10. Como se construyen las paginas

Cada pagina usa componentes Blade.

Ejemplo comun:

```blade
<x-app-layout>
    <x-slot name="header">
        Encabezado de la pagina
    </x-slot>

    Contenido principal
</x-app-layout>
```

Eso significa:

- `x-app-layout` carga el layout principal.
- `header` manda el encabezado de esa pagina.
- El contenido dentro del componente se muestra en el `<main>`.

Los formularios usan:

```blade
@csrf
```

Esto protege contra ataques CSRF y es obligatorio para POST, PATCH, PUT y DELETE.

Para simular metodos como PATCH o DELETE en formularios HTML se usa:

```blade
@method('PATCH')
@method('DELETE')
```

## 11. Flujo del cliente

1. El cliente inicia sesion.
2. Laravel lo redirige a `/cliente/menu`.
3. `MenuController@index` carga categorias y productos disponibles.
4. La vista `menu_platillos.blade.php` muestra los productos.
5. Al agregar al carrito, se manda un POST a `/cliente/carrito/agregar`.
6. `CarritoController@agregarAjax` guarda el producto en la sesion.
7. El cliente entra a `/cliente/carrito`.
8. Al confirmar, se manda POST a `/cliente/ordenes`.
9. `OrdenController@store` crea la orden y los detalles.
10. La orden queda en estado `pendiente`.
11. El cliente puede verla en `/cliente/ordenes`.

## 12. Flujo del cocinero

1. El cocinero inicia sesion.
2. Laravel lo redirige a `/cocina/ordenes`.
3. `CocinaController@index` consulta ordenes de todos los clientes.
4. Las ordenes se ordenan por `created_at asc` para cumplir FIFO.
5. El tablero muestra filtros por estado.
6. El contador muestra cuantas ordenes pendientes existen.
7. El cocinero puede ver detalle.
8. El cocinero puede avanzar:

```text
pendiente -> en_preparacion
en_preparacion -> lista
```

9. Si una orden sigue pendiente, tambien puede cancelarla.
10. La pagina se actualiza cada 10 segundos con JavaScript.

## 13. Flujo de inventario

1. El cocinero entra a `/cocina/platillos`.
2. `PlatilloController@index` consulta productos.
3. Si la URL trae `?categoria=ID`, filtra por categoria.
4. La vista muestra tabla en escritorio y tarjetas en movil.
5. Desde ahi se puede:

- Crear producto.
- Editar producto.
- Eliminar producto.
- Activar o desactivar disponibilidad.

Cuando un producto queda como no disponible, ya no aparece en el menu del cliente.

## 14. Imagenes de productos

Las imagenes publicas deben vivir en:

```text
public/uploads
```

La URL publica queda asi:

```text
/uploads/nombre-del-archivo.jpg
```

Tambien se permite escribir un archivo que este en:

```text
uploads
```

Si existe ahi, el sistema lo copia a `public/uploads` para que el navegador pueda verlo.

Tamano recomendado:

- Ideal: `1200 x 900 px`.
- Proporcion: `4:3`.
- Minimo: `800 x 600 px`.
- Formatos: JPG, PNG o WEBP.
- Maximo: 4 MB.

## 15. Seguridad y validaciones

El proyecto protege rutas con:

- `auth`: obliga a iniciar sesion.
- `verified`: usuario autenticado.
- `role:cliente`: solo clientes.
- `role:cocinero`: solo cocineros.

Validaciones importantes:

- Al crear producto se valida nombre, descripcion, precio, categoria e imagen.
- Al crear orden se recalculan precios desde la base de datos, no se confia solo en la sesion.
- Al cancelar orden de cliente se valida que la orden pertenezca al usuario autenticado.
- El flujo de estados se controla con metodos del modelo `Orden`.

## 16. Archivos importantes para explicar

Para explicar al profesor, estos son los archivos mas importantes:

```text
routes/web.php
app/Http/Middleware/RoleMiddleware.php
app/Models/User.php
app/Models/Orden.php
app/Models/Platillo.php
app/Models/DetalleOrden.php
app/Models/Categoria.php
app/Http/Controllers/MenuController.php
app/Http/Controllers/CarritoController.php
app/Http/Controllers/OrdenController.php
app/Http/Controllers/CocinaController.php
app/Http/Controllers/PlatilloController.php
database/migrations
database/seeders
resources/views/layouts/app.blade.php
resources/views/layouts/navigation.blade.php
resources/views/cliente
resources/views/cocina
```

## 17. Division sugerida para 3 integrantes

### Integrante 1: Base de datos y modelos

Puede explicar:

- Migraciones.
- Tablas.
- Llaves foraneas.
- Relaciones Eloquent.
- Seeders.
- Estados de orden.

Archivos clave:

```text
database/migrations
database/seeders
app/Models
```

### Integrante 2: Flujo del cliente

Puede explicar:

- Login y rol cliente.
- Menu.
- Carrito en sesion.
- Creacion de orden.
- Calculo de subtotales y total.
- Historial y cancelacion.

Archivos clave:

```text
app/Http/Controllers/MenuController.php
app/Http/Controllers/CarritoController.php
app/Http/Controllers/OrdenController.php
resources/views/cliente
```

### Integrante 3: Flujo del cocinero e inventario

Puede explicar:

- Middleware de rol cocinero.
- Panel FIFO.
- Filtros por estado.
- Cambio de estado.
- CRUD de productos.
- Imagenes de productos.
- Filtros de inventario.

Archivos clave:

```text
app/Http/Controllers/CocinaController.php
app/Http/Controllers/PlatilloController.php
resources/views/cocina
resources/views/layouts/navigation.blade.php
```

## 18. Guion corto para demostracion

1. Iniciar sesion como cliente.
2. Mostrar menu por categorias.
3. Agregar dos productos al carrito.
4. Confirmar orden.
5. Ver historial del cliente.
6. Cerrar sesion.
7. Iniciar sesion como cocinero.
8. Mostrar tablero de cocina.
9. Filtrar ordenes.
10. Abrir detalle de una orden.
11. Cambiar estado de pendiente a en preparacion.
12. Cambiar estado de en preparacion a lista.
13. Entrar a inventario.
14. Filtrar por categoria.
15. Crear o editar producto con imagen.
16. Mostrar que el producto aparece en el menu del cliente.

## 19. Comandos utiles para explicar

Instalar dependencias:

```bash
composer install
npm install
```

Crear llave de Laravel:

```bash
php artisan key:generate
```

Crear tablas y cargar datos:

```bash
php artisan migrate:fresh --seed
```

Agregar migraciones nuevas sin borrar datos:

```bash
php artisan migrate
```

Levantar servidor:

```bash
php artisan serve
```

Compilar estilos:

```bash
npm run build
```

Ver rutas:

```bash
php artisan route:list --except-vendor
```

Ejecutar pruebas:

```bash
php artisan test
```

## 20. Idea principal para cerrar la exposicion

El proyecto cumple el flujo real de restaurante porque separa responsabilidades:

- El cliente crea la orden.
- La base de datos guarda orden y detalles.
- Cocina ve las ordenes en orden FIFO.
- Cocina cambia estados.
- Los roles evitan que un cliente entre al panel de cocina.
- El CRUD permite administrar productos del menu.
- Las vistas cambian segun el tipo de usuario.

La parte mas importante tecnicamente es que una sola orden se guarda en dos tablas relacionadas:

```text
ordenes
detalle_orden
```

Esto permite que una orden tenga muchos productos y que cada producto conserve cantidad, precio unitario y subtotal.
