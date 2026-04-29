<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { reservations as reservationRoutes } from '@/routes';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    seance: any;
}>();

const breadcrumbs = [
    { title: 'Films', href: '/films' },
    { title: props.seance.film.titre, href: `/films/${props.seance.film.id}` },
    { title: 'Choix des places', href: `/seances/${props.seance.id}` }
];

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
// For simplicity, we'll just display them in a grid based on the room capacity.
const seats = computed(() => props.seance.salle.sieges);
</script>

<template>
    <Head title="Choix des places" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-black text-white p-8 md:p-12">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Left: Seat Selection Map -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="text-center">
                        <h1 class="text-4xl font-black mb-2 tracking-tighter">SÉLECTIONNEZ VOS PLACES</h1>
                        <p class="text-zinc-500 font-medium">Salle {{ seance.salle.nom }} — {{ seance.heure_debut.substring(0, 5) }}</p>
                    </div>

                    <!-- Screen -->
                    <div class="relative py-12">
                        <div class="w-full h-2 bg-gradient-to-r from-transparent via-red-600 to-transparent rounded-full shadow-[0_0_50px_rgba(220,38,38,0.5)] mb-4"></div>
                        <p class="text-center text-[10px] font-black text-zinc-700 tracking-[0.5em] uppercase">ÉCRAN</p>
                    </div>

                    <!-- Seat Map Grid -->
                    <div class="flex flex-col items-center gap-4 overflow-x-auto pb-8">
                        <div class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 gap-3 p-4">
                            <button 
                                v-for="siege in seats" 
                                :key="siege.id"
                                @click="toggleSeat(siege.id)"
                                :disabled="takenSeatIds.includes(siege.id)"
                                class="w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center text-[10px] font-bold transition-all duration-300 transform active:scale-90"
                                :class="[
                                    takenSeatIds.includes(siege.id) 
                                        ? 'bg-zinc-800 text-zinc-600 cursor-not-allowed opacity-50' 
                                        : form.siege_ids.includes(siege.id)
                                            ? 'bg-red-600 text-white shadow-[0_0_20px_rgba(220,38,38,0.4)] scale-110 border-2 border-white/20'
                                            : 'bg-zinc-900 text-zinc-400 hover:bg-zinc-800 hover:text-white border border-zinc-800'
                                ]"
                            >
                                {{ siege.numero }}
                            </button>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-wrap justify-center gap-8 pt-8 border-t border-zinc-900">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-zinc-900 border border-zinc-800 rounded-md"></div>
                            <span class="text-sm font-bold text-zinc-400">Disponible</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-red-600 rounded-md shadow-[0_0_15px_rgba(220,38,38,0.3)]"></div>
                            <span class="text-sm font-bold text-zinc-400">Sélectionné</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-zinc-800 opacity-50 rounded-md"></div>
                            <span class="text-sm font-bold text-zinc-400">Indisponible</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary & Checkout -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 bg-zinc-900/50 backdrop-blur-xl border border-zinc-800 p-8 rounded-[2rem] shadow-2xl">
                        <div class="flex gap-4 mb-8">
                            <div class="w-20 h-28 rounded-xl overflow-hidden border border-zinc-800 flex-shrink-0">
                                <img v-if="seance.film.affiche" :src="seance.film.affiche" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full bg-zinc-950"></div>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-white mb-1 leading-tight">{{ seance.film.titre }}</h2>
                                <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">{{ seance.film.type }}</p>
                                <div class="mt-2 flex items-center gap-2 text-red-500 text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ seance.heure_debut.substring(0, 5) }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-zinc-500 uppercase tracking-widest text-[10px]">Places sélectionnées</span>
                                <span class="text-white">{{ form.siege_ids.length }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold">
                                <span class="text-zinc-500 uppercase tracking-widest text-[10px]">Prix par place</span>
                                <span class="text-white">{{ seance.prix }}€</span>
                            </div>
                            <div class="h-px bg-zinc-800 my-4"></div>
                            <div class="flex justify-between items-end">
                                <span class="text-zinc-500 font-black uppercase tracking-widest text-xs">Total</span>
                                <span class="text-4xl font-black text-red-500">{{ totalPrice }}€</span>
                            </div>
                        </div>

                        <button 
                            @click="submit"
                            :disabled="form.siege_ids.length === 0 || form.processing"
                            class="w-full py-5 bg-red-600 hover:bg-red-500 disabled:bg-zinc-800 disabled:text-zinc-600 disabled:cursor-not-allowed text-white font-black text-xl rounded-2xl transition-all duration-300 shadow-xl shadow-red-900/20 flex items-center justify-center gap-3"
                        >
                            <span v-if="form.processing">Traitement...</span>
                            <template v-else>
                                Continuer
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </template>
                        </button>

                        <p class="mt-6 text-center text-zinc-600 text-[10px] font-bold uppercase tracking-widest">
                            Transaction sécurisée — Paiement à l'étape suivante
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
