**02. FORMS**
- **Implementado:**: Formularios para `product`, `customer`, `cart`, `order` en `backend/forms/` (INSERT/SELECT/UPDATE/DELETE). Mini-formularios incluidos vía `backend/functions/showProduct.php`.
- **Falta / Observaciones:**: El `login` no está en un único fichero (hay `form_login.php` y `db/login/db_login_validation.php`). Inconsistencias en rutas (`/student024/Shop` vs `/student024/shop`) y en `action` del form de login (apunta a un endpoint sin `.php`). Recomendación: homogeneizar rutas y nombres y corregir `action` para que apunte al `.php` correcto.

**03. SEGURIDAD**
- **Implementado:**: `form_login` y `db_login_validation.php` existen; `db_login_validation.php` setea `$_SESSION['role']` (admin/user). `session_start()` presente en `backend/includes/header.php` que redirige a login si no hay sesión. El usuario `enrique@gmail.com` con password `dwesteacher` existe en `online_shop.sql`.
- **Falta / Observaciones:**: Contraseñas en la BD en texto claro y consultas con interpolación directa (riesgo SQL injection). Falta `logout.php` (referenciado en `header.php` pero no encontrado). Recomendación: usar `password_hash()`/`password_verify()` y sentencias preparadas, añadir `logout.php` y definir qué ficheros son públicos vs protegidos.

**04. FUNCIONES**
- **Implementado:**: Funciones de presentación en `backend/functions/` (`showProduct.php`, `showCustomers.php`, `showOrders.php`) que generan HTML.
- **Falta / Observaciones:**: Centralizar funciones que devuelvan datos (p.ej. JSON) separando presentación y lógica. Recomendación: crear funciones que formen arrays/objetos y funciones aparte que rendericen HTML o JSON según el contexto.

**05. AJAX & PHP**
- **Implementado (parcial):**: Buscador dinámico: `JavaScript/showproducts.js` hace GET a `backend/db/products/db_product_search.php`. Carrito: `JavaScript/shopping_cart.js` llama a `backend/db/shopping_cart/db_shopping_cart.php` que devuelve JSON para add/remove.
- **Falta / Observaciones:**: `db_product_search.php` declara `Content-Type: application/json` pero imprime HTML mediante `showProduct()` (inconsistente con JSON). `db_shopping_cart_product_update.php` usa POST y redirige (no devuelve JSON) — no es ideal para peticiones AJAX. Recomendación: elegir un formato (JSON preferible para API) y adaptar los endpoints/JS para que consuman JSON; o mantener HTML pero corregir `Content-Type`.

**06. FUNCIONALIDADES**
- **Implementado:**: Visualización de productos y añadir al carrito (formularios incluidos). Ver y editar carrito con operaciones add/remove vía AJAX parcialmente implementadas.
- **Falta / Observaciones:**: No se detectó implementación de comentarios/valoraciones (no hay tablas ni endpoints ni formularios relacionados). Falta la estrategia de moderación automática. Recomendación: añadir tabla `comments`/`reviews` + endpoints para CRUD + admin panel + filtros (blacklist/report/rules) para moderación automática.

**Resumen de prioridades recomendadas**
- Corregir `form_login.php` `action` (apuntar a `.php`) y evitar incluir `header.php` en la página pública de login.
- Añadir `logout.php` y asegurar destrucción de sesión.
- Migrar autenticación a `password_hash()`/`password_verify()` y usar sentencias preparadas para evitar SQL injection.
- Unificar API AJAX: devolver JSON consistente y adaptar JS (especialmente `db_product_search.php` y `db_shopping_cart_product_update.php`).
- Implementar sistema de comentarios/valoraciones (BD + endpoints + UI + moderación automática básica).
- Homogeneizar rutas (`/student024/Shop` vs `/student024/shop`) y normalizar includes para evitar errores de mayúsculas/minúsculas.

**Evidencias (ficheros relevantes)**
- `backend/forms/login/form_login.php` (formulario de login)
- `backend/db/login/db_login_validation.php` (validación de login — utiliza consultas sin preparar y contraseñas en texto)
- `backend/includes/header.php` (contiene `session_start()` y redirección si no hay sesión)
- `backend/functions/showProduct.php` (inserta mini-formularios y renderiza producto HTML)
- `backend/db/products/db_product_search.php` (declara JSON pero usa `showProduct()` para imprimir HTML)
- `backend/db/shopping_cart/db_shopping_cart.php` (endpoint AJAX que devuelve JSON para add/remove)
- `JavaScript/showproducts.js`, `JavaScript/shopping_cart.js` (JS que hace peticiones AJAX)

Si quieres, aplico alguno de los cambios sugeridos ahora (p.ej. corregir `form_login` `action` y crear `logout.php`, o convertir el buscador para que devuelva JSON y adaptar `showproducts.js`).
