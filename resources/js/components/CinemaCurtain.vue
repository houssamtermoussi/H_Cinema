<template>
    <div v-if="isVisible" class="cinema-curtain-container z-[100000] fixed inset-0 flex overflow-hidden pointer-events-none">
        <!-- Left Curtain -->
        <div ref="leftCurtain" class="curtain left-curtain w-[50.1%] h-full origin-top-left relative pointer-events-auto shadow-[20px_0_50px_rgba(0,0,0,0.8)] mr-[-1px]">
            <!-- Base folds -->
            <div class="absolute inset-0 curtain-folds"></div>
            <!-- Dynamic shadows/highlights -->
            <div class="absolute inset-0 curtain-shadows"></div>
            <!-- Bottom fringe/tassel -->
            <div class="absolute bottom-0 left-0 right-0 h-[6vh] curtain-fringe"></div>
        </div>
        
        <!-- Right Curtain -->
        <div ref="rightCurtain" class="curtain right-curtain w-[50.1%] h-full origin-top-right relative pointer-events-auto shadow-[-20px_0_50px_rgba(0,0,0,0.8)] ml-[-1px]">
            <!-- Base folds -->
            <div class="absolute inset-0 curtain-folds"></div>
            <!-- Dynamic shadows/highlights -->
            <div class="absolute inset-0 curtain-shadows"></div>
            <!-- Bottom fringe/tassel -->
            <div class="absolute bottom-0 left-0 right-0 h-[6vh] curtain-fringe"></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap';

const leftCurtain = ref<HTMLElement | null>(null);
const rightCurtain = ref<HTMLElement | null>(null);
const isVisible = ref(true);

onMounted(() => {
    // Check if the curtain has already been shown in this session
    if (sessionStorage.getItem('curtainShown')) {
        isVisible.value = false;
        return;
    }
    
    // Mark as shown for the rest of the session
    sessionStorage.setItem('curtainShown', 'true');

    // Hide the static placeholder from app.blade.php as the dynamic component takes over
    const placeholder = document.getElementById('curtain-placeholder');
    if (placeholder) {
        placeholder.style.display = 'none';
    }

    // Initial slight breathing effect before opening to simulate heavy fabric settling
    const tl = gsap.timeline({
        onComplete: () => {
            isVisible.value = false;
            // Dispatch an event so the parent knows the animation is done
            document.dispatchEvent(new Event('curtain-opened'));
        }
    });

    // Subtly scale the fabric to simulate breathing/settling
    tl.to([leftCurtain.value, rightCurtain.value], {
        scaleX: 1.01,
        scaleY: 1.01,
        duration: 1.2,
        yoyo: true,
        repeat: 1,
        ease: "sine.inOut"
    });

    // The opening animation
    // By scaling X to 0, the background gradients compress, creating a highly realistic folding effect
    // We add a slight skew to simulate the fabric dragging slightly at the bottom
    tl.to(leftCurtain.value, {
        scaleX: 0,
        skewX: -2,
        skewY: 1,
        duration: 3.5,
        ease: "power2.inOut"
    }, "open");

    tl.to(rightCurtain.value, {
        scaleX: 0,
        skewX: 2,
        skewY: -1,
        duration: 3.5,
        ease: "power2.inOut"
    }, "open");
});
</script>

<style scoped>
.cinema-curtain-container {
    perspective: 1200px;
    background-color: transparent;
}

.curtain {
    background-color: #6b0000;
    overflow: hidden;
    will-change: transform;
}

/* Base repeating linear gradient to simulate the fabric's natural vertical folds */
.curtain-folds {
    background: repeating-linear-gradient(
        to right,
        #3a0000 0%,
        #6b0000 3%,
        #aa0000 6%,
        #e60000 8%,
        #aa0000 10%,
        #6b0000 13%,
        #3a0000 16%
    );
    z-index: 1;
}

/* A secondary layer of gradient to create deep shadows and rounded highlights (depth effect) */
.curtain-shadows {
    background: linear-gradient(
        to right,
        rgba(0, 0, 0, 0.8) 0%,
        rgba(255, 255, 255, 0.05) 5%,
        rgba(255, 255, 255, 0.15) 15%,
        rgba(0, 0, 0, 0.5) 25%,
        rgba(0, 0, 0, 0.7) 35%,
        rgba(255, 255, 255, 0.05) 45%,
        rgba(255, 255, 255, 0.1) 55%,
        rgba(0, 0, 0, 0.6) 65%,
        rgba(0, 0, 0, 0.8) 75%,
        rgba(255, 255, 255, 0.1) 85%,
        rgba(0, 0, 0, 0.7) 100%
    );
    mix-blend-mode: multiply;
    z-index: 2;
}

/* Luxurious gold fringe/tassel at the bottom of the curtain */
.curtain-fringe {
    background: linear-gradient(to bottom, rgba(0,0,0,0.5), transparent),
                repeating-linear-gradient(
                    to right,
                    #d4af37 0px,
                    #ffd700 2px,
                    #b8860b 4px,
                    #d4af37 6px
                );
    box-shadow: 0 -5px 15px rgba(0,0,0,0.6);
    z-index: 3;
    opacity: 0.95;
    border-top: 3px solid #8b6508;
}

/* Add an extra shadow edge where the two curtains meet */
.left-curtain::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 20px;
    background: linear-gradient(to left, rgba(0,0,0,0.8), transparent);
    z-index: 4;
}

.right-curtain::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 20px;
    background: linear-gradient(to right, rgba(0,0,0,0.8), transparent);
    z-index: 4;
}
</style>
