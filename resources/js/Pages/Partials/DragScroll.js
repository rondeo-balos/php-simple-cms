export function dragScroll(scrollContainer, scrollSpeed = 1) {
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;

    const startDrag = (event) => {
        if (!scrollContainer.value) return;
        isDragging = true;
        // Check for touch events
        const pageX = event.type === 'touchstart' ? event.touches[0].pageX : event.pageX;
        startX = pageX - scrollContainer.value.offsetLeft;
        scrollLeft = scrollContainer.value.scrollLeft;
        scrollContainer.value.classList.add('dragging'); // Add grabbing cursor
    };

    const onDrag = (event) => {
        if (!scrollContainer.value || !isDragging) return;
        event.preventDefault();

        // Check for touch events
        const pageX = event.type === 'touchmove' ? event.touches[0].pageX : event.pageX;
        const x = pageX - scrollContainer.value.offsetLeft;
        const walk = (x - startX) * scrollSpeed; // Adjust scroll speed
        scrollContainer.value.scrollLeft = scrollLeft - walk;
    };

    const endDrag = () => {
        if (!scrollContainer.value) return;
        isDragging = false;
        scrollContainer.value.classList.remove('dragging'); // Remove grabbing cursor
    };

    return {
        startDrag,
        onDrag,
        endDrag
    }
}
