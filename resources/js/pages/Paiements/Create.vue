<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { paiements as paiementRoutes } from '@/routes';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    reservation: any;
    montant: number;
}>();

const breadcrumbs = [
    { title: 'Réservations', href: '/reservations' },
    { title: 'Paiement', href: '#' }
];

const form = useForm({
    reservation_id: props.reservation.id,
    methode_paiement: 'carte_bancaire',
});

const submit = () => {
    form.post(paiementRoutes.store());
};
</script>

<template>
    <Head title="Paiement Sécurisé" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-zinc-950 flex flex-col items-center py-20 px-8">
            <div class="max-w-xl w-full">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-zinc-900 rounded-3xl border border-zinc-800 mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    </div>
                    <h1 class="text-4xl font-black text-white mb-2 tracking-tighter">PAIEMENT SÉCURISÉ</h1>
                    <p class="text-zinc-500 font-medium">Finalisez votre réservation pour {{ reservation.seance.film.titre }}</p>
                </div>

                <div class="bg-zinc-900/50 backdrop-blur-xl border border-zinc-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <!-- Order Summary -->
                    <div class="p-10 border-b border-zinc-800/50 bg-zinc-900/30">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1">Montant à régler</h3>
                                <p class="text-5xl font-black text-white tracking-tighter">{{ montant.toFixed(2) }}€</p>
                            </div>
                            <div class="text-right">
                                <h3 class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1">Places</h3>
                                <p class="text-2xl font-black text-red-500">{{ reservation.nombre_places }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="p-10 space-y-8">
                        <div>
                            <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-4">Mode de paiement</label>
                            <div class="grid grid-cols-2 gap-4">
                                <button 
                                    @click="form.methode_paiement = 'carte_bancaire'"
                                    :class="form.methode_paiement === 'carte_bancaire' ? 'border-red-600 bg-red-600/10 text-white' : 'border-zinc-800 bg-zinc-950 text-zinc-500'"
                                    class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 transition-all font-bold"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    Carte Bancaire
                                </button>
                                <button 
                                    @click="form.methode_paiement = 'paypal'"
                                    :class="form.methode_paiement === 'paypal' ? 'border-red-600 bg-red-600/10 text-white' : 'border-zinc-800 bg-zinc-950 text-zinc-500'"
                                    class="p-4 rounded-2xl border-2 flex flex-col items-center justify-center gap-2 transition-all font-bold"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    PayPal
                                </button>
                            </div>
                        </div>

                        <!-- Fake Form Fields -->
                        <div v-if="form.methode_paiement === 'carte_bancaire'" class="space-y-4">
                            <div class="bg-zinc-950 p-6 rounded-2xl border border-zinc-800">
                                <p class="text-zinc-600 text-sm italic">Ceci est une simulation. Cliquez sur "Confirmer le paiement" pour valider.</p>
                            </div>
                        </div>

                        <button 
                            @click="submit"
                            :disabled="form.processing"
                            class="w-full py-5 bg-white text-black hover:bg-red-600 hover:text-white font-black text-xl rounded-2xl transition-all duration-300 shadow-xl shadow-white/5 flex items-center justify-center gap-3 active:scale-95"
                        >
                            <span v-if="form.processing">Validation...</span>
                            <template v-else>
                                Confirmer le paiement
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </template>
                        </button>
                    </div>
                </div>

                <p class="mt-12 text-center text-zinc-600 text-[10px] font-black uppercase tracking-[0.2em]">
                    Certifié SSL — Sécurité Bancaire niveau 4
                </p>
            </div>
        </div>
    </AppLayout>
</template>
