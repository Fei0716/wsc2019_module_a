function draggable(el) {
    let startX, startY, initialLeft, initialTop;

    el.addEventListener('pointerdown', (e) => {
        // Prevent default behavior
        e.preventDefault();
        // Capture pointer
        el.setPointerCapture(e.pointerId);
        // Calculate initial positions
        startX = e.clientX;
        startY = e.clientY;
        initialLeft = parseFloat(getComputedStyle(el).left) || 0;
        initialTop = parseFloat(getComputedStyle(el).top) || 0;

        // Attach event listeners
        el.addEventListener("pointermove", move);
        el.addEventListener("pointerup", (e) => {
            el.releasePointerCapture(e.pointerId);
            el.removeEventListener("pointermove", move);
        });
    });

    function move(e) {
        // Calculate new position
        let dx = e.clientX - startX;
        let dy = e.clientY - startY;

        el.style.left = `${initialLeft + dx}px`;
        el.style.top = `${initialTop + dy}px`;
    }
}

// Apply draggable to the element
draggable(document.getElementById('draggable'));
