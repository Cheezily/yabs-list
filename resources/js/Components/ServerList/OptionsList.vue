<template>
	<div>
	<transition name="slide-fade">
		<div v-if="options_open" class="table-options">
			<button 
			@click="$emit('close_options')"
			class="close-options">
				<font-awesome-icon class="close-icon" icon="fa-xmark" />
			</button>

			<div class="text-xs pl-6 mb-4">
				<p class="mb-1 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="columns_open = !columns_open">Select Columns 
					<font-awesome-icon v-if="columns_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />
				</p>
				<transition name="slide-fade">
					<ul v-if="columns_open">
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.provider_name"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Provider Name</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.when"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Run Date/Time</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.city"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">City</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.type"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Server Type</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.virtualization"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Virtualization</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.cpu"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">CPU</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.cores"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Cores</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.clock_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Clock Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.ram"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Ram</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.swap"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Swap</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.distro"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">OS / Distro</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.kernel"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Kernel</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.aes_ni"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">AES-NI</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.vm_x"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">VM/X</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.geekbench_5_single"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Geekbench 5 Single Core</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.geekbench_5_multi"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Geekbench 5 Multi Core</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_read_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Read Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_write_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Write Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_total_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Total Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_read_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Read IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_write_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Write IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_4k_total_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">4K Total IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_read_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Read Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_write_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Write Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_total_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Total Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_read_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Read IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_write_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Write IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_64k_total_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">64K Total IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_read_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Read Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_write_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Write Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_total_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Total Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_read_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Read IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_write_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Write IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_512k_total_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">512K Total IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_read_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Read Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_write_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Write Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_total_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Total Speed</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_read_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Read IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_write_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Write IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.disk_1m_total_iops"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">1M Total IOPS</span>
						</li>
						<li class="ml-2 text-xs">
							<input type="checkbox" 
							v-model="show_columns.average_network_speed"
							@change="$emit('change_table_columns', show_columns)">
							<span class="ml-1">Average Network Speed</span>
						</li>
					</ul>
				</transition>
				<p class="w-5/6 border-b-2 border-gray-400 border-dotted pb-2"></p>
			</div>

			<div class="text-xs pl-6">
				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="cores_open = !cores_open">CPU Cores
					<font-awesome-icon v-if="cores_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="cores_open">
						<li v-for="(option, index) in options.cores" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_cores, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="ram_open = !ram_open">RAM
					<font-awesome-icon v-if="ram_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="ram_open">
						<li v-for="(option, index) in options.ram" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_ram, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="gb5_single_open = !gb5_single_open">Geekbench 5 Single
					<font-awesome-icon v-if="gb5_single_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="gb5_single_open">
						<li v-for="(option, index) in options.geekbench_5_single" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_gb5_single, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="gb5_multi_open = !gb5_multi_open">Geekbench 5 Multi
					<font-awesome-icon v-if="gb5_multi_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="gb5_multi_open">
						<li v-for="(option, index) in options.geekbench_5_multi" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_gb5_multi, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="disk_4k_read_open = !disk_4k_read_open">Disk - 4k Read Speed
					<font-awesome-icon v-if="disk_4k_read_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="disk_4k_read_open">
						<li v-for="(option, index) in options.disk_4k_read_speed" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_4k_read_speed, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="disk_4k_write_open = !disk_4k_write_open">Disk - 4k Write Speed
					<font-awesome-icon v-if="disk_4k_write_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="disk_4k_write_open">
						<li v-for="(option, index) in options.disk_4k_write_speed" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_4k_write_speed, index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="iops_4k_open = !iops_4k_open">Disk - 4K Total IOPS
					<font-awesome-icon v-if="iops_4k_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="iops_4k_open">
						<li v-for="(option, index) in options.disk_4k_total_iops" :key="index"
						class="flex justify-center w-100 mb-px">
						<input checked type="checkbox" @click="select_index_item(selected_4k_total_iops,index)">
							<span class="w-1/2 pl-1">{{ Object.keys(option)[0] }}</span>
							<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
						</li>
					</ul>
				</transition>

				<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="providers_open = !providers_open">Providers
					<font-awesome-icon v-if="providers_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />	
				</p>
				<transition name="slide-fade">
					<ul v-if="providers_open">
						<li v-for="option in options.providers" :key="option"
						class="w-11/12 mb-px">
							<input checked type="checkbox" @click="select_index_item(selected_providers, Object.values(option)[0])">
							<span class="pl-1">{{ Object.values(option)[0] }}</span>
							<span class="float-right font-bold">({{ Object.values(option)[1] }})</span>
						</li>
					</ul>
				</transition>
			</div>

			
		</div>
	</transition>
</div>
</template>

