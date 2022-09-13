<template>
	<div>

		<OptionsList
		@close_options="options_open = false"
		@change_table_columns="change_table_columns"
		:options_open=options_open
		:passed_show_columns=show_columns>
		</OptionsList>

		<div class="max-w-10xl mx-auto sm:px-2 lg:px-8">
			<div class="flex justify-center">
				<button @click="options_open = !options_open"
				class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-none px-4 py-2 mb-3">Open Options</button>

				<select class="h-10 ml-5" v-model="limit">
					<option value=20>50 Per Page</option>
					<option value=100>100 Per Page</option>
					<option value=200>250 Per Page</option>
					<option value=500>500 Per Page</option>
				</select>
			</div>
		</div>

		<div class="">
			<paginate
				class="h-10"
				:page-count="pageCount"
				:page-range="3"
				:margin-pages="4"
				:click-handler="pagination_click"
				:prev-text="'<<'"
				:next-text="'>>'"
				:container-class="'pagination'"
				:page-class="'page-item'"
			></paginate>
		</div>

		<table class="server-table text-xs mt-4">
			<thead>
				<tr>
					<th v-if="show_columns.provider_name" class="pl-2">
						<span @click="sort_results('provider_name')" 
						class="th-text">Provider <font-awesome-icon icon="fa-sort" /></span></th>
					<th v-if="show_columns.type" class="pl-2">
						<span @click="sort_results('type')" 
						class="th-text">Type <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.virtualization" class="pl-2">
						<span @click="sort_results('virtualization')" 
						class="th-text">Virtualization <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.when" class="pl-2">
						<span class="th-text">Date <font-awesome-icon icon="fa-sort" />
						</span>
					</th>
					<th v-if="show_columns.city" class="pl-2">
						<span @click="sort_results('city')" 
						class="th-text">City <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.cpu" class="pl-2">
						<span @click="sort_results('cpu')"
						class="th-text">CPU <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.cores" class="pl-2">
						<span @click="sort_results('cores')"
						class="th-text">Cores <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.clock_speed" class="pl-2">
						<span @click="sort_results('clock_speed')"
						class="th-text">Clock Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.ram" class="pl-2 pr-2">
						<span @click="sort_results('ram')"
						class="th-text">RAM <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.swap" class="pl-2 pr-2">
						<span @click="sort_results('swap')"
						class="th-text">Swap <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.distro" class="pl-2 pr-2">
						<span @click="sort_results('distro')"
						class="th-text">OS / Distro <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.kernel" class="pl-2 pr-2">
						<span @click="sort_results('kernel')"
						class="th-text">Kernel <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.aes_ni" class="pl-2 pr-2">
						<span @click="sort_results('aes_ni')"
						class="th-text">AES-NI <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.vm_x" class="pl-2 pr-2">
						<span @click="sort_results('vm_x')"
						class="th-text">VM/X <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.geekbench_5_single" class="pl-2 pr-2">
						<span @click="sort_results('geekbench_5_single')"
						class="th-text">GB5 Single <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.geekbench_5_multi" class="pl-2 pr-2">
						<span @click="sort_results('geekbench_5_multi')"
						class="th-text">GB5 Multi <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_4k_read_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_read_speed')"
						class="th-text">4K Read Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_4k_write_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_write_speed')"
						class="th-text">4K Write Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_4k_total_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_total_speed')"
						class="th-text">4K Total Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_4k_read_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_read_iops')"
						class="th-text">4K Read IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_4k_write_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_write_iops')"
						class="th-text">4K Write IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_4k_total_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_4k_total_iops')"
						class="th-text">4K Total IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_64k_read_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_read_speed')"
						class="th-text">64K Read Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_64k_write_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_write_speed')"
						class="th-text">64K Write Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_64k_total_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_total_speed')"
						class="th-text">64K Total Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_64k_read_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_read_iops')"
						class="th-text">64K Read IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_64k_write_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_write_iops')"
						class="th-text">64K Write IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_64k_total_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_64k_total_iops')"
						class="th-text">64K Total IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_512k_read_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_read_speed')"
						class="th-text">512K Read Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_512k_write_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_write_speed')"
						class="th-text">512K Write Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_512k_total_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_total_speed')"
						class="th-text">512K Total Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_512k_read_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_read_iops')"
						class="th-text">512K Read IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_512k_write_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_write_iops')"
						class="th-text">512K Write IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_512k_total_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_512k_total_iops')"
						class="th-text">512K Total IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_1m_read_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_read_speed')"
						class="th-text">1M Read Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_1m_write_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_write_speed')"
						class="th-text">1M Write Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_1m_total_speed" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_total_speed')"
						class="th-text">1M Total Speed <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th v-if="show_columns.disk_1m_read_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_read_iops')"
						class="th-text">1M Read IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_1m_write_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_write_iops')"
						class="th-text">1M Write IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>
					<th v-if="show_columns.disk_1m_total_iops" class="pl-2 pr-2">
						<span @click="sort_results('disk_1m_total_iops')"
						class="th-text">1M Total IOPS <font-awesome-icon icon="fa-sort" /></span>
					</th>

					<th class="pl-2 pr-2">
						<span @click="sort_results('average_network_speed')"
						class="th-text">AVG Network <font-awesome-icon icon="fa-sort" /></span>
					</th>
				</tr>
			</thead>
			<tbody>
				<ServerRow 
				v-for="server in servers" 
				@hover_on_server="hover_on_server"
				@clear_hovered_server="clear_hovered_server"
				:server="server"
				:passed_show_columns="show_columns"
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
	import OptionsList from './OptionsList.vue'
	
		export default {
			props: [
				'passed_servers',
				'passed_server_count',
				'user_id',
			],
			components: {
    ServerRow,
    HoveredServer,
    OptionsList,
    paginate: Paginate,
    OptionsList
},
			data() {
				return {
					servers: [],
					hovered_server: {},
					options_open: false,
					show_columns: {
						user: false,
						provider_name: true,
						type: true,
						virtualization: false,
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
						geekbench_5_single: true,
						geekbench_5_multi: true,
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
						average_network_speed: true
					},
					sort_direction: 'asc',
					limit: 100,
					order_by: 'id',
					page: 1,
					last_sort: '',
					pageCount: 0
				}
			},
			methods: {
				change_table_columns(show_columns) {
					this.show_columns = show_columns
				},
				sort_results(field) {
					if(this.last_sort === field) {
						if(this.sort_direction === 'asc') {
							this.sort_direction = 'desc'
						} else {
							this.sort_direction = 'asc'
						}
					}
					this.order_by = field
					this.last_sort = field
					this.results_query()
				},
				results_query() {
					axios.post('/get_results', {
							order_by: this.order_by,
							limit: this.limit,
							sort_direction: this.sort_direction,
							page: this.page,
							user_id: this.user_id
					})
					.then(res => {
							this.servers = res.data.results
							this.server_count = res.data.server_count
							this.pageCount = Math.ceil(this.server_count / this.limit)
					})
        },
				hover_on_server(server) {
					this.hovered_server = server
				},
				clear_hovered_server() {
					this.hovered_server = {}
				},
				pagination_click(g) {
					console.log(g)
				},
				// sort_string(attribute) {
				// 	if(this.sort_direction === 'asc') {
				// 		this.sort_direction = 'desc'
				// 		this.servers.sort((a, b) => {
				// 			if(a[attribute].toLowerCase() < b[attribute].toLowerCase()) { return -1; }
				// 			if(a[attribute].toLowerCase() > b[attribute].toLowerCase()) { return 1; }
				// 			return 0
				// 		})
				// 	} else {
				// 		this.sort_direction = 'asc'
				// 		this.servers.sort((a, b) => {
				// 			if(a[attribute].toLowerCase() > b[attribute].toLowerCase()) { return -1; }
				// 			if(a[attribute].toLowerCase() < b[attribute].toLowerCase()) { return 1; }
				// 			return 0
				// 		})
				// 	}
				// },
				// sort_numeric(attribute) {
				// 	if(this.sort_direction == 'asc') {
				// 		this.sort_direction = 'desc'
				// 		this.servers.sort((a, b) => {
				// 			if(a[attribute] < b[attribute]) {return -1;}
				// 			if(a[attribute] > b[attribute]) {return 1;}
				// 			return 0
				// 		})
				// 	} else {
				// 		this.sort_direction = 'asc'
				// 		this.servers.sort((a, b) => {
				// 			if(a[attribute] > b[attribute]) {return -1;}
				// 			if(a[attribute] < b[attribute]) {return 1;}
				// 			return 0
				// 		})
				// 	}
				// },
				// sort_network_speed() {
				// 	if(this.sort_direction == 'asc') {
				// 		this.sort_direction = 'desc'
				// 		this.servers.sort((a, b) => {
				// 			if(this.raw_average_network_speed(a.networks) < this.raw_average_network_speed(b.networks)) {return -1;}
				// 			if(this.raw_average_network_speed(a.networks) > this.raw_average_network_speed(b.networks)) {return 1;}
				// 			return 0
				// 		})
				// 	} else {
				// 		this.sort_direction = 'asc'
				// 		this.servers.sort((a, b) => {
				// 			if(this.raw_average_network_speed(a.networks) > this.raw_average_network_speed(b.networks)) {return -1;}
				// 			if(this.raw_average_network_speed(a.networks) < this.raw_average_network_speed(b.networks)) {return 1;}
				// 			return 0
				// 		})
				// 	}
				// },
				raw_average_network_speed(networks) {
					let total = 0
					for(let i = 0; i < networks.length; i++) {
						total += networks[i].send_speed
						total += networks[i].receive_speed
					}
					return total / (networks.length * 2) / 1000
				}
			},
			computed: {
			},
			mounted() {
				this.servers = this.passed_servers
				this.pageCount = Math.ceil(this.passed_server_count / this.limit)
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

	.pagination {
		display: block;
	}

	.page-item {
		display: inline-block;
		width: 40px;
		padding: 10px;
		/* border-top: 1px solid #ccc;
		border-bottom: 1px solid #ccc;
		border-left: 1px solid #ccc;
		border-right: 1px solid #ccc; */
		text-align: center;
		border-radius: 4px;
	}

	.page-item:hover {
		cursor: pointer;
		background: rgb(211, 145, 211);
	}
</style>