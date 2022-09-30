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
        <h1 class="text-xl mb-2">
          Your Benchmarks
        </h1>
        <div class="bg-white">
          <div class="p-6 w-full">
            <div v-if="user.servers.length == 0">
              <h1>
                You have no submitted benchmarks to display. Click the link
                on the bar above to submit one!
              </h1>
            </div>

            <ServerTable v-else
            :options_open=false
            :user=user
            :passed_servers=user.servers
            :passed_server_count=passed_server_count
            ></ServerTable>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/inertia-vue3';
  import ServerTable from '@/Components/ServerList/ServerTable.vue';
  
  export default {
    props: [
      'user',
      'passed_server_count'
    ],
    components: {
    Head,
    ServerTable,
  },
    layout: AuthenticatedLayout,
    data() {
      return {
        options_open: true
      }
    },
    mounted() {
      console.log('Dashboard')
      Window.innerWidth >= 768 ? this.options_open = true : this.options_open = false
    }
  }
  </script>
