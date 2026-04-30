<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import reservationRoutes from "@/routes/reservations";
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    seance: any;
}>();

// Flat list of all taken seat IDs for this specific showtime
const takenSeatIds = computed(() => {
    const ids: number[] = [];
    props.seance.reservations.forEach((res: any) => {
        res.reservation_sieges.forEach((rs: any) => ids.push(rs.siege_id));
    });
    return ids;
});

const form = useForm({
    seance_id: props.seance.id,
    siege_ids: [] as number[],
});

const toggleSeat = (seatId: number) => {
    if (takenSeatIds.value.includes(seatId)) return;
    
    const index = form.siege_ids.indexOf(seatId);
    if (index > -1) {
        form.siege_ids.splice(index, 1);
    } else {
        form.siege_ids.push(seatId);
    }
};

const totalPrice = computed(() => (form.siege_ids.length * props.seance.prix).toFixed(2));

const submit = () => {
    if (form.siege_ids.length === 0) return;
    form.post(reservationRoutes.store());
};

// Group seats by row (assuming numero might contain row info or we can group them)
const seats = computed(() => props.seance.salle.sieges);
</script>

<template>
    <Head title="Choix des places" />
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Left: Seat Selection Map -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl md:text-5xl font-black mb-2 tracking-tighter text-gray-900 dark:text-white font-cinzel">SÉLECTIONNEZ VOS PLACES</h1>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Salle {{ seance.salle.nom }} — {{ seance.heure_debut.substring(0, 5) }}</p>
                    </div>

                    <!-- Screen -->
                    <div class="relative py-12">
                        <div class="w-full h-2 bg-gradient-to-r from-transparent via-[#cc0000] to-transparent rounded-full shadow-[0_0_50px_rgba(204,0,0,0.4)] mb-4"></div>
                        <p class="text-center text-[10px] font-black text-gray-400 dark:text-gray-600 tracking-[0.5em] uppercase">ÉCRAN</p>
                    </div>

                    <!-- Seat Map Grid -->
                    <div class="flex flex-col items-center gap-4 overflow-x-auto pb-8 scrollbar-hide">
                        <div class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 gap-3 p-4">
                            <button 
                                v-for="siege in seats" 
                                :key="siege.id"
                                @click="toggleSeat(siege.id)"
                                :disabled="takenSeatIds.includes(siege.id)"
                                class="w-9 h-9 md:w-11 md:h-11 rounded-xl flex items-center justify-center text-[10px] font-bold transition-all duration-300 transform active:scale-90 relative overflow-hidden"
                                :class="[
                                    takenSeatIds.includes(siege.id) 
                                        ? 'bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50' 
                                        : form.siege_ids.includes(siege.id)
                                            ? 'bg-[#cc0000] text-white shadow-[0_0_20px_rgba(204,0,0,0.3)] scale-110 border-2 border-white/20'
                                            : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-[#cc0000] dark:hover:text-[#cc0000] border border-gray-200 dark:border-gray-800'
                                ]"
                            >
                                {{ siege.numero }}
                                <!-- Selection dot -->
                                <div v-if="form.siege_ids.includes(siege.id)" class="absolute bottom-1 right-1 w-1.5 h-1.5 bg-white rounded-full"></div>
                            </button>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-wrap justify-center gap-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-md"></div>
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Disponible</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-[#cc0000] rounded-md shadow-[0_0_15px_rgba(204,0,0,0.2)]"></div>
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Sélectionné</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 opacity-50 rounded-md"></div>
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Indisponible</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary & Checkout -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-8 rounded-[2rem] shadow-2xl shadow-gray-200/50 dark:shadow-none">
                        <div class="flex gap-4 mb-8">
                            <div class="w-20 h-28 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800 flex-shrink-0 shadow-md">
                                <img v-if="seance.film.affiche" :src="seance.film.affiche" class="w-full h-full object-cover" onerror="this.src='/images/posters/default.jpg'" />
                                <div v-else class="w-full h-full bg-gray-100 dark:bg-gray-800"></div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h2 class="text-xl font-black text-gray-900 dark:text-white mb-1 leading-tight font-cinzel">{{ seance.film.titre }}</h2>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">{{ seance.film.type }}</p>
                                <div class="mt-2 flex items-center gap-2 text-[#cc0000] text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ seance.heure_debut.substring(0, 5) }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-gray-500 dark:text-gray-500 uppercase tracking-widest text-[10px]">Places sélectionnées</span>
                                <span class="text-gray-900 dark:text-white">{{ form.siege_ids.length }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-gray-500 dark:text-gray-500 uppercase tracking-widest text-[10px]">Prix par place</span>
                                <span class="text-gray-900 dark:text-white">{{ seance.prix }} €</span>
                            </div>
                            <div class="h-px bg-gray-100 dark:bg-gray-800 my-4"></div>
                            <div class="flex justify-between items-end">
                                <span class="text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest text-xs">Total</span>
                                <span class="text-4xl font-black text-[#cc0000]">{{ totalPrice }} €</span>
                            </div>
                        </div>

                        <button 
                            @click="submit"
                            :disabled="form.siege_ids.length === 0 || form.processing"
                            class="w-full py-5 bg-[#cc0000] hover:bg-red-700 disabled:bg-gray-200 dark:disabled:bg-gray-800 disabled:text-gray-400 dark:disabled:text-gray-600 disabled:cursor-not-allowed text-white font-black text-xl rounded-2xl transition-all duration-300 shadow-xl shadow-red-900/20 flex items-center justify-center gap-3 active:scale-[0.98]"
                        >
                            <span v-if="form.processing">Traitement...</span>
                            <template v-else>
                                Continuer
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </template>
                        </button>

                        <p class="mt-6 text-center text-gray-400 dark:text-gray-500 text-[10px] font-bold uppercase tracking-widest">
                            Transaction sécurisée — Paiement à l'étape suivante
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

