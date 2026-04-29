<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, LayoutGrid, Film, Ticket, Clapperboard, Calendar, DoorOpen, ShieldCheck } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard, films, reservations, admin as adminRoutes } from '@/routes';
import type { NavItem } from '@/types';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const mainNavItems = computed((): NavItem[] => [
    {
        title: 'Dashboard',
        href: dashboard().url,
        icon: LayoutGrid,
    },
    {
        title: 'Films à l\'affiche',
        href: films.index().url,
        icon: Film,
    },
    {
        title: 'Mes Réservations',
        href: reservations.index().url,
        icon: Ticket,
    },
]);

const adminNavItems = computed((): NavItem[] => {
    if (user.value?.role !== 'admin') return [];
    
    return [
        {
            title: 'Catalogue Films',
            href: adminRoutes.films.index().url,
            icon: Clapperboard,
        },
        {
            title: 'Planning Séances',
            href: adminRoutes.seances.index().url,
            icon: Calendar,
        },
        {
            title: 'Gestion Salles',
            href: adminRoutes.salles.index().url,
            icon: DoorOpen,
        },
        {
            title: 'Toutes les Réservations',
            href: adminRoutes.reservations.index().url,
            icon: ShieldCheck,
        },
    ];
});

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/houssamtermoussi/H_Cinema',
        icon: FolderGit2,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard().url">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" label="Plateforme" />
            <NavMain v-if="adminNavItems.length > 0" :items="adminNavItems" label="Administration" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
