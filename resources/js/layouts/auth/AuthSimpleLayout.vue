<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-gray-50 dark:bg-gray-950 p-6 md:p-10 transition-colors duration-300"
    >
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-6">
                    <Link
                        :href="home()"
                        class="flex flex-col items-center gap-3 group"
                    >
                        <div
                            class="flex h-20 w-auto items-center justify-center rounded-2xl p-2 transition-transform duration-300 group-hover:scale-110"
                        >
                            <img src="/images/logo2.png" alt="H-Cinema Logo" class="h-16 w-auto drop-shadow-[0_0_15px_rgba(204,0,0,0.3)]" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white font-cinzel">{{ title }}</h1>
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-[2rem] shadow-2xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-cinzel {
    font-family: 'Cinzel', serif;
}
</style>
