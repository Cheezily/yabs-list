<template>
	<div>
	<transition name="slide-fade">
		<div v-if="options_open" class="table-options">
			<button 
			@click="$emit('close_options')"
			class="close-options">
				<font-awesome-icon class="close-icon" icon="fa-xmark" />
			</button>

			<div class="text-xs pl-6 mb-6">
				<p class="mb-1 font-bold text-sm hover:text-purple-600 hover:cursor-pointer"
				@click="columns_open = !columns_open">Filter Columns 
					<font-awesome-icon v-if="columns_open" icon="fa-caret-up" />
					<font-awesome-icon v-else icon="fa-caret-down" />
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
			</div>

			<div class="text-xs pl-6">
				<p class="mb-1 font-bold text-sm">CPU Cores</p>
				<ul>
					<li v-for="option in options.cores" :key="option"
					class="flex justify-center w-2/3">
						<span class="w-1/2">{{ Object.keys(option)[0] }}</span>
						<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
					</li>
				</ul>
				<p class="mb-1 mt-2 font-bold text-sm">RAM</p>
				<ul>
					<li v-for="option in options.ram" :key="option"
					class="flex justify-center w-2/3">
						<span class="w-1/2">{{ Object.keys(option)[0] }}</span>
						<span class="w-1/2 font-bold">({{ Object.values(option)[0] }})</span>
					</li>
				</ul>
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
				columns_open: false
			}
		},
		methods: {
			get_options_counts() {
				axios.get('/get_options_counts')
				.then(res => {
					console.log(res.data)
					this.options = res.data
				})
			},
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
		font-size: 20px;
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