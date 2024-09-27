export function useLayeredEffect(containerRef, txtImageRef, objImageRef, tiltFactor = 2, translateFactor = 10 /*Control how much the items move*/) {
    const handleMouseMove = (event) => {
        const container = containerRef?.value ?? null;
        const txtImage = txtImageRef?.value ?? null;
        const objImage = objImageRef?.value ?? null;

        if (!container) return;

        const rect = container.getBoundingClientRect();
        const mouseX = event.clientX - rect.left; // Mouse X relative to container
        const mouseY = event.clientY - rect.top;  // Mouse Y relative to container

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        // Calculate percentage distance from center
        const deltaX = (mouseX - centerX) / centerX;
        const deltaY = (mouseY - centerY) / centerY;

        // Apply 3D transform to the container itself
        const rotateX = -deltaY * tiltFactor; // Adjust the value for more or less tilt
        const rotateY = deltaX * tiltFactor;
        if( tiltFactor > 0 )
            container.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

        // Parallax effect for the items inside the container
        const txtTranslateX = deltaX * translateFactor;
        const txtTranslateY = deltaY * translateFactor;
        const objTranslateX = deltaX * (translateFactor * 2); // Move object image faster than text
        const objTranslateY = deltaY * (translateFactor * 2);

        // Apply translation to text and object images (parallax effect)
        if(txtImage)
            txtImage.style.transform = `translate(${txtTranslateX}px, ${txtTranslateY}px)`;
        if(objImage)
            objImage.style.transform = `translate(${objTranslateX}px, ${objTranslateY}px)`;
    };

    const resetTransform = () => {
        const container = containerRef?.value ?? null;
        const txtImage = txtImageRef?.value ?? null;
        const objImage = objImageRef?.value ?? null;

        if (!container) return;

        // Reset the transform when the mouse leaves the container
        if( tiltFactor > 0 )
            container.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
        if(txtImage)
            txtImage.style.transform = `translate(0px, 0px)`;
        if(objImage)
            objImage.style.transform = `translate(0px, 0px)`;
    };

    return {
        handleMouseMove,
        resetTransform,
    };
}
