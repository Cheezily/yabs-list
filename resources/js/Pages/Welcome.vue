<script setup>
import axios from 'axios';
import ServerTable from '../Components/ServerList/ServerTable.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavLinks from '../Components/GuestNavLinks.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
</script>

<template>
  <Head title="YABS List" />

  <div class="pb-[200px] bg-gray-100">
    <NavLinks 
    :anon_yabs=anon_yabs
    :can_register=can_register>
    </NavLinks>

    <FlashMessage></FlashMessage>

    <div class="bg-gray-100 flex justify-center sm:w-full max-w-10xl mx-auto sm:px-0 lg:px-8">
        <div class="server-table bg-white rounded sm:items-center sm:justify-between h-5/6 p-6 shadow"
        :class="{'options_open': !options_open}">
        <ServerTable 
        @options_open="options_open = !options_open"
        :options_open=true
        :user=null
        :passed_server_count=server_count 
        :passed_servers=passed_servers>
        </ServerTable>
        </div>
    </div>
  </div>

</template>

<script>
export default {
    props: [
      'can_login',
      'can_register',
      'passed_servers',
      'server_count',
      'anon_yabs'
    ],
    data() {
        return {
        servers: [],
        options_open: false
        }
    },
    methods: {
        search() {
        axios.post()
        },
    },
    mounted() {
        console.log(this.anon_yabs)
        this.servers = this.passed_servers
    }
}
</script>

<style scoped>
@media screen and (min-width: 1200px) {
  .server-table {
  width: calc(100vw - 280px);
  transition:margin .2s linear;
  }
  
  .options_open {
  margin-left: 280px;
  }
}
</style>