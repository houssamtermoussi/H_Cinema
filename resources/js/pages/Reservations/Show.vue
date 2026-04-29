<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    reservation: any;
}>();

const breadcrumbs = [
    { title: 'Mes Réservations', href: '/reservations' },
    { title: `Billet #${props.reservation.id}`, href: `/reservations/${props.reservation.id}` }
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Votre Ticket" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-black flex flex-col items-center py-20 px-8">
            <div class="max-w-2xl w-full">
                
                <!-- Ticket Container -->
                <div class="bg-zinc-900 border border-zinc-800/50 rounded-[3.5rem] overflow-hidden shadow-[0_50px_100px_rgba(0,0,0,0.7)] flex flex-col group transition-all duration-700 hover:shadow-red-900/10">
                    
                    <!-- Header/Poster section -->
                    <div class="relative h-80 overflow-hidden">
                        <img v-if="reservation.seance.film.affiche" :src="reservation.seance.film.affiche" class="w-full h-full object-cover opacity-60 blur-sm scale-110 group-hover:scale-100 transition-transform duration-1000" />
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/60 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-10 text-center">
                            <span class="inline-block px-4 py-1.5 bg-red-600 text-[10px] font-black uppercase rounded-full text-white tracking-widest mb-4 shadow-xl shadow-red-600/30">{{ reservation.seance.film.type }}</span>
                            <h1 class="text-5xl md:text-6xl font-black text-white tracking-tighter mb-3 leading-none drop-shadow-2xl">{{ reservation.seance.film.titre }}</h1>
                            <div class="w-16 h-1 bg-red-600 rounded-full mt-2"></div>
                        </div>
                    </div>
                    
                    <!-- The Perforation -->
                    <div class="relative flex items-center px-16">
                        <!-- Cutouts -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-20 bg-black rounded-r-full border-r border-zinc-800/50 shadow-[inset_-10px_0_20px_rgba(0,0,0,0.5)]"></div>
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-20 bg-black rounded-l-full border-l border-zinc-800/50 shadow-[inset_10px_0_20px_rgba(0,0,0,0.5)]"></div>
                        
                        <!-- Dashed line -->
                        <div class="w-full border-t-4 border-dashed border-zinc-800/80"></div>
                    </div>
                    
                    <!-- Details section -->
                    <div class="px-16 py-12">
                        <div class="grid grid-cols-3 gap-10 mb-16">
                            <div class="space-y-2">
                                <span class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest">Date de séance</span>
                                <span class="block text-2xl font-black text-white tracking-tighter">{{ formatDate(reservation.seance.date_seance) }}</span>
                            </div>
                            <div class="space-y-2 border-x border-zinc-800/50 px-8 text-center">
                                <span class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest">Horaire</span>
                                <span class="block text-2xl font-black text-white tracking-tighter">{{ reservation.seance.heure_debut.substring(0, 5) }}</span>
                            </div>
                            <div class="space-y-2 text-right">
                                <span class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest">Salle de cinéma</span>
                                <span class="block text-2xl font-black text-red-500 tracking-tighter">{{ reservation.seance.salle.nom }}</span>
                            </div>
                        </div>
                        
                        <!-- Seat badges -->
                        <div class="flex flex-wrap items-center justify-center gap-3 mb-16">
                            <div v-for="rs in reservation.reservation_sieges" :key="rs.id" class="px-6 py-3 bg-zinc-950 border border-zinc-800 rounded-2xl flex flex-col items-center min-w-[90px] shadow-lg group-hover:border-red-600/30 transition-colors">
                                <span class="text-[9px] font-black text-zinc-600 uppercase tracking-widest mb-1">Siège</span>
                                <span class="text-2xl font-black text-white">{{ rs.siege.numero }}</span>
                            </div>
                        </div>
                        
                        <!-- QR Code Area -->
                        <div class="flex flex-col items-center">
                            <div class="bg-white p-6 rounded-[2.5rem] shadow-[0_20px_50px_rgba(255,255,255,0.05)] mb-8 transform transition-transform group-hover:scale-105 duration-500">
                                <div class="w-40 h-40 bg-zinc-50 flex items-center justify-center border-[6px] border-black overflow-hidden rounded-xl">
                                    <!-- Simple QR Pattern Mockup -->
                                    <div class="grid grid-cols-6 gap-0.5 w-full h-full p-2">
                                        <div v-for="i in 36" :key="i" :class="Math.random() > 0.5 ? 'bg-black' : 'bg-transparent'"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-zinc-500 font-black text-[11px] uppercase tracking-[0.5em] mb-4">VOTRE PASS CINÉMA</p>
                            <p class="text-zinc-600 text-xs text-center max-w-[280px] font-medium leading-relaxed">
                                Présentez ce code à la borne ou à l'entrée de la salle. Ce billet est unique et strictement personnel.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Footer of the ticket -->
                    <div class="bg-zinc-950/50 px-16 py-6 border-t border-zinc-800/50 flex justify-between items-center">
                        <div class="text-[9px] font-black text-zinc-700 uppercase tracking-widest">
                            RÉSERVATION #{{ String(reservation.id).padStart(8, '0') }}
                        </div>
                        <div class="text-[9px] font-black text-zinc-700 uppercase tracking-widest">
                            H-CINEMA PREMIUM EXPERIENCE
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-16 flex flex-col sm:flex-row justify-center gap-6 no-print">
                    <button onclick="window.print()" class="flex-1 px-8 py-5 bg-zinc-900 border border-zinc-800 text-white font-black rounded-2xl hover:bg-zinc-800 transition-all flex items-center justify-center gap-3 shadow-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2z" /></svg>
                        Imprimer mon billet
                    </button>
                    <Link href="/films" class="flex-1 px-8 py-5 bg-white text-black font-black text-lg rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 flex items-center justify-center gap-3 shadow-xl">
                         Découvrir d'autres films
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>

    <style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .bg-zinc-900 { background: #f4f4f5 !important; color: black !important; border: 1px solid #e4e4e7 !important; }
        .text-white { color: black !important; }
        .text-zinc-400, .text-zinc-500, .text-zinc-600 { color: #52525b !important; }
        .bg-black { background: white !important; }
        .bg-zinc-950 { background: white !important; }
        .shadow-2xl, .shadow-xl { shadow: none !important; }
    }
    </style>
</template>
