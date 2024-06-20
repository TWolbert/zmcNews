<script setup lang="ts">

import NavLink from "@/Components/NavLink.vue";
import { Head, Link } from '@inertiajs/vue3';

// Define props
const props = defineProps<{
    auth: {
        user: {
            name: string,
            pfp_id: number
        }
    } | null
}>();

// Logout function
const logout = () => {
    window.axios.post('/logout').then(() => {
        window.location.reload();
    });
};
</script>

<template>
    <div class="w-full flex flex-row justify-between bg-zinc-900 text-white p-3 shadow-md">
        <div class="flex flex-row gap-5 text-xl items-center">
            <h1 class="font-bold text-xl">ZestMC News</h1>
            <Link href="/">Home</Link>
            <Link href="/status">Status</Link>
            <Link href="/videos">Videos</Link>
            <Link href="/blogs">Blog</Link>
        </div>
        <div class=" flex gap-5 font-bold" v-if="!props.auth.user">
            <Link href="/login" class="bg-zinc-800 text-white px-3 py-1 rounded-md">Login</Link>
            <Link href="/register" class="bg-purple-800 text-white px-3 py-1 rounded-md">Register</Link>
        </div>
        <div class="flex gap-5 font-bold" v-else>
            <Link href="/profile" class="bg-zinc-800 text-white px-3 py-1 rounded-md flex gap-2 items-center">
                <img :src="`/api/pfp/${props.auth.user.pfp_id}`" alt="Profile Picture" class="rounded-full h-10 w-10" />
                {{ props.auth.user.name}}
            </Link>
            <button @click="logout" class="bg-red-800 text-white px-3 py-1 rounded-md flex items-center">Logout</button>
        </div>
    </div>
</template>

<style scoped>

</style>
