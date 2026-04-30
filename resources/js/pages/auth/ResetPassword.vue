<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { update } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Réinitialisation',
        description: 'Veuillez choisir un nouveau mot de passe sécurisé.',
    },
});

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <Head title="Réinitialiser le mot de passe" />

    <Form
        v-bind="update.form()"
        :transform="(data) => ({ ...data, token, email })"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email" class="font-bold text-gray-700 dark:text-gray-300">Email</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    autocomplete="email"
                    v-model="inputEmail"
                    class="rounded-xl border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50"
                    readonly
                />
                <InputError :message="errors.email" class="mt-2" />
            </div>

            <div class="grid gap-2">
                <Label for="password" class="font-bold text-gray-700 dark:text-gray-300">Nouveau mot de passe</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                    autofocus
                    placeholder="••••••••"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation" class="font-bold text-gray-700 dark:text-gray-300"> Confirmer le mot de passe </Label>
                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                    placeholder="••••••••"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-4 w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
                :disabled="processing"
                data-test="reset-password-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                Réinitialiser
            </Button>
        </div>
    </Form>
</template>
