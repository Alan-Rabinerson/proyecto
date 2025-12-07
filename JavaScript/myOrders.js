    // Manejo del popup de leyenda
    const openLegendBtn = document.getElementById('open-legend-btn');
    const closeLegendBtn = document.getElementById('close-legend-btn');
    const legendModal = document.getElementById('legend-modal');
    const legendContent = document.getElementById('legend-content');

    // Abrir el modal
    openLegendBtn.addEventListener('click', () => {
        legendModal.style.display = 'flex';
    });

    // Cerrar el modal con el botón
    closeLegendBtn.addEventListener('click', () => {
        legendModal.style.display = 'none';
    });

    // Cerrar el modal al hacer clic fuera del contenido
    legendModal.addEventListener('click', (e) => {
        if (e.target === legendModal) {
            legendModal.style.display = 'none';
        }
    });

    // Evitar que los clics dentro del contenido del modal lo cierren
    legendContent.addEventListener('click', (e) => {
        e.stopPropagation();
    });