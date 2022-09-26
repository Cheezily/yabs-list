<template>
	<div>
	<transition name="slide-fade">
		<div v-if="options_open" class="pb-[200px] w-[320px] h-screen table-options fixed 
		top-[65px] left-0 z-20 overflow-auto">
			<button 
			@click="$emit('close_options')"
			class="close-options">
				<font-awesome-icon class="close-icon absolute right-[10px] top-[10px] text-xl hover:text-purple" 
				icon="fa-xmark" />
			</button>

			<div class="text-xs pl-6 mb-4">
				<p class="mb-1 font-bold text-lg hover:text-purple-600 hover:cursor-pointer"
				@click="columns_open = !columns_open">Select Columns 
					<font-awesome-icon v-if="columns_open" icon="fa-caret-left" />
					<font-awesome-icon v-else icon="fa-caret-right" />
				</p>
				<transition name="slide-fade">
					<ul v-if="columns_open || user">
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

			<div v-if="!user">
				<div class="text-xs pl-6">
					<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
					@click="cores_open = !cores_open">CPU Cores
						<font-awesome-icon v-if="cores_open" icon="fa-caret-left" />
						<font-awesome-icon v-else icon="fa-caret-right" />	
					</p>
					<transition name="slide-fade">
						<ul v-if="cores_open">
							<li v-for="(option, index) in options.cores" :key="index"
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_cores, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_ram, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_gb5_single, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_gb5_multi, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_4k_read_speed, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_4k_write_speed, index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_4k_total_iops,index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
							</li>
						</ul>
					</transition>

					<p class="mb-1 mt-3 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
					@click="avg_network_4k_open = !avg_network_4k_open">Average Network Speed
						<font-awesome-icon v-if="avg_network_4k_open" icon="fa-caret-left" />
						<font-awesome-icon v-else icon="fa-caret-right" />	
					</p>
					<transition name="slide-fade">
						<ul v-if="avg_network_4k_open">
							<li v-for="(option, index) in options.average_network_speed" :key="index"
							class="w-11/12 mb-px">
								<input :disabled=disable_all 
									checked type="checkbox" @click="select_index_item(selected_items.selected_avg_network,index)">
								<span class="pl-1">{{ Object.keys(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[0] }})</span>
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
								<input :disabled=disable_all 
									:checked="Object.values(option)[1] > 0" type="checkbox" @click="select_index_item(selected_items.selected_providers, Object.values(option)[0])">
								<span class="pl-1">{{ Object.values(option)[0] }}</span>
								<span class="float-right font-bold">({{ Object.values(option)[1] }})</span>
							</li>
						</ul>
					</transition>
				</div>
			</div>

			
		</div>
	</transition>
</div>
</template>

<script>
	export default {
		props: [
			'options_open',
			'passed_show_columns',
			'user'
		],
		data() {
			return {
				disable_all: false,
				options: {},
				show_columns: {},
				columns_open: false,
				cores_open: true,
				ram_open: true,
				gb5_single_open: true,
				gb5_multi_open: true,
				providers_open: true,
				disk_4k_read_open: true,
				disk_4k_write_open: true,
				iops_4k_open: true,
				avg_network_4k_open: true,
				static_provider_list: [],
				selected_items: {
					selected_ram: [],
					selected_cores: [],
					selected_providers: [],
					selected_4k_read_speed: [],
					selected_4k_write_speed: [],
					selected_4k_total_iops: [],
					selected_gb5_single: [],
					selected_gb5_multi: [],
					selected_avg_network: []
				}
			}
		},
		methods: {
			get_options_counts(initial = false) {
				this.disable_all = true
				axios.post('/get_options_counts',
				{
					selected_items: this.selected_items
				})
				.then(res => {
					this.options = res.data
					this.options.providers.sort((a, b) => {
						if(a['provider_name'].toUpperCase() > b['provider_name'].toUpperCase()) {
							return 1
						}
						if(b['provider_name'].toUpperCase() > a['provider_name'].toUpperCase()) {
							return -1
						}
						return 0
					})
					if(initial) {
						for (const [key, value] of Object.entries(this.options.providers)) {this.static_provider_list.push(value['provider_name'])}
					} else {
						
						var to_add = []
						this.static_provider_list.forEach((i) => {
							let found = false
							this.options.providers.forEach((e) => {
								if (i === e['provider_name']) {
									console.log('found')
									found = true
								}
							})
							if(!found) {
								to_add.push({
									'provider_name': i,
									'count': 0
								})
							}
						})

						to_add.forEach((e) => {
							this.options.providers.push(e)
						})

						this.options.providers.sort((a, b) => {
							if(a['provider_name'].toUpperCase() > b['provider_name'].toUpperCase()) {
								return 1
							}
							if(b['provider_name'].toUpperCase() > a['provider_name'].toUpperCase()) {
								return -1
							}
							return 0
						})
					}
					this.disable_all = false
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
				console.log('updating results from options list')
				this.$emit('update_query', this.selected_items)
				this.get_options_counts()
			},
		},
		watch: {
			show_columns () {
				console.log('updating columns')
				this.$emit('change_table_columns', this.show_columns)
			},
		},
		mounted() {
			if(!this.user) {
				this.get_options_counts(true)
			}
			this.show_columns = this.passed_show_columns
		}
	}
</script>

<style scoped>
	.table-options {
		border-top: 2px #222;
		box-shadow: 0 10px 10px 4px #777;
		background: rgb(224,223,255);
		background: linear-gradient(180deg, rgb(233, 232, 255) 0%, rgb(230, 230, 255) 40%, rgb(232, 251, 255) 100%); 
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