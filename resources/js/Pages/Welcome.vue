<script setup>
import axios from 'axios';
import ServerTable from '../Components/ServerList/ServerTable.vue'
import { Head } from '@inertiajs/inertia-vue3';
import NavLinks from '../Components/GuestNavLinks.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
</script>

<template>
  <Head title="YABS List" />

  <div class=" w-100vw">
    <NavLinks 
    :anon_yabs=anon_yabs
    :can_register=can_register>
    </NavLinks>

    <FlashMessage></FlashMessage>

    <div class="flex justify-center px-0 lg:max-w-10xl mx-auto pl-0 lg:px-6">
      <div class="server-table bg-white rounded lg:px-6 pt-2 w-full lg:absolute mr-2"
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
    width: calc(100vw - 300px);
    transition: margin .2s linear;
  }
  
  .options_open {
    margin-left: 290px;
  }
}

@media screen and (max-width: 1199px) {
  .server-table {
    margin: 0 8px;
  }
}
</style>