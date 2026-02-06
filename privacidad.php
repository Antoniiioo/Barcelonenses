    <?php
    session_start();
    include("includes/a_config.php");
    require_once './controlador/ControladorProducto.php';
    require_once './controlador/ControladorImageProducto.php';

    // Obtener todos los productos con sus imágenes
    $controladorProducto = new ControladorProducto();
    $todosProductos = $controladorProducto->obtenerProductosConImagenes();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include "includes/head-tag-contents.php"; ?>
    </head>

    <body class="d-flex flex-column h-100">
        <?php include "includes/design-top.php"; ?>
        <?php include "includes/navigation.php"; ?>

        <main class="container-fluid row justify-content-center my-5 font-medium">
            <div class="col-md-8 col-10">
                <h2 class="text-center mb-4 mt-4 font-titulos fs-1">Políticas de privacidad</h2>

                <section>
                    <p>
                        En <strong>R&V</strong> nos comprometemos a proteger la privacidad
                        de los usuarios de esta aplicación web. Este sitio forma parte de un
                        <strong>proyecto académico sin fines comerciales</strong> correspondiente a un
                        Ciclo Formativo de Grado Superior.
                    </p>
                </section>

                <section>
                    <h2>1. Responsable del tratamiento</h2>
                    <ul>
                        <li><strong>Proyecto:</strong> R&V</li>
                        <li><strong>Tipo:</strong> Proyecto académico - Grado Superior</li>
                        <li><strong>Contacto:</strong> agravaz929@iesmarquesdecomares.org - rarjlan109@iesmarquesdecomares.org</li>
                    </ul>
                </section>

                <section>
                    <h2>2. Información que se recopila</h2>
                    <p>Durante el uso de la aplicación se pueden recopilar los siguientes datos:</p>
                    <ul>
                        <li>Nombre y apellidos</li>
                        <li>Dirección de correo electrónico</li>
                        <li>Dirección de envío</li>
                        <li>Número de teléfono</li>
                        <li>Datos de acceso (usuario y contraseña)</li>
                        <li>Información relacionada con pedidos simulados</li>
                    </ul>
                    <p>
                        Los datos utilizados pueden ser <strong>ficticios</strong> y no se emplean con fines
                        comerciales reales.
                    </p>
                </section>

                <section>
                    <h2>3. Finalidad del tratamiento de los datos</h2>
                    <ul>
                        <li>Simular el funcionamiento de una tienda online</li>
                        <li>Gestionar cuentas de usuario</li>
                        <li>Procesar pedidos de forma académica</li>
                        <li>Mejorar la experiencia del usuario</li>
                    </ul>
                </section>

                <section>
                    <h2>4. Conservación de los datos</h2>
                    <p>
                        Los datos personales se conservarán únicamente durante el tiempo necesario
                        para la evaluación del proyecto académico y podrán ser eliminados posteriormente.
                    </p>
                </section>

                <section>
                    <h2>5. Seguridad de la información</h2>
                    <p>
                        Se aplican medidas básicas de seguridad para evitar accesos no autorizados,
                        pérdida o alteración de los datos, acordes al alcance educativo del proyecto.
                    </p>
                </section>

                <section>
                    <h2>6. Comunicación de datos a terceros</h2>
                    <p>
                        No se ceden datos personales a terceros. En caso de simular servicios externos
                        (envíos o pagos), no se comparte información real.
                    </p>
                </section>

                <section>
                    <h2>7. Derechos de los usuarios</h2>
                    <p>Los usuarios tienen derecho a:</p>
                    <ul>
                        <li>Acceder a sus datos personales</li>
                        <li>Solicitar la modificación o eliminación de los datos</li>
                        <li>Cancelar su cuenta de usuario</li>
                    </ul>
                </section>

                <section>
                    <h2>8. Uso de cookies</h2>
                    <p>
                        Esta aplicación web puede utilizar cookies técnicas necesarias para su
                        correcto funcionamiento. No se utilizan cookies publicitarias ni de seguimiento.
                    </p>
                </section>

                <section>
                    <h2>9. Cambios en la política de privacidad</h2>
                    <p>
                        Esta Política de Privacidad puede modificarse para adaptarse a mejoras del
                        proyecto. Los cambios serán publicados en esta misma sección.
                    </p>
                </section>

                <section>
                    <h2>10. Créditos de imágenes y vídeos</h2>
                    <p>
                        Las imágenes y vídeos utilizados en este proyecto han sido obtenidos de bancos
                        de recursos gratuitos y se emplean conforme a sus licencias, únicamente con
                        fines educativos y no comerciales.
                    </p>

                    <article>
                        <h3>Imágenes</h3>
                        <p>
                            <strong>Todas las imágenes de productos han sido generadas automáticamente mediante inteligencia artificial.</strong><br>
                            <strong>Autor:</strong> Copilot (Microsoft)<br>
                            <strong>Fuente:</strong> <a href="https://copilot.microsoft.com/" target="_blank">Copilot - Generador de imágenes IA</a><br>
                            <strong>Licencia:</strong> Uso educativo sin fines comerciales
                        </p>
                        <br>
                        <h4>Productos con imágenes generadas por IA:</h4>
                        <ul>
                            <?php if(!empty($todosProductos)): ?>
                                <?php foreach($todosProductos as $producto): ?>
                                    <li class="d-flex flex-column my-3">
                                        <div><strong><?= $producto->nombre ?></strong> (<?= $producto->marca ?>) —</div>
                                        <div><strong>Autor:</strong> Copilot</div>
                                        <div><strong>Fuente:</strong> <a href="https://copilot.microsoft.com/" target="_blank">Copilot (Generador de imágenes IA)</a></div>
                                        <div><strong>Prompt:</strong> Hazme una imagen de un producto <?=$producto->nombre?></div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No hay productos disponibles</li>
                            <?php endif; ?>
                        </ul>
                        <br>
                        <h4>Otras imágenes:</h4>
                        <ul>
                            <li>
                                <strong>Imagen de moda (Messi, Suarez, Neymar)</strong> — <strong>Autor:</strong> Darren Staples<br>
                                <strong>Fuente:</strong> <a href="https://www.reutersconnect.com/feed" target="_blank">Reuters</a>
                            </li>
                            <li>
                                <strong>Imágenes de las categorías</strong> — <strong>Autor:</strong> Copilot<br>
                                <strong>Fuente:</strong> <a href="https://copilot.microsoft.com/" target="_blank">Copilot (Generador de imágenes IA)</a><br>
                                <strong>Descripción:</strong> Imágenes representativas de las categorías (niño, hombre, mujer)
                            </li>
                        </ul>
                    </article>

                    <article>
                        <h3>Vídeos</h3>
                        <ul>
                            <li>
                                Vídeo promocional — <strong>Autor:</strong> Mart Production —
                                <strong>Licencia:</strong> uso gratuito
                                <strong>Fuente:</strong> <a href="https://www.pexels.com/es-es/video/persona-en-pie-maqueta-blanco-8166028/">Pexels</a>
                            </li>
                        </ul>
                    </article>
                </section>

        </main>

        <?php include "includes/footer.php"; ?>
    </body>

    </html>