export function useLayeredEffect(containerRef, txtImageRef, objImageRef, tiltFactor = 2, translateFactor = 10) {
    const applyTransform = (element, x, y) => {
        if (element) element.style.transform = `translate(${x}px, ${y}px)`;
    };

    const handleMouseMove = (event) => {
        const container = containerRef?.value;
        if (!container) return;

        const rect = container.getBoundingClientRect();
        const [mouseX, mouseY] = [event.clientX - rect.left, event.clientY - rect.top];
        const [centerX, centerY] = [rect.width / 2, rect.height / 2];

        const deltaX = (mouseX - centerX) / centerX;
        const deltaY = (mouseY - centerY) / centerY;

        if (tiltFactor > 0) {
            container.style.transform = `perspective(1000px) rotateX(${-deltaY * tiltFactor}deg) rotateY(${deltaX * tiltFactor}deg)`;
        }

        applyTransform(txtImageRef?.value, deltaX * translateFactor, deltaY * translateFactor);
        applyTransform(objImageRef?.value, deltaX * translateFactor * 2, deltaY * translateFactor * 2);
    };

    const resetTransform = () => {
        const container = containerRef?.value;
        if (tiltFactor > 0 && container) {
            container.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
        }

        applyTransform(txtImageRef?.value, 0, 0);
        applyTransform(objImageRef?.value, 0, 0);
    };

    return { handleMouseMove, resetTransform };
}
