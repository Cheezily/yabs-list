<script setup>
import axios from 'axios';
import ServerList from '../Components/ServerList/ServerTable.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<script>


export default {
    props: {
        can_login: Boolean,
        can_register: Boolean,
        passed_servers: Array,
        server_count: Number
    },
    data() {
        return {
            servers: [],
        }
    },
    methods: {
        search() {
            axios.post()
        },
    },
    mounted() {
        console.log(this.passed_servers)
        this.servers = this.passed_servers
    }
}
</script>

<template>
    <Head title="YABS List" />

    <div class="pb-[400px] bg-gray-100">
        <div class=" relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 h-16">
            <div v-if="false && can_login" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Your Servers</Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                    <Link v-if="can_register" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
                </template>
            </div>
        </div>

        <div class="bg-gray-100 flex justify-center max-w-10xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white rounded sm:items-center sm:justify-between h-5/6 mb-400 p-6 shadow">
                <ServerList 
                :passed_server_count=server_count 
                :passed_servers=passed_servers>
                </ServerList>
            </div>
        </div>
    </div>

</template>
