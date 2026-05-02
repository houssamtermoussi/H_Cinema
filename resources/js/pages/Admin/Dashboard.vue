<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import admin from "@/routes/admin";
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    stats: {
        total_revenue: number;
        total_films: number;
        total_seances: number;
        total_reservations: number;
    };
    most_booked_films: any[];
    revenue_by_month: any[];
}>();

const chartRef = ref<HTMLCanvasElement | null>(null);

onMounted(() => {
    if (typeof window !== 'undefined' && chartRef.value) {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = () => {
            const ctx = chartRef.value?.getContext('2d');
            if (ctx && props.revenue_by_month.length > 0) {
                // @ts-ignore
                new window.Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: props.revenue_by_month.map(item => item.month),
                        datasets: [{
                            label: 'Revenus (€)',
                            data: props.revenue_by_month.map(item => item.total),
                            borderColor: '#cc0000',
                            backgroundColor: 'rgba(204, 0, 0, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#cc0000',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        };
        document.head.appendChild(script);
    }
});

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <!-- Header -->
            <header class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel">Administration</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Gestion globale de H-Cinema.</p>
            </header>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 flex flex-col">
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Revenus Totaux</span>
                    <span class="text-3xl font-black text-[#cc0000]">{{ formatCurrency(stats.total_revenue) }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 flex flex-col">
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Films à l'Affiche</span>
                    <span class="text-3xl font-black text-gray-900 dark:text-white">{{ stats.total_films }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 flex flex-col">
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Séances Planifiées</span>
                    <span class="text-3xl font-black text-gray-900 dark:text-white">{{ stats.total_seances }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 flex flex-col">
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Réservations</span>
                    <span class="text-3xl font-black text-gray-900 dark:text-white">{{ stats.total_reservations }}</span>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Évolution des Revenus</h3>
                    <div class="h-64 relative">
                        <canvas ref="chartRef"></canvas>
                        <div v-if="revenue_by_month.length === 0" class="absolute inset-0 flex items-center justify-center text-gray-400 font-medium">
                            Pas encore de données de revenus.
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex flex-col gap-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Actions Rapides</h3>
                    <Link :href="admin.films.index().url" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all flex justify-between items-center border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-gray-900 dark:text-white">Films</span>
                            <span class="text-gray-500 text-sm">Gérer le catalogue</span>
                        </div>
                        <svg class="w-6 h-6 text-[#cc0000] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </Link>
                    <Link :href="admin.salles.index().url" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all flex justify-between items-center border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-gray-900 dark:text-white">Salles</span>
                            <span class="text-gray-500 text-sm">Configuration et sièges</span>
                        </div>
                        <svg class="w-6 h-6 text-[#cc0000] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </Link>
                    <Link :href="admin.seances.index().url" class="group bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all flex justify-between items-center border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-gray-900 dark:text-white">Séances</span>
                            <span class="text-gray-500 text-sm">Planning horaires</span>
                        </div>
                        <svg class="w-6 h-6 text-[#cc0000] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </Link>
                </div>
            </div>

            <!-- Top Films Table -->
            <div class="mt-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Films les plus réservés</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="pb-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Film</th>
                                <th class="pb-4 text-gray-500 text-xs font-bold uppercase tracking-wider text-right">Réservations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                            <tr v-for="film in most_booked_films" :key="film.id" class="group hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all">
                                <td class="py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 rounded-lg bg-gray-100 dark:bg-gray-900 overflow-hidden border border-gray-100 dark:border-gray-700">
                                            <img v-if="film.affiche" :src="film.affiche" class="w-full h-full object-cover" />
                                        </div>
                                        <span class="font-bold text-gray-900 dark:text-white group-hover:text-[#cc0000] transition-colors">{{ film.titre }}</span>
                                    </div>
                                </td>
                                <td class="py-4 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 dark:bg-red-900/20 text-[#cc0000] font-bold text-sm">
                                        {{ film.reservations_count }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="most_booked_films.length === 0">
                                <td colspan="2" class="py-10 text-center text-gray-400 font-medium">Aucune donnée disponible.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.font-cinzel { font-family: 'Cinzel', serif; }
</style>
