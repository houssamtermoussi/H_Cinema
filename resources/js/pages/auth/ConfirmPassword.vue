<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/password/confirm';

defineOptions({
    layout: {
        title: 'Confirmation',
        description:
            'Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.',
    },
});
</script>

<template>
    <Head title="Confirmer le mot de passe" />

    <Form
        v-bind="store.form()"
        reset-on-success
        v-slot="{ errors, processing }"
    >
        <div class="space-y-6">
            <div class="grid gap-2">
                <Label for="password" class="font-bold text-gray-700 dark:text-gray-300">Mot de passe</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />

                <InputError :message="errors.password" />
            </div>

            <div class="flex items-center">
                <Button
                    class="w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
                    :disabled="processing"
                    data-test="confirm-password-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    Confirmer
                </Button>
            </div>
        </div>
    </Form>
</template>
