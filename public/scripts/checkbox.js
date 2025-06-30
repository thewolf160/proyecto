const checkboxes = document.querySelectorAll('.check');

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            checkboxes.forEach((cb) => {
                if (cb !== checkbox) cb.checked = false;
            });
        }
    });
});

document.querySelectorAll('.metodo-pago').forEach(div => {
    div.addEventListener('click', function(e) {
        // Evita que el click en el input no lo desmarque accidentalmente
        if (e.target.tagName.toLowerCase() === 'input') return;
        const checkbox = div.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
});