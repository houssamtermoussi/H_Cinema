<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { User, Shield, Palette } from 'lucide-vue-next';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';

const sidebarNavItems = [
    {
        title: 'Profil',
        href: editProfile(),
        icon: User,
    },
    {
        title: 'Sécurité',
        href: editSecurity(),
        icon: Shield,
    },
    {
        title: 'Apparence',
        href: editAppearance(),
        icon: Palette,
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase mb-2">Paramètres</h1>
            <p class="text-gray-500 dark:text-zinc-500 font-medium">Gérez votre profil et vos préférences de compte.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <nav class="space-y-2">
                    <Link
                        v-for="item in sidebarNavItems"
                        :key="item.title"
                        :href="item.href"
                        :class="[
                            'flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all duration-300 border-2',
                            isCurrentOrParentUrl(item.href)
                                ? 'bg-[#cc0000] border-[#cc0000] text-white shadow-[0_0_20px_rgba(204,0,0,0.3)]'
                                : 'bg-white dark:bg-zinc-900/50 border-gray-100 dark:border-zinc-800 text-gray-600 dark:text-zinc-400 hover:border-[#cc0000]/50 hover:text-[#cc0000]'
                        ]"
                    >
                        <component :is="item.icon" class="w-5 h-5" />
                        <span>{{ item.title }}</span>
                    </Link>
                </nav>
            </aside>

            <!-- Content Area -->
            <div class="flex-1 min-w-0">
                <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-xl border-2 border-gray-100 dark:border-zinc-800 rounded-[2.5rem] p-8 md:p-10 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#cc0000]/5 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
