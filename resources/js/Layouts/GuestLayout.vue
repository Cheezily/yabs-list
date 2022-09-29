<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <Link href="/">
                <h1 class="logo mr-6">YABSLIST</h1>
            </Link>
        </div>

        <div class="bg-gray-200 w-full sm:max-w-md mt-3 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
