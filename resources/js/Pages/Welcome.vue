<script setup>
import axios from 'axios';
import ServerList from '../Components/ServerList/ServerTable.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<script>


export default {
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        passedServers: Array
    },
    data() {
        return {
            servers: [],
            options_open: false,
            show_columns: {
                user: false,
                provider_name: true,
                when: false,
                city: true,
                cpu: true,
                cores: true,
                clock_speed: false,
                ram: true,
                swap: false,
                distro: false,
                kernel: false,
                aes_ni: false,
                vm_x: false,
                disk_4k_read_speed: false,
                disk_4k_write_speed: false,
                disk_4k_total_speed: true,
                disk_4k_read_iops: false,
                disk_4k_write_iops: false,
                disk_4k_total_iops: true,
                disk_64k_read_speed: false,
                disk_64k_write_speed: false,
                disk_64k_total_speed: false,
                disk_64k_read_iops: false,
                disk_64k_write_iops: false,
                disk_64k_total_iops: false,
                disk_512k_read_speed: false,
                disk_512k_write_speed: false,
                disk_512k_total_speed: false,
                disk_512k_read_iops: false,
                disk_512k_write_iops: false,
                disk_512k_total_iops: false,
                disk_1m_read_speed: false,
                disk_1m_write_speed: false,
                disk_1m_total_speed: false,
                disk_1m_read_iops: false,
                disk_1m_write_iops: false,
                disk_1m_total_iops: false,
                geekbench_5_single: true,
                geekbench_5_multi: true,
                type: true,
                virtualization: false
            }
        }
    },
    methods: {
        search() {
            axios.post()
        }
    },
    mounted() {
        console.log(this.canLogin)
        this.servers = this.passedServers
    }
}
</script>

<template>
    <Head title="YABS List" />

    <div class="pb-[400px] bg-gray-100">
        <div class=" relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 h-20">
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Your Servers</Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
                </template>
            </div>
        </div>

        <div class="max-w-10xl mx-auto sm:px-2 lg:px-8">
            <div class="flex justify-center">
                <button @click="options_open = true"
                class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-none px-4 py-2 mb-3">Open Options</button>

                <select class="h-10 ml-5">
                    <option>20</option>
                    <option>100</option>
                    <option>200</option>
                    <option>500</option>
                </select>
            </div>


        </div>

        <div class="bg-gray-100 flex justify-center max-w-10xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white rounded sm:items-center sm:justify-between h-5/6 mb-400 p-10 shadow">
                <ServerList :passedServers=passedServers></ServerList>
            </div>
        </div>
    </div>

</template>
