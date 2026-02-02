# Copilot instructions (Barcelonenses)

## Project overview
- This is a PHP + MySQL (MariaDB) web app. Most routes are **root-level PHP pages** (e.g. `index.php`, `listadoProductos.php`, `menuAdmin.php`) that render HTML and include shared partials.
- Backend code is organized in a lightweight MVC-ish style:
  - `controlador/` contains controller classes that talk to the DB via PDO (`controlador/Conexion.php`).
  - `modelo/` contains simple entity classes (magic `__get/__set`) used in some flows.
  - `includes/` contains shared layout fragments (head, nav, header, footer) used by nearly every page.

## Data & DB access
- DB schema lives in `database/barcelonenses.sql` (tables: `usuario`, `direccion`, `producto`, `tipo_usuario`, `tipo_producto`, `valoracion`).
- DB connection is centralized in `controlador/Conexion.php` (PDO, UTF-8). Controllers typically:
  - create `new Conexion()`
  - use prepared statements for writes/filters
  - return `fetchAll(PDO::FETCH_OBJ)` or `fetch(PDO::FETCH_OBJ)` for reads (see `controlador/ControladorProducto.php`).
- Auth/session: `controlador/ControladorUsuario.php::login()` verifies `password_hash`/`password_verify` and sets `$_SESSION` keys.

## Page composition conventions
- Pages commonly include these partials in this order:
  - `includes/a_config.php` (sets `$CURRENT_PAGE` / `$PAGE_TITLE` based on `$_SERVER["SCRIPT_NAME"]`)
  - `includes/head-tag-contents.php`
  - `includes/design-top.php`
  - `includes/navigation.php`
  - `includes/footer.php`
- If you add a new root-level page, update the switch in `includes/a_config.php` so the title/nav state stays correct.

## Frontend assets & styling
- Styling is authored in `scss/` and compiled to `css/` (Bootstrap 5 + Bootstrap Icons are imported from `node_modules` in `scss/styles.scss`).
- `css/` is ignored in `.gitignore`, so local CSS is typically generated via Sass rather than committed.
- `includes/head-tag-contents.php` loads `../css/styles.css` and `node_modules/bootstrap/dist/js/bootstrap.bundle.js`.
  - The PHP server should run from the repo root so `node_modules/...` can be served.
  - Many links/asset paths assume pages live at repo root; avoid adding nested PHP routes unless you also fix relative paths in shared includes.

## Local dev workflows (Windows)
- Install Node deps (Bootstrap, icons): `npm install` (see `LEEME.txt`).
- Start Sass watcher: `npm run sass` (requires the `sass` CLI available on PATH).
- Start PHP dev server: `npm run php` (serves from repo root, which also makes `node_modules/...` available).
- Start both (Windows): `npm run dev:win`.

## Existing patterns to follow
- Admin/panel pages handle form actions in the same PHP file using `$_POST`/`$_GET` and redirect after writes to prevent resubmits (see `panelProducto.php`).
- When outputting DB-backed strings into HTML, use `htmlspecialchars()` (already used in `panelProducto.php`).
- Keep controller method return shapes consistent (booleans for write success vs PDO objects for reads) and match existing controller style.

## Scope notes
- `JuegoAntonio/` and `juegoRuben/` contain standalone mini-games (frontend-focused); they’re not part of the PHP MVC flow.
