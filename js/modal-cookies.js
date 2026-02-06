// Sistema básico de cookies con localStorage
document.addEventListener('DOMContentLoaded', function() {
    const modalOverlay = document.getElementById('cookiesModalOverlay');
    const btnAceptarTodas = document.getElementById('btnAceptarTodas');
    const btnRechazarOpcionales = document.getElementById('btnRechazarOpcionales');
    const checkboxOpcionales = document.getElementById('cookiesOpcionales');

    // Verificar si ya se configuraron las cookies
    const cookiesConfiguradas = localStorage.getItem('cookiesConfiguradas');

    // Si no están configuradas, mostrar el modal
    if (!cookiesConfiguradas) {
        modalOverlay.style.display = 'flex';
    }

    // Botón: Aceptar todas
    if (btnAceptarTodas) {
        btnAceptarTodas.addEventListener('click', function() {
            localStorage.setItem('cookiesEsenciales', 'true');
            localStorage.setItem('cookiesOpcionales', 'true');
            localStorage.setItem('cookiesConfiguradas', 'true');
            cerrarModal();
        });
    }

    // Botón: Rechazar todas
    if (btnRechazarOpcionales) {
        btnRechazarOpcionales.addEventListener('click', function() {
            localStorage.setItem('cookiesEsenciales', 'false');
            localStorage.setItem('cookiesOpcionales', 'false');
            localStorage.setItem('cookiesConfiguradas', 'true');
            cerrarModal();
        });
    }

    // Función para cerrar el modal
    function cerrarModal() {
        if (modalOverlay) {
            modalOverlay.style.animation = 'fadeOut 0.3s ease';
            setTimeout(function() {
                modalOverlay.style.display = 'none';
            }, 300);
        }
    }
});

// Animación CSS
const style = document.createElement('style');
style.textContent = '@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }';
document.head.appendChild(style);