<script>
	export default {
		props: [
			'options_open',
			'passed_show_columns'
		],
		data() {
			return {
				options: {},
				show_columns: {},
				columns_open: false,
				cores_open: false,
				ram_open: false,
				gb5_single_open: false,
				gb5_multi_open: false,
				providers_open: false,
				disk_4k_read_open: false,
				disk_4k_write_open: false,
				iops_4k_open: false,
				selected_ram: [],
				selected_cores: [],
				selected_providers: [],
				selected_4k_read_speed: [],
				selected_4k_write_speed: [],
				selected_4k_total_iops: [],
				selected_gb5_single: [],
				selected_gb5_multi: [],
			}
		},
		methods: {
			get_options_counts() {
				axios.get('/get_options_counts')
				.then(res => {
					// console.log(res.data)
					this.options = res.data
					console.log('options')
					console.log(this.options)
					for (const [key] of Object.entries(this.options.cores)) {this.selected_cores.push(key)}
					for (const [key] of Object.entries(this.options.ram)) {this.selected_ram.push(key)}
					for (const [key] of Object.entries(this.options.geekbench_5_single)) {this.selected_gb5_single.push(key)}
					for (const [key] of Object.entries(this.options.geekbench_5_multi)) {this.selected_gb5_multi.push(key)}
					for (const [key] of Object.entries(this.options.disk_4k_read_speed)) {this.selected_4k_read_speed.push(key)}
					for (const [key] of Object.entries(this.options.disk_4k_write_speed)) {this.selected_4k_write_speed.push(key)}
					for (const [key] of Object.entries(this.options.disk_4k_total_iops)) {this.selected_4k_total_iops.push(key)}
					for (const [key, value] of Object.entries(this.options.providers)) {this.selected_providers.push(value['provider_name'])}
				})
			},
			select_index_item(list, index) {
				if(list.includes(index)){
					console.log('found index')
					list.splice(list.indexOf(index), 1)
				} else {
					console.log('adding index')
					list.push(index)
				}
			},
			// select_cores(option) {
			// 	console.log(option)
			// 	console.log(this.selected_cores)
			// 	if(this.selected_cores.includes(option)){
			// 		console.log('found option')
			// 		this.selected_cores.splice(this.selected_cores.indexOf(this.selected_cores), 1)
			// 	} else {
			// 		console.log('adding option')
			// 		this.selected_cores.push(option)
			// 	}
			// },
			// select_ram(option) {
			// 	console.log(option)
			// 	console.log(this.selected_ram)
			// 	if(this.selected_ram.includes(option)){
			// 		console.log('found option')
			// 		this.selected_ram.splice(this.selected_ram.indexOf(this.selected_ram), 1)
			// 	} else {
			// 		console.log('adding option')
			// 		this.selected_ram.push(option)
			// 	}
			// },
			// select_provider(option) {
			// 	console.log(option)
			// 	console.log(this.selected_4k_iops)
			// 	if(this.selected_4k_iops.includes(option)){
			// 		console.log('found option')
			// 		this.selected_4k_iops.splice(this.selected_4k_iops.indexOf(this.selected_4k_iops), 1)
			// 	} else {
			// 		console.log('adding option')
			// 		this.selected_4k_iops.push(option)
			// 	}
			// },
			// select_disk_4k_iops(option) {
			// 	console.log(option)
			// 	console.log(this.selected_providers)
			// 	if(this.selected_providers.includes(option)){
			// 		console.log('found option')
			// 		this.selected_providers.splice(this.selected_providers.indexOf(this.selected_providers), 1)
			// 	} else {
			// 		console.log('adding option')
			// 		this.selected_providers.push(option)
			// 	}
			// }
		},
		watch: {
			show_columns () {
				console.log('updating columns')
				this.$emit('change_table_columns', this.show_columns)
			}
		},
		mounted() {
			this.get_options_counts()
			this.show_columns = this.passed_show_columns
		}
	}
</script>

<style scoped>
	.table-options {
		padding-bottom: 200px;
		width: 350px;
		height: 100vh;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 20;
		overflow: auto;
		box-shadow: 0 10px 10px 4px #777;
		background: rgb(224,223,255);
		background: linear-gradient(180deg, rgb(233, 232, 255) 0%, rgb(230, 230, 255) 40%, rgb(232, 251, 255) 100%); 
	}

	.close-icon {
		position: absolute;
		right: 10px;
		top: 10px;
		font-size: 24px;
		color: #000;
	}

	.close-icon:hover {
		color: rgb(153, 60, 182);
	}

	.slide-fade-enter-active {
		transition: all 0.3s ease-out;
	}

	.slide-fade-leave-active {
		transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
	}

	.slide-fade-enter-from,
	.slide-fade-leave-to {
		transform: translateX(-350px);
	}
</style>