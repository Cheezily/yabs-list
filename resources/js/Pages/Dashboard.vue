<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import ServerTable from '@/Components/ServerList/ServerTable.vue';

export default {
    components: {
    Head,
    ServerTable,
},
    layout: AuthenticatedLayout,
    props: {
        user: Object
    },
    data() {
        return {}
    },
    mounted() {
        console.log('helllooooo')
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <ServerTable 
                        :options_open=false
                        :user=user
                        :servers=user.servers
                        ></ServerTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
