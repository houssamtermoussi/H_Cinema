<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import { edit } from '@/routes/appearance';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Paramètres d'apparence",
                href: edit(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Paramètres d'apparence" />

    <div class="space-y-8">
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Apparence</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-500 font-medium mt-1">Personnalisez l'apparence de votre interface.</p>
        </div>
        
        <div class="bg-gray-50 dark:bg-zinc-950/50 p-8 rounded-3xl border border-gray-100 dark:border-zinc-800">
            <AppearanceTabs />
        </div>
    </div>
</template>
