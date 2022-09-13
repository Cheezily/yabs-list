<template>
	<div>
		<div class="">
			<paginate
				class="h-10"
				:page-count="20"
				:page-range="3"
				:margin-pages="2"
				:click-handler="clickCallback"
				:prev-text="'Prev'"
				:next-text="'Next'"
				:container-class="'pagination'"
				:page-class="'page-item'"
			></paginate>
		</div>

		<table class="server-table text-xs">
			<thead>
				<tr>
					<th class="pl-2">
						<span @click="sort_string('provider_name')" 
						class="th-text">Provider <font-awesome-icon icon="fa-sort" /></span></th>
					<th class="pl-2">
						<span @click="sort_string('type')" 
						class="th-text">Type <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2">
						<span class="th-text">Date <font-awesome-icon icon="fa-sort" />
						</span>
					</th>
					<th class="pl-2">
						<span @click="sort_string('city')" 
						class="th-text">Where <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2">
						<span @click="sort_string('cpu')"
						class="th-text">CPU <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2">
						<span @click="sort_numeric('cores')"
						class="th-text">Cores <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_numeric('ram')"
						class="th-text">RAM <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_numeric('disk_4k_total_speed')"
						class="th-text">4K Total Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_numeric('disk_4k_total_iops')"
						class="th-text">4K Total IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_network_speed()"
						class="th-text">AVG Network <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_numeric('geekbench_5_single')"
						class="th-text">GB5 Single <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th class="pl-2 pr-2">
						<span @click="sort_numeric('geekbench_5_multi')"
						class="th-text">GB5 Multi <font-awesome-icon icon="fa-sort" /></span>
					</th>
				</tr>
			</thead>
			<tbody>
				<ServerRow 
				v-for="server in servers" 
				@hover_on_server="hover_on_server"
				@clear_hovered_server="clear_hovered_server"
				:server="server" 
				:key="server.id">
				</ServerRow>
			</tbody>
		</table>
		<HoveredServer 
		:hovered_server=hovered_server></HoveredServer>
	</div>
</template>

<script>
	import ServerRow from './ServerRow.vue';
	import HoveredServer from './HoveredServer.vue'
	import Paginate from 'vuejs-paginate-next';
	
		export default {
			props: [
				'passedServers'
			],
			components: {
					ServerRow,
					HoveredServer,
					paginate: Paginate
			},
			data() {
				return {
					servers: [],
					hovered_server: {},
					sort_direction: 'asc'
				}
			},
			methods: {
				hover_on_server(server) {
					this.hovered_server = server
				},
				clear_hovered_server() {
					this.hovered_server = {}
				},
				sort_string(attribute) {
					if(this.sort_direction === 'asc') {
						this.sort_direction = 'desc'
						this.servers.sort((a, b) => {
							if(a[attribute].toLowerCase() < b[attribute].toLowerCase()) { return -1; }
							if(a[attribute].toLowerCase() > b[attribute].toLowerCase()) { return 1; }
							return 0
						})
					} else {
						this.sort_direction = 'asc'
						this.servers.sort((a, b) => {
							if(a[attribute].toLowerCase() > b[attribute].toLowerCase()) { return -1; }
							if(a[attribute].toLowerCase() < b[attribute].toLowerCase()) { return 1; }
							return 0
						})
					}
				},
				sort_numeric(attribute) {
					if(this.sort_direction == 'asc') {
						this.sort_direction = 'desc'
						this.servers.sort((a, b) => {
							if(a[attribute] < b[attribute]) {return -1;}
							if(a[attribute] > b[attribute]) {return 1;}
							return 0
						})
					} else {
						this.sort_direction = 'asc'
						this.servers.sort((a, b) => {
							if(a[attribute] > b[attribute]) {return -1;}
							if(a[attribute] < b[attribute]) {return 1;}
							return 0
						})
					}
				},
				sort_network_speed() {
					if(this.sort_direction == 'asc') {
						this.sort_direction = 'desc'
						this.servers.sort((a, b) => {
							if(this.raw_average_network_speed(a.networks) < this.raw_average_network_speed(b.networks)) {return -1;}
							if(this.raw_average_network_speed(a.networks) > this.raw_average_network_speed(b.networks)) {return 1;}
							return 0
						})
					} else {
						this.sort_direction = 'asc'
						this.servers.sort((a, b) => {
							if(this.raw_average_network_speed(a.networks) > this.raw_average_network_speed(b.networks)) {return -1;}
							if(this.raw_average_network_speed(a.networks) < this.raw_average_network_speed(b.networks)) {return 1;}
							return 0
						})
					}
				},
				raw_average_network_speed(networks) {
					let total = 0
					for(let i = 0; i < networks.length; i++) {
						total += networks[i].send_speed
						total += networks[i].receive_speed
					}
					return total / (networks.length * 2) / 1000
				}
			},
			mounted() {
				this.servers = this.passedServers
			}
		}
	</script>

<style>
	th {
		color: #555;
		text-align: left;
	}

	.th-text:hover {
		cursor: pointer;
		color: darkorange;
	}

	/* .page-item {
		display: inline-block;
		width: 40px;
		border: 1px solid #bbb;
		padding: 10px;
	} */
</style>