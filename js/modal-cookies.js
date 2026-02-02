// Modal de Cookies - Funcionalidad
document.addEventListener('DOMContentLoaded', function() {
    const cookiesForm = document.getElementById('cookiesForm');
    const cookiesOpcionalesCheckbox = document.getElementById('cookiesOpcionales');
    const cookiesOpcionalesValue = document.getElementById('cookiesOpcionalesValue');
    const btnRechazarOpcionales = document.getElementById('btnRechazarOpcionales');
    const btnAceptarTodas = document.getElementById('btnAceptarTodas');

    // Sincronizar el checkbox con el input hidden
    if (cookiesOpcionalesCheckbox && cookiesOpcionalesValue) {
        cookiesOpcionalesCheckbox.addEventListener('change', function() {
            cookiesOpcionalesValue.value = this.checked ? 'true' : 'false';
        });
    }

    // Botón: Rechazar opcionales
    if (btnRechazarOpcionales) {
        btnRechazarOpcionales.addEventListener('click', function() {
            if (cookiesOpcionalesCheckbox) {
                cookiesOpcionalesCheckbox.checked = false;
            }
            if (cookiesOpcionalesValue) {
                cookiesOpcionalesValue.value = 'false';
            }
            if (cookiesForm) {
                cookiesForm.submit();
            }
        });
    }

    // Botón: Aceptar todas
    if (btnAceptarTodas) {
        btnAceptarTodas.addEventListener('click', function() {
            if (cookiesOpcionalesCheckbox) {
                cookiesOpcionalesCheckbox.checked = true;
            }
            if (cookiesOpcionalesValue) {
                cookiesOpcionalesValue.value = 'true';
            }
            if (cookiesForm) {
                cookiesForm.submit();
            }
        });
    }

    // Animación suave al cerrar
    if (cookiesForm) {
        cookiesForm.addEventListener('submit', function() {
            const overlay = document.getElementById('cookiesModalOverlay');
            if (overlay) {
                overlay.style.animation = 'fadeOut 0.3s ease-in-out';
            }
        });
    }
});

// Animación de fadeOut para cuando se cierre el modal
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
