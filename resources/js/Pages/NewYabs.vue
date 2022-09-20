<template>
		<Head title="Dashboard" />

		<AuthenticatedLayout>
				<template #header>
						<h2 class="font-semibold text-xl text-gray-800 leading-tight">
								Submit New Benchmark
						</h2>
				</template>

				<div class="py-12">
						<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
								<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
										<div class="p-6 bg-white border-b border-gray-200">
											<h1 class="text-gray-600 text-lg">
												Submit New Benchmark
												- Paste your YABS results in the textarea below
											</h1>
											<textarea v-model="yabs_text" 
											rows="20"
											class="text-xs rounded mt-2 mb-4 w-full placeholder:italic placeholder:text-slate-400 h"
											placeholder="
# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #
#              Yet-Another-Bench-Script      				               #
#                     v2022-06-11                                                    #
# https://github.com/masonr/yet-another-bench-script      #
# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #

Wed Jun 29 14:14:57 UTC 2022

Basic System Information:
---------------------------------
.
.
.
.
.
.
.
.">
											</textarea>
											<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
												These items should auto-populate when you paste your benchmark output
												in the field above. Make any corrections below.
											</h2>

											<hr class="mt-2">

											<div class="mt-1 flex flex-wrap justify-content">
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="cpu">CPU</label>
													<input v-model="cpu"
													id="cpu" class="ml-2 w-4/6 rounded text-sm" type="text" />
												</div>
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="cores">Cores</label>
													<input v-model="cores"
													id="cores" class="ml-2 rounded w-1/6 text-sm" type="text" />

													<label class="w-1/5 inline-block text-sm text-right" for="clock_speed">Clock Speed</label>
													<input v-model="clock_speed"
													id="clock_speed" class="ml-2 rounded w-1/6 text-sm" type="text" />
												</div>
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="ram">RAM (bytes)</label>
													<input v-model="ram"
													id="ram" class="ml-2 rounded w-3/6 text-sm" type="text" />
												</div>
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="swap">Swap (bytes)</label>
													<input v-model="swap"
													id="swap" class="ml-2 rounded w-3/6 text-sm" type="text" />
												</div>
											</div>

											<hr class="mt-2 mb-2">

											<div class="mt-1 flex flex-wrap justify-content">
												<div class="my-1 pl-2 w-full flex justify-center">
													<label class="inline-block text-sm text-right" for="aes_ni">AES-NI</label>
													<input v-model="aes_ni"
													id="aes_ni" class="ml-2 rounded text-sm" type="checkbox" />
													<label class="inline-block text-sm text-right ml-8" for="vm_x">VM-x/AMD-V</label>
													<input v-model="vm_x"
													id="vm_x" class="ml-2 rounded text-sm" type="checkbox" />
												</div>
											</div>

											<hr class="mt-2 mb-2">

											<div class="mt-1 flex flex-wrap justify-content">
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="distro">Distro</label>
													<input v-model="distro"
													id="distro" class="ml-2 rounded w-3/6 text-sm" type="text" />
												</div>
												<div class="my-1 pl-2 w-1/2">
													<label class="w-1/5 inline-block text-sm text-right" for="kernel">Kernel</label>
													<input v-model="kernel"
													id="kernel" class="ml-2 rounded w-3/6 text-sm" type="text" />
												</div>
											</div>

											<hr class="mt-2 mb-2">

											<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
												Disk Performance - All data should be an integer with speed denoted in bytes/s, not MB/s or GB/s
											</h2>

											<div class="mt-1 flex flex-wrap justify-content">
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_4k_speed">4K Read Speed</label>
													<input v-model="read_4k_speed"
													id="read_4k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_4k_speed">4K Write Speed</label>
													<input v-model="write_4k_speed"
													id="write_4k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_4k_speed">4K Total Speed</label>
													<input v-model="total_4k_speed"
													id="total_4k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_4k_iops">4K Read IOPS</label>
													<input v-model="read_4k_iops"
													id="read_4k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_4k_iops">4K Write IOPS</label>
													<input v-model="write_4k_iops"
													id="write_4k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_4k_iops">4K Total IOPS</label>
													<input v-model="total_4k_iops"
													id="total_4k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_64k_speed">64K Read Speed</label>
													<input v-model="read_64k_speed"
													id="read_64k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_64k_speed">64K Write Speed</label>
													<input v-model="write_64k_speed"
													id="write_64k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_64k_speed">64K Total Speed</label>
													<input v-model="total_64k_speed"
													id="total_64k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_64k_iops">64K Read IOPS</label>
													<input v-model="read_64k_iops"
													id="read_64k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_64k_iops">64K Write IOPS</label>
													<input v-model="write_64k_iops"
													id="write_64k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_64k_iops">64K Total IOPS</label>
													<input v-model="total_64k_iops"
													id="total_64k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_512k_speed">512K Read Speed</label>
													<input v-model="read_512k_speed"
													id="read_512k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_512k_speed">512K Write Speed</label>
													<input v-model="write_512k_speed"
													id="write_512k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_512k_speed">512K Total Speed</label>
													<input v-model="total_512k_speed"
													id="total_512k_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_512k_iops">512K Read IOPS</label>
													<input v-model="read_512k_iops"
													id="read_512k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_512k_iops">512K Write IOPS</label>
													<input v-model="write_512k_iops"
													id="write_512k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_512k_iops">512K Total IOPS</label>
													<input v-model="total_512k_iops"
													id="total_512k_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_1m_speed">1M Read Speed</label>
													<input v-model="read_1m_speed"
													id="read_1m_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_1m_speed">1M Write Speed</label>
													<input v-model="write_1m_speed"
													id="write_1m_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_1m_speed">1M Total Speed</label>
													<input v-model="total_1m_speed"
													id="total_1m_speed" class="rounded w-2/3 text-sm" type="text" />
												</div>
												
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="read_1m_iops">1M Read IOPS</label>
													<input v-model="read_1m_iops"
													id="read_1m_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="write_1m_iops">1M Write IOPS</label>
													<input v-model="write_1m_iops"
													id="write_1m_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
												<div class="mt-1 pl-2 w-1/3 ">
													<label class="w-1/3 inline-block text-sm text-right pr-2" for="total_1m_iops">1M Total IOPS</label>
													<input v-model="total_1m_iops"
													id="total_1m_iops" class="rounded w-2/3 text-sm" type="text" />
												</div>
											</div>

											<hr class="mt-4 mb-2">

											<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
												Network Performance - All speed data should be an integer, denoted in bytes/s, not MB/s or GB/s
											</h2>
											
											<div class="mt-1 flex flex-wrap justify-content">
											</div>

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
			components: {
				Head,
				ServerTable,
			},
			layout: AuthenticatedLayout,
			props: {
					user: Object,
			},
			data() {
					return {
						yabs_text: '',
						cpu: '',
						cores: 0,
						clock_speed: '',
						ram: '',
						swap: '',
						aes_ni: false,
						vm_x: false,
						distro: '',
						kernel: '',
						read_4k_speed: '',
						write_4k_speed: '',
						total_4k_speed: '',
						read_4k_iops: '',
						write_4k_iops: '',
						total_4k_iops: '',
						read_64k_speed: '',
						write_64k_speed: '',
						total_64k_speed: '',
						read_64k_iops: '',
						write_64k_iops: '',
						total_64k_iops: '',
						read_512k_speed: '',
						write_512k_speed: '',
						total_512k_speed: '',
						read_512k_iops: '',
						write_512k_iops: '',
						total_512k_iops: '',
						read_1m_speed: '',
						write_1m_speed: '',
						total_1m_speed: '',
						read_1m_iops: '',
						write_1m_iops: '',
						total_1m_iops: ''
					}
			},
			methods: {
				find_item_row(item, lines) {
					for(let i = 0; i < lines.length; i++) {
						if(lines[i].substring(0,item.length) == item) {
							return i
						}
					}
				},
				find_item_second_row(item, lines) {
					let found = false
					for(let i = 0; i < lines.length; i++) {
						if(lines[i].substring(0,item.length) == item) {
							if(found) {return i}
							found = true
						}
					}
				},
				get_cpu(line) {
					return line.substring(line.indexOf(':') + 1).trim()
				},
				get_cores(line) {
					return parseInt(line.substring(line.indexOf(':') + 1, line.indexOf('@')).trim())
				},
				get_clock_speed(line) {
					return parseInt(line.substring(line.indexOf('@') + 1).trim())
				},
				get_ram(line) {
					let ram = 0
					let suffix = ''
					let ram_info = line.substring(line.indexOf(':') + 2).trim()

					ram = ram_info.substring(0, ram_info.indexOf(' ')).trim()
					suffix = ram_info.substring(ram_info.length - 3).trim()

					if(suffix === 'GiB') {
						ram *= 1000000000
					} else {
						ram *= 1000000
					}
					return parseInt(ram)
				},
				get_aes_or_vm(line) {
					return line.indexOf('Enabled') > 0 ? true : false
				},
				get_swap(line) {
					let swap = 0
					let suffix = ''
					let swap_info = line.substring(line.indexOf(':') + 2).trim()

					swap = swap_info.substring(0, swap_info.indexOf(' ')).trim()
					suffix = swap_info.substring(swap_info.length - 3).trim()

					if(suffix === 'GiB') {
						swap *= 1000000000
					} else {
						swap *= 1000000
					}
					return parseInt(swap)
				},
				get_distro(line) {
					return line.substring(line.indexOf(':') + 1).trim()
				},
				get_kernel(line) {
					return line.substring(line.indexOf(':') + 1).trim()
				},
				get_4k_64k_disk_speed(line) {
					let suffix = ''
					let speed = 0
					let speed_info = line.substring(line.indexOf('|') + 1, line.indexOf('(')).trim()
					speed = parseFloat(speed_info)
					suffix = line.substring(line.indexOf('.') + 3, line.indexOf('(')).trim()
					console.log(suffix)
					if(suffix === 'KB/s') {speed *= 1000}
					if(suffix === 'MB/s') {speed *= 1000000}
					if(suffix === 'GB/s') {speed *= 1000000000}

					return parseInt(speed)
				},
				get_512k_1m_disk_speed(line) {
					let suffix = ''
					let speed = 0
					let starting_point = line.substring(line.indexOf('|', line.indexOf('|') + 1) - 1).trim()
					let speed_info = starting_point.substring(starting_point.indexOf('|') + 1, starting_point.indexOf('(')).trim()
					speed = parseFloat(speed_info)
					suffix = starting_point.substring(starting_point.indexOf('.') + 3, starting_point.indexOf('(')).trim()
					if(suffix === 'KB/s') {speed *= 1000}
					if(suffix === 'MB/s') {speed *= 1000000}
					if(suffix === 'GB/s') {speed *= 1000000000}

					return parseInt(speed)
				},
				get_4k_64k_disk_iops(line) {
					let iops_info = line.substring(line.indexOf('(') + 1, line.indexOf(')'))
					let iops_num = parseFloat(iops_info)

					if(iops_info.substring(iops_info.length - 1) == 'k') {
						iops_num = parseInt(iops_num * 1000)
					}
					return iops_num
				},
				get_512k_1m_disk_iops(line) {
					let starting_point = line.substring(line.indexOf('(', line.indexOf('(') + 1))
					let iops_info = starting_point.substring(starting_point.indexOf('(') + 1, starting_point.indexOf(')'))
					let iops_num = parseFloat(iops_info)

					if(iops_info.substring(iops_info.length - 1) == 'k') {
						iops_num = parseInt(iops_num * 1000)
					}
					return iops_num
				}
			},
			mounted() {
					console.log('helllooooo')
			},
			watch: {
				yabs_text(r) {
					let lines = r.split('\n')

					// find CPU
					let cpu_line = this.find_item_row('Processor', lines)
					if(cpu_line) {
						this.cpu = this.get_cpu(lines[cpu_line])
					}

					// find Cores & Clock Speed
					let cores_line = this.find_item_row('CPU cores', lines)
					if(cores_line) {
						this.cores = this.get_cores(lines[cores_line])
						this.clock_speed = this.get_clock_speed(lines[cores_line])
					}

					// find AES-NI
					let aes_line = this.find_item_row('AES', lines)
					if(aes_line) {
						this.aes_ni = this.get_aes_or_vm(lines[aes_line])
					}

					// find VM-x
					let vm_line = this.find_item_row('VM-x', lines)
					if(vm_line) {
						this.vm_x = this.get_aes_or_vm(lines[vm_line])
					}

					// find RAM
					let ram_line = this.find_item_row('RAM', lines)
					if(ram_line) {
						this.ram = this.get_ram(lines[ram_line])
					}

					// find Swap
					let swap_line = this.find_item_row('Swap', lines)
					if(swap_line) {
						this.swap = this.get_swap(lines[swap_line])
					}

					// find Distro
					let distro_line = this.find_item_row('Distro', lines)
					if(distro_line) {
						this.distro = this.get_distro(lines[distro_line])
					}

					// find Kernel
					let kernel_line = this.find_item_row('Kernel', lines)
					if(kernel_line) {
						this.kernel = this.get_kernel(lines[kernel_line])
					}
					
					// find 4K & 64K speeds & iops
					let row_4k_64k = this.find_item_row('Read', lines)
					if(row_4k_64k) {
						this.read_4k_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k])
						this.write_4k_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k + 1])
						this.total_4k_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k + 2])

						this.read_64k_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k])
						this.write_64k_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k + 1])
						this.total_64k_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k + 2])

						this.read_4k_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k])
						this.write_4k_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k + 1])
						this.total_4k_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k + 2])

						this.read_64k_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k])
						this.write_64k_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k + 1])
						this.total_64k_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k + 2])
					}

					// find 512K speeds
					let row_512k_1m = this.find_item_second_row('Read', lines)
					if(row_512k_1m) {
						this.read_512k_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m])
						this.write_512k_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m + 1])
						this.total_512k_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m + 2])
						
						this.read_1m_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m])
						this.write_1m_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m + 1])
						this.total_1m_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m + 2])

						this.read_512k_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m])
						this.write_512k_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m + 1])
						this.total_512k_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m + 2])
						
						this.read_1m_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m])
						this.write_1m_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m + 1])
						this.total_1m_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m + 2])
					}


				}
			}
	}
</script>
	