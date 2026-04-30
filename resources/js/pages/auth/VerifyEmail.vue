<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { logout } from '@/routes';
import { send } from '@/routes/verification';

defineOptions({
    layout: {
        title: 'Vérification',
        description:
            'Veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Vérification de l'email" />

    <div
        v-if="status === 'verification-link-sent'"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de l'inscription.
    </div>

    <Form
        v-bind="send.form()"
        class="space-y-6 text-center"
        v-slot="{ processing }"
    >
        <Button 
            :disabled="processing" 
            class="w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
        >
            <Spinner v-if="processing" class="mr-2" />
            Renvoyer l'email
        </Button>

        <TextLink :href="logout()" as="button" class="mx-auto block text-sm font-bold text-gray-500 hover:text-[#cc0000]">
            Déconnexion
        </TextLink>
    </Form>
</template>
