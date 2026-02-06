<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
<?php include "includes/design-top.php"; ?>
<?php include "includes/navigation.php"; ?>

<main class="container-fluid row justify-content-center my-5 font-small">
    <div class="col-8">
        <h2 class="text-center mb-5 font-titulos fs-1">Ayudas</h2>
        <div class="accordion" id="acordeonAyuda">

            <div class="accordion-item">
                <h3 class="accordion-header" id="encabezadoUno">
                    <button class="accordion-button fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#colapsoUno" aria-expanded="true" aria-controls="colapsoUno">
                        Cómo realizar un pedido
                    </button>
                </h3>
                <div id="colapsoUno" class="accordion-collapse collapse show" aria-labelledby="encabezadoUno"
                     data-bs-parent="#acordeonAyuda">
                    <div class="accordion-body font-medium">
                        Realizar un pedido es muy sencillo. Navega por nuestro catálogo, selecciona los artículos
                        que te gusten, elige tu talla y color, y añádelos a la cesta. Una vez tengas todo listo, ve
                        al icono del carrito en la esquina superior derecha y pulsa en "Finalizar compra". Sigue los
                        pasos para introducir tus datos de envío y pago, ¡y listo!
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="encabezadoDos">
                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#colapsoDos" aria-expanded="false" aria-controls="colapsoDos">
                        Costes de envío
                    </button>
                </h3>
                <div id="colapsoDos" class="accordion-collapse collapse" aria-labelledby="encabezadoDos"
                     data-bs-parent="#acordeonAyuda">
                    <div class="accordion-body font-medium">
                        Los gastos de envío se calculan en la pantalla de pago según el destino y el peso del
                        paquete. Ofrecemos envíos estándar (3-5 días laborables) y envíos urgentes (24-48 horas).
                        Recuerda que para pedidos superiores a 50€, el envío estándar es totalmente gratuito.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="encabezadoTres">
                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#colapsoTres" aria-expanded="false" aria-controls="colapsoTres">
                        Cómo solicitar una devolución
                    </button>
                </h3>
                <div id="colapsoTres" class="accordion-collapse collapse" aria-labelledby="encabezadoTres"
                     data-bs-parent="#acordeonAyuda">
                    <div class="accordion-body font-medium">
                        Si no estás satisfecho con tu compra, tienes un plazo de 14 días naturales desde la
                        recepción del pedido para solicitar una devolución. Puedes gestionarlo directamente desde tu
                        área de cliente en "Mis Pedidos" o contactando con nuestro servicio de atención al cliente.
                        El producto debe estar en perfecto estado y con su embalaje original.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="encabezadoCuatro">
                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#colapsoCuatro" aria-expanded="false" aria-controls="colapsoCuatro">
                        ¿Cómo puedo hacer el seguimiento de mi pedido?
                    </button>
                </h3>
                <div id="colapsoCuatro" class="accordion-collapse collapse" aria-labelledby="encabezadoCuatro"
                     data-bs-parent="#acordeonAyuda">
                    <div class="accordion-body font-medium">
                        Una vez que tu pedido haya sido enviado, recibirás un correo electrónico de confirmación
                        que incluirá un número de seguimiento y un enlace directo a la web del transportista.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header" id="encabezadoCinco">
                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse"
                            data-bs-target="#colapsoCinco" aria-expanded="false" aria-controls="colapsoCinco">
                        Métodos de pago disponibles
                    </button>
                </h3>
                <div id="colapsoCinco" class="accordion-collapse collapse" aria-labelledby="encabezadoCinco"
                     data-bs-parent="#acordeonAyuda">
                    <div class="accordion-body font-medium">
                        Aceptamos múltiples métodos de pago para tu comodidad: tarjeta de crédito/débito (Visa,
                        Mastercard, American Express), PayPal, transferencia bancaria y pago contra reembolso.
                        Todos nuestros pagos están protegidos con encriptación SSL para garantizar tu seguridad.
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>
</body>

</html>