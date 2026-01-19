document.addEventListener('DOMContentLoaded', () => {
    const video = document.getElementById('heroVideo');
    const btnPlay = document.getElementById('btnPlay');
    const btnMute = document.getElementById('btnMute');
    const btnFullscreen = document.getElementById('btnFullscreen');
    const progress = document.getElementById('videoProgress');
    const progressContainer = document.getElementById('progressContainer');

    // Reproducir/Pausar
    btnPlay.addEventListener('click', () => {
        if (video.paused) {
            video.play();
            btnPlay.textContent = '⏸';
        } else {
            video.pause();
            btnPlay.textContent = '▶︎';
        }
    });

    // Mutear/desmutear
    btnMute.addEventListener('click', () => {
        video.muted = !video.muted;
        btnMute.textContent = video.muted ? '🔈' : '🔊';
    });

    // Pantalla completa
    btnFullscreen.addEventListener('click', async () => {
        try {
            if (!document.fullscreenElement) {
                await video.requestFullscreen();
            } else {
                await document.exitFullscreen();
            }
        } catch (e) {
            console.warn('Fullscreen no disponible', e);
        }
    });

    // Actualizar barra de progreso
    video.addEventListener('timeupdate', () => {
        if (video.duration) {
            const pct = (video.currentTime / video.duration) * 100;
            progress.style.width = pct + '%';
        }
    });

    // Barra de progreso clicable
    progressContainer.addEventListener('click', (e) => {
        const rect = progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const pct = clickX / rect.width;
        if (video.duration) {
            video.currentTime = pct * video.duration;
        }
    });

    video.addEventListener('play', () => btnPlay.textContent = '⏸');
    video.addEventListener('pause', () => btnPlay.textContent = '▶︎');
    btnMute.textContent = video.muted ? '🔈' : '🔊';
});
