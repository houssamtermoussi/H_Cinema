<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    reservation: any;
    montant: number;
}>();

const breadcrumbs = [
    { title: 'Réservations', href: '/reservations' },
    { title: 'Paiement', href: '#' }
];

const isProcessing = ref(false);

const submit = () => {
    isProcessing.value = true;
    router.post(route('paiements.store'), {
        reservation_id: props.reservation.id
    });
};
</script>

<template>
    <Head title="Paiement Sécurisé" />
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 flex flex-col items-center py-12 md:py-20 px-4 md:px-8 relative overflow-hidden transition-colors duration-300">
        <!-- Background Decorative Elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#cc0000]/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#cc0000]/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-2xl w-full relative z-10">
            <div class="text-center mb-12 md:mb-16">
                <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-white dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-800 rounded-[2rem] mb-8 shadow-xl group transition-transform hover:scale-105 duration-500">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-[#cc0000] group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tighter uppercase leading-none font-cinzel">Paiement Sécurisé</h1>
                <div class="h-1.5 w-24 bg-[#cc0000] mx-auto rounded-full mb-6 shadow-lg shadow-red-600/20"></div>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-lg max-w-md mx-auto">
                    Finalisez votre réservation pour l'expérience cinématographique <span class="text-gray-900 dark:text-white font-bold">{{ reservation.seance.film.titre }}</span>
                </p>
            </div>

            <div class="bg-white dark:bg-gray-900/40 backdrop-blur-2xl border border-gray-200 dark:border-gray-800/50 rounded-[2.5rem] md:rounded-[3.5rem] overflow-hidden shadow-2xl border-t-white/10 dark:border-t-white/5">
                <!-- Order Details Header -->
                <div class="p-8 md:p-12 border-b border-gray-100 dark:border-gray-800/50 bg-gray-50/50 dark:bg-gray-900/20">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                        <div class="space-y-1">
                            <h3 class="text-gray-400 dark:text-gray-500 text-xs font-black uppercase tracking-[0.3em] mb-2">Total de la commande</h3>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl md:text-6xl font-black text-gray-900 dark:text-white tracking-tighter leading-none">{{ montant.toFixed(2) }}</span>
                                <span class="text-xl md:text-2xl font-black text-[#cc0000] uppercase tracking-widest">€</span>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-950/50 border border-gray-100 dark:border-gray-800 p-6 rounded-3xl flex items-center gap-6 min-w-[200px] shadow-sm">
                            <div class="w-12 h-12 bg-[#cc0000]/10 rounded-2xl flex items-center justify-center border border-[#cc0000]/20">
                                <svg class="w-6 h-6 text-[#cc0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-gray-400 dark:text-gray-500 text-[10px] font-black uppercase tracking-widest">Places</h4>
                                <p class="text-2xl font-black text-gray-900 dark:text-white">{{ reservation.nombre_places }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Actions -->
                <div class="p-8 md:p-12 space-y-10">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 text-gray-500 dark:text-gray-400">
                            <div class="w-10 h-10 rounded-full border border-gray-200 dark:border-gray-800 flex items-center justify-center text-sm font-bold">1</div>
                            <p class="text-sm font-bold uppercase tracking-widest">Confirmation des détails</p>
                        </div>
                        <div class="flex items-center gap-4 text-gray-400 dark:text-gray-500 opacity-50">
                            <div class="w-10 h-10 rounded-full border border-gray-200 dark:border-gray-800 flex items-center justify-center text-sm font-bold">2</div>
                            <p class="text-sm font-bold uppercase tracking-widest">Paiement sécurisé via Stripe</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button 
                            @click="submit"
                            :disabled="isProcessing"
                            class="w-full py-6 md:py-7 bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-[#cc0000] dark:hover:bg-[#cc0000] hover:text-white dark:hover:text-white font-black text-xl md:text-2xl rounded-3xl transition-all duration-500 shadow-xl hover:shadow-[#cc0000]/20 flex items-center justify-center gap-4 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none group"
                        >
                            <span v-if="isProcessing" class="flex items-center gap-3">
                                <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Initialisation...
                            </span>
                            <template v-else>
                                PROCÉDER AU PAIEMENT
                                <svg class="w-6 h-6 md:w-8 md:h-8 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </template>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Trust Badge -->
            <div class="mt-12 md:mt-16 flex flex-col items-center gap-6">
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/2560px-Stripe_Logo%2C_revised_2016.svg.png" alt="Stripe" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="h-8">
                </div>
                <p class="text-gray-400 dark:text-gray-600 text-[10px] font-black uppercase tracking-[0.4em] text-center max-w-xs leading-loose">
                    Sécurité Bancaire de niveau Entreprise — Chiffrement AES-256 bits — Conforme PCI-DSS
                </p>
            </div>
        </div>
    </div>
</template>
