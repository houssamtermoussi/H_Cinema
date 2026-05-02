<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    salles: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Salles', href: '/admin/salles' }
];

const deleteSalle = (id: number) => {
    if (confirm('ÃŠtes-vous sÃ»r de vouloir supprimer cette salle ? Toutes les sÃ©ances et rÃ©servations associÃ©es seront impactÃ©es.')) {
        router.delete(adminRoutes.salles.destroy(id).url);
    }
};
</script>

<template>
    <Head title="Gestion des Salles" />
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
             <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Gestion des Salles</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Configurez vos salles de cinéma.</p>
                </div>
                <Link :href="adminRoutes.salles.create().url" class="px-6 py-3 bg-[#cc0000] text-white font-bold rounded-xl hover:bg-red-700 transition-all flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Nouvelle Salle
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="salle in salles" :key="salle.id" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 text-[#cc0000]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ salle.nom }}</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-center">
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1">Capacité</p>
                            <p class="text-gray-900 dark:text-white font-bold text-2xl">{{ salle.capacite }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-center">
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1">Sièges</p>
                            <p class="text-gray-900 dark:text-white font-bold text-2xl">{{ salle.sieges_count }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <Link :href="adminRoutes.salles.edit(salle.id).url" class="flex-1 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white text-center font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all border border-gray-200 dark:border-gray-600">
                            Modifier
                        </Link>
                        <button @click="deleteSalle(salle.id)" class="px-4 py-3 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl transition-all border border-gray-200 dark:border-gray-700 hover:border-red-600/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>
            </div>
            
             <div v-if="salles.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 mt-6 text-center">
                <p class="text-gray-500 font-medium italic">Aucune salle disponible.</p>
            </div>
        </div>
    </div>
</template>
