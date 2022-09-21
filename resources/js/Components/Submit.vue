<template>
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
				<label class="w-1/4 inline-block text-sm text-right" for="cpu">CPU</label>
				<input v-model="cpu"
				id="cpu" class="ml-2 w-4/6 rounded text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="cores">Cores</label>
				<input v-model="cores"
				id="cores" class="ml-2 rounded w-1/6 text-sm h-7" type="text" />
				<label class="w-1/4 inline-block text-sm text-right" for="clock_speed">Clock Speed</label>
				<input v-model="clock_speed"
				id="clock_speed" class="ml-2 rounded w-1/6 text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="ram">RAM (bytes)</label>
				<input v-model="ram"
				id="ram" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="swap">Swap (bytes)</label>
				<input v-model="swap"
				id="swap" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="gb5_single">GB 5 Single Score</label>
				<input v-model="gb5_single"
				id="gb5_single" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="gb5_multi">GB 5 Multi Score</label>
				<input v-model="gb5_multi"
				id="gb5_multi" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
			<p v-if="errors['cpu']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.cpu[0]) }}</p>
			<p v-if="errors['cores']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.cores[0]) }}</p>
			<p v-if="errors['clock_speed']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.clock_speed[0]) }}</p>
			<p v-if="errors['ram']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.ram[0]) }}</p>
			<p v-if="errors['swap']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.swap[0]) }}</p>
			<p v-if="errors['gb5_single']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.gb5_single[0]) }}</p>
			<p v-if="errors['gb5_multi']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.gb5_multi[0]) }}</p>
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
				<label class="w-1/4 inline-block text-sm text-right" for="distro">Distro</label>
				<input v-model="distro"
				id="distro" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
			<div class="my-1 pl-2 w-1/2">
				<label class="w-1/4 inline-block text-sm text-right" for="kernel">Kernel</label>
				<input v-model="kernel"
				id="kernel" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
			</div>
		</div>

		<hr class="mt-2 mb-2">

		<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
			Disk Performance - All data should be an integer with speed denoted in bytes/s, not MB/s or GB/s
		</h2>

		<div class="mt-1 flex flex-wrap justify-content">
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_4k_speed">4K Read Speed</label>
				<input v-model="read_4k_speed"
				id="read_4k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_4k_speed">4K Write Speed</label>
				<input v-model="write_4k_speed"
				id="write_4k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_4k_speed">4K Total Speed</label>
				<input v-model="total_4k_speed"
				id="total_4k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_4k_iops">4K Read IOPS</label>
				<input v-model="read_4k_iops"
				id="read_4k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_4k_iops">4K Write IOPS</label>
				<input v-model="write_4k_iops"
				id="write_4k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_4k_iops">4K Total IOPS</label>
				<input v-model="total_4k_iops"
				id="total_4k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_64k_speed">64K Read Speed</label>
				<input v-model="read_64k_speed"
				id="read_64k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_64k_speed">64K Write Speed</label>
				<input v-model="write_64k_speed"
				id="write_64k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_64k_speed">64K Total Speed</label>
				<input v-model="total_64k_speed"
				id="total_64k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_64k_iops">64K Read IOPS</label>
				<input v-model="read_64k_iops"
				id="read_64k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_64k_iops">64K Write IOPS</label>
				<input v-model="write_64k_iops"
				id="write_64k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_64k_iops">64K Total IOPS</label>
				<input v-model="total_64k_iops"
				id="total_64k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_512k_speed">512K Read Speed</label>
				<input v-model="read_512k_speed"
				id="read_512k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_512k_speed">512K Write Speed</label>
				<input v-model="write_512k_speed"
				id="write_512k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_512k_speed">512K Total Speed</label>
				<input v-model="total_512k_speed"
				id="total_512k_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_512k_iops">512K Read IOPS</label>
				<input v-model="read_512k_iops"
				id="read_512k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_512k_iops">512K Write IOPS</label>
				<input v-model="write_512k_iops"
				id="write_512k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_512k_iops">512K Total IOPS</label>
				<input v-model="total_512k_iops"
				id="total_512k_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_1m_speed">1M Read Speed</label>
				<input v-model="read_1m_speed"
				id="read_1m_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_1m_speed">1M Write Speed</label>
				<input v-model="write_1m_speed"
				id="write_1m_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_1m_speed">1M Total Speed</label>
				<input v-model="total_1m_speed"
				id="total_1m_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="read_1m_iops">1M Read IOPS</label>
				<input v-model="read_1m_iops"
				id="read_1m_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="write_1m_iops">1M Write IOPS</label>
				<input v-model="write_1m_iops"
				id="write_1m_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/3 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="total_1m_iops">1M Total IOPS</label>
				<input v-model="total_1m_iops"
				id="total_1m_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
		</div>

		<hr class="mt-4 mb-2">

		<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
			IPv4 Network Performance - All speed data should be an integer, denoted in bits/s, not MB/s or GB/s
		</h2>
		
		<div class="mt-1 flex flex-wrap justify-content">
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_1_provider">Provider</label>
				<input v-model="network_row_1_provider"
				id="network_row_1_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_1_location">Location</label>
				<input v-model="network_row_1_location"
				id="network_row_1_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_1_send_speed">Send Speed</label>
				<input v-model="network_row_1_send_speed"
				id="network_row_1_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_1_rec_speed">Rec Speed</label>
				<input v-model="network_row_1_rec_speed"
				id="network_row_1_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_2_provider">Provider</label>
				<input v-model="network_row_2_provider"
				id="network_row_2_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_2_location">Location</label>
				<input v-model="network_row_2_location"
				id="network_row_2_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_2_send_speed">Send Speed</label>
				<input v-model="network_row_2_send_speed"
				id="network_row_2_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_2_rec_speed">Rec Speed</label>
				<input v-model="network_row_2_rec_speed"
				id="network_row_2_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_3_provider">Provider</label>
				<input v-model="network_row_3_provider"
				id="network_row_3_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_3_location">Location</label>
				<input v-model="network_row_3_location"
				id="network_row_3_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_3_send_speed">Send Speed</label>
				<input v-model="network_row_3_send_speed"
				id="network_row_3_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_3_rec_speed">Rec Speed</label>
				<input v-model="network_row_3_rec_speed"
				id="network_row_3_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_4_provider">Provider</label>
				<input v-model="network_row_4_provider"
				id="network_row_4_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_4_location">Location</label>
				<input v-model="network_row_4_location"
				id="network_row_4_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_4_send_speed">Send Speed</label>
				<input v-model="network_row_4_send_speed"
				id="network_row_4_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_4_rec_speed">Rec Speed</label>
				<input v-model="network_row_4_rec_speed"
				id="network_row_4_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_5_provider">Provider</label>
				<input v-model="network_row_5_provider"
				id="network_row_5_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_5_location">Location</label>
				<input v-model="network_row_5_location"
				id="network_row_5_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_5_send_speed">Send Speed</label>
				<input v-model="network_row_5_send_speed"
				id="network_row_5_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_5_rec_speed">Rec Speed</label>
				<input v-model="network_row_5_rec_speed"
				id="network_row_5_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_6_provider">Provider</label>
				<input v-model="network_row_6_provider"
				id="network_row_6_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_6_location">Location</label>
				<input v-model="network_row_6_location"
				id="network_row_6_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_6_send_speed">Send Speed</label>
				<input v-model="network_row_6_send_speed"
				id="network_row_6_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_6_rec_speed">Rec Speed</label>
				<input v-model="network_row_6_rec_speed"
				id="network_row_6_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_7_provider">Provider</label>
				<input v-model="network_row_7_provider"
				id="network_row_7_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_7_location">Location</label>
				<input v-model="network_row_7_location"
				id="network_row_7_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_7_send_speed">Send Speed</label>
				<input v-model="network_row_7_send_speed"
				id="network_row_7_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_7_rec_speed">Rec Speed</label>
				<input v-model="network_row_7_rec_speed"
				id="network_row_7_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
		</div>

		<hr class="mt-4 mb-2">

		<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
			IPv6 Network Performance - All speed data should be an integer, denoted in bits/s, not MB/s or GB/s
		</h2>
		
		<div class="mt-1 flex flex-wrap justify-content">
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_8_provider">Provider</label>
				<input v-model="network_row_8_provider"
				id="network_row_8_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_8_location">Location</label>
				<input v-model="network_row_8_location"
				id="network_row_8_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_8_send_speed">Send Speed</label>
				<input v-model="network_row_8_send_speed"
				id="network_row_8_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_8_rec_speed">Rec Speed</label>
				<input v-model="network_row_8_rec_speed"
				id="network_row_8_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_9_provider">Provider</label>
				<input v-model="network_row_9_provider"
				id="network_row_9_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_9_location">Location</label>
				<input v-model="network_row_9_location"
				id="network_row_9_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_9_send_speed">Send Speed</label>
				<input v-model="network_row_9_send_speed"
				id="network_row_9_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_9_rec_speed">Rec Speed</label>
				<input v-model="network_row_9_rec_speed"
				id="network_row_9_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_10_provider">Provider</label>
				<input v-model="network_row_10_provider"
				id="network_row_10_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_10_location">Location</label>
				<input v-model="network_row_10_location"
				id="network_row_10_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_10_send_speed">Send Speed</label>
				<input v-model="network_row_10_send_speed"
				id="network_row_10_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_10_rec_speed">Rec Speed</label>
				<input v-model="network_row_10_rec_speed"
				id="network_row_10_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_11_provider">Provider</label>
				<input v-model="network_row_11_provider"
				id="network_row_11_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_11_location">Location</label>
				<input v-model="network_row_11_location"
				id="network_row_11_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_11_send_speed">Send Speed</label>
				<input v-model="network_row_11_send_speed"
				id="network_row_11_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_11_rec_speed">Rec Speed</label>
				<input v-model="network_row_11_rec_speed"
				id="network_row_11_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_12_provider">Provider</label>
				<input v-model="network_row_12_provider"
				id="network_row_12_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_12_location">Location</label>
				<input v-model="network_row_12_location"
				id="network_row_12_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_12_send_speed">Send Speed</label>
				<input v-model="network_row_12_send_speed"
				id="network_row_12_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_12_rec_speed">Rec Speed</label>
				<input v-model="network_row_12_rec_speed"
				id="network_row_12_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_13_provider">Provider</label>
				<input v-model="network_row_13_provider"
				id="network_row_13_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_13_location">Location</label>
				<input v-model="network_row_13_location"
				id="network_row_13_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_13_send_speed">Send Speed</label>
				<input v-model="network_row_13_send_speed"
				id="network_row_13_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_13_rec_speed">Rec Speed</label>
				<input v-model="network_row_13_rec_speed"
				id="network_row_13_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_14_provider">Provider</label>
				<input v-model="network_row_14_provider"
				id="network_row_14_provider" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_14_location">Location</label>
				<input v-model="network_row_14_location"
				id="network_row_14_location" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_14_send_speed">Send Speed</label>
				<input v-model="network_row_14_send_speed"
				id="network_row_14_send_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
			</div>
			<div class="mt-1 pl-2 w-1/4 ">
				<label class="w-1/3 inline-block text-sm text-right pr-2 text-gray-600" for="network_row_14_rec_speed">Rec Speed</label>
				<input v-model="network_row_14_rec_speed"
				id="network_row_14_rec_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				<p v-if="errors['network_row_14_rec_speed']" 
				class="text-xs italic text-red-500"
				>{{ errors['network_row_14_rec_speed'][0] }}</p>
			</div>
		</div>
		<div class="flex justify-end mt-8">
			<button type="submit" class="bg-green-400 rounded px-4 py-2 text-white font-bold shadow hover:bg-green-600"
			@click="submit">Submit</button>
		</div>
	</div>
</div>
</template>

<script>
	export default {
		props: {
			user: Object,
		},
		data() {
			return {
				errors: {},
				yabs_text: '',
				cpu: '',
				cores: '',
				clock_speed: '',
				ram: '',
				swap: '',
				gb5_single: '',
				gb5_multi: '',
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
				total_1m_iops: '',
				network_row_1_provider: '',
				network_row_1_location: '',
				network_row_1_send_speed: '',
				network_row_1_rec_speed: '',
				network_row_1_ipv4: true,
				network_row_2_provider: '',
				network_row_2_location: '',
				network_row_2_send_speed: '',
				network_row_2_rec_speed: '',
				network_row_2_ipv4: true,
				network_row_3_provider: '',
				network_row_3_location: '',
				network_row_3_send_speed: '',
				network_row_3_rec_speed: '',
				network_row_3_ipv4: true,
				network_row_4_provider: '',
				network_row_4_location: '',
				network_row_4_send_speed: '',
				network_row_4_rec_speed: '',
				network_row_4_ipv4: true,
				network_row_5_provider: '',
				network_row_5_location: '',
				network_row_5_send_speed: '',
				network_row_5_rec_speed: '',
				network_row_5_ipv4: true,
				network_row_6_provider: '',
				network_row_6_location: '',
				network_row_6_send_speed: '',
				network_row_6_rec_speed: '',
				network_row_6_ipv4: true,
				network_row_7_provider: '',
				network_row_7_location: '',
				network_row_7_send_speed: '',
				network_row_7_rec_speed: '',
				network_row_7_ipv4: true,
				network_row_8_provider: '',
				network_row_8_location: '',
				network_row_8_send_speed: '',
				network_row_8_rec_speed: '',
				network_row_8_ipv4: false,
				network_row_9_provider: '',
				network_row_9_location: '',
				network_row_9_send_speed: '',
				network_row_9_rec_speed: '',
				network_row_9_ipv4: false,
				network_row_10_provider: '',
				network_row_10_location: '',
				network_row_10_send_speed: '',
				network_row_10_rec_speed: '',
				network_row_10_ipv4: false,
				network_row_11_provider: '',
				network_row_11_location: '',
				network_row_11_send_speed: '',
				network_row_11_rec_speed: '',
				network_row_11_ipv4: false,
				network_row_12_provider: '',
				network_row_12_location: '',
				network_row_12_send_speed: '',
				network_row_12_rec_speed: '',
				network_row_12_ipv4: false,
				network_row_13_provider: '',
				network_row_13_location: '',
				network_row_13_send_speed: '',
				network_row_13_rec_speed: '',
				network_row_13_ipv4: false,
				network_row_14_provider: '',
				network_row_14_location: '',
				network_row_14_send_speed: '',
				network_row_14_rec_speed: '',
				network_row_14_ipv4: false,
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
			get_gb5(line) {
				console.log(line.substring(line.indexOf('|') + 1).trim())
				return parseInt(line.substring(line.indexOf('|') + 1).trim())
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
			},
			get_network_row_provider(line) {
				return line.substring(0, line.indexOf('|')).trim()
			},
			get_network_row_location(line) {
				let start_point = line.substring(line.indexOf('|') + 1)
				return start_point.substring(0, start_point.indexOf('|')).trim()
			},
			get_network_row_send_speed(line) {
				let start_point = line.substring(line.indexOf('|', line.indexOf('|') + 1) + 1)
				let speed_row = start_point.substring(0, line.indexOf('|') + 1).trim()

				let speed = parseFloat(speed_row.substring(0, speed_row.indexOf(' ')).trim())
				if(isNaN(speed)) {return speed_row}

				let suffix = speed_row.substring(speed_row.indexOf(' ')).trim()
				if(suffix.substring(0, 1).toUpperCase() === 'K') {speed *= 1000}
				if(suffix.substring(0, 1).toUpperCase() === 'M') {speed *= 1000000}
				if(suffix.substring(0, 1).toUpperCase() === 'G') {speed *= 1000000000}
				return parseInt(speed)
			},
			get_network_row_rec_speed(line) {
				let start_point = line.substring(line.indexOf('|', line.indexOf('|', line.indexOf('|') +  1) + 1) + 1)
				let speed_row = start_point.substring(0, line.indexOf('|') + 1).trim()

				let speed = parseFloat(speed_row.substring(0, speed_row.indexOf(' ')).trim())
				if(isNaN(speed)) {return speed_row}

				let suffix = speed_row.substring(speed_row.indexOf(' ')).trim()
				if(suffix.substring(0, 1).toUpperCase() === 'K') {speed *= 1000}
				if(suffix.substring(0, 1).toUpperCase() === 'M') {speed *= 1000000}
				if(suffix.substring(0, 1).toUpperCase() === 'G') {speed *= 1000000000}
				return parseInt(speed)
			},
			capitalize(line) {
				const words = line.split(" ")
				for (let i = 0; i < words.length; i++) {
					words[i] = words[i][0].toUpperCase() + words[i].substr(1);
				}
				return words.join(" ")
			},
			submit() {
				axios.post('/server/create',{
					cpu: this.cpu,
					cores: this.cores,
					clock_speed: this.clock_speed,
					ram: this.ram,
					swap: this.swap,
					gb5_single: this.gb5_single,
					gb5_multi: this.gb5_multi,
					aes_ni: this.aes_ni,
					vm_x: this.vm_x,
					distro: this.distro,
					kernel: this.kernel,
					read_4k_speed: this.read_4k_speed,
					write_4k_speed: this.write_4k_speed,
					total_4k_speed: this.total_4k_speed,
					read_4k_iops: this.read_4k_iops,
					write_4k_iops: this.write_4k_iops,
					total_4k_iops: this.total_4k_iops,
					read_64k_speed: this.read_64k_speed,
					write_64k_speed: this.write_64k_speed,
					total_64k_speed: this.total_64k_speed,
					read_64k_iops: this.read_64k_iops,
					write_64k_iops: this.write_64k_iops,
					total_64k_iops: this.total_64k_iops,
					read_512k_speed: this.read_512k_speed,
					write_512k_speed: this.write_512k_speed,
					total_512k_speed: this.total_512k_speed,
					read_512k_iops: this.read_512k_iops,
					write_512k_iops: this.write_512k_iops,
					total_512k_iops: this.total_512k_iops,
					read_1m_speed: this.read_1m_speed,
					write_1m_speed: this.write_1m_speed,
					total_1m_speed: this.total_1m_speed,
					read_1m_iops: this.read_1m_iops,
					write_1m_iops: this.write_1m_iops,
					total_1m_iops: this.total_1m_iops,
					network_row_1_provider: this.network_row_1_provider.length > 0 ? this.network_row_1_provider.length : null,
					network_row_1_location: this.network_row_1_location,
					network_row_1_send_speed: this.network_row_1_send_speed,
					network_row_1_rec_speed: this.network_row_1_rec_speed,
					network_row_1_ipv4: this.network_row_1_ipv4,
					network_row_2_provider: this.network_row_2_provider > 0 ? this.network_row_2_provider.length : null,
					network_row_2_location: this.network_row_2_location,
					network_row_2_send_speed: this.network_row_2_send_speed,
					network_row_2_rec_speed: this.network_row_2_rec_speed,
					network_row_2_ipv4: this.network_row_2_ipv4,
					network_row_3_provider: this.network_row_3_provider > 0 ? this.network_row_3_provider.length : null,
					network_row_3_location: this.network_row_3_location,
					network_row_3_send_speed: this.network_row_3_send_speed,
					network_row_3_rec_speed: this.network_row_3_rec_speed,
					network_row_3_ipv4: this.network_row_3_ipv4,
					network_row_4_provider: this.network_row_4_provider > 0 ? this.network_row_4_provider.length : null,
					network_row_4_location: this.network_row_4_location,
					network_row_4_send_speed: this.network_row_4_send_speed,
					network_row_4_rec_speed: this.network_row_4_rec_speed,
					network_row_4_ipv4: this.network_row_4_ipv4,
					network_row_5_provider: this.network_row_5_provider > 0 ? this.network_row_5_provider.length : null,
					network_row_5_location: this.network_row_5_location,
					network_row_5_send_speed: this.network_row_5_send_speed,
					network_row_5_rec_speed: this.network_row_5_rec_speed,
					network_row_5_ipv4: this.network_row_5_ipv4,
					network_row_6_provider: this.network_row_6_provider > 0 ? this.network_row_6_provider.length : null,
					network_row_6_location: this.network_row_6_location,
					network_row_6_send_speed: this.network_row_6_send_speed,
					network_row_6_rec_speed: this.network_row_6_rec_speed,
					network_row_6_ipv4: this.network_row_6_ipv4,
					network_row_7_provider: this.network_row_7_provider > 0 ? this.network_row_7_provider.length : null,
					network_row_7_location: this.network_row_7_location,
					network_row_7_send_speed: this.network_row_7_send_speed,
					network_row_7_rec_speed: this.network_row_7_rec_speed,
					network_row_7_ipv4: this.network_row_7_ipv4,
					network_row_8_provider: this.network_row_8_provider > 0 ? this.network_row_8_provider.length : null,
					network_row_8_location: this.network_row_8_location,
					network_row_8_send_speed: this.network_row_8_send_speed,
					network_row_8_rec_speed: this.network_row_8_rec_speed,
					network_row_8_ipv4: this.network_row_8_ipv4,
					network_row_9_provider: this.network_row_9_provider > 0 ? this.network_row_9_provider.length : null,
					network_row_9_location: this.network_row_9_location,
					network_row_9_send_speed: this.network_row_9_send_speed,
					network_row_9_rec_speed: this.network_row_9_rec_speed,
					network_row_9_ipv4: this.network_row_9_ipv4,
					network_row_10_provider: this.network_row_10_provider > 0 ? this.network_row_10_provider.length : null,
					network_row_10_location: this.network_row_10_location,
					network_row_10_send_speed: this.network_row_10_send_speed,
					network_row_10_rec_speed: this.network_row_10_rec_speed,
					network_row_10_ipv4: this.network_row_10_ipv4,
					network_row_11_provider: this.network_row_11_provider > 0 ? this.network_row_11_provider.length : null,
					network_row_11_location: this.network_row_11_location,
					network_row_11_send_speed: this.network_row_11_send_speed,
					network_row_11_rec_speed: this.network_row_11_rec_speed,
					network_row_11_ipv4: this.network_row_11_ipv4,
					network_row_12_provider: this.network_row_12_provider > 0 ? this.network_row_12_provider.length : null,
					network_row_12_location: this.network_row_12_location,
					network_row_12_send_speed: this.network_row_12_send_speed,
					network_row_12_rec_speed: this.network_row_12_rec_speed,
					network_row_12_ipv4: this.network_row_12_ipv4,
					network_row_13_provider: this.network_row_13_provider > 0 ? this.network_row_13_provider.length : null,
					network_row_13_location: this.network_row_13_location,
					network_row_13_send_speed: this.network_row_13_send_speed,
					network_row_13_rec_speed: this.network_row_13_rec_speed,
					network_row_13_ipv4: this.network_row_13_ipv4,
					network_row_14_provider: this.network_row_14_provider > 0 ? this.network_row_14_provider.length : null,
					network_row_14_location: this.network_row_14_location,
					network_row_14_send_speed: this.network_row_14_send_speed,
					network_row_14_rec_speed: this.network_row_14_rec_speed,
					network_row_14_ipv4: this.network_row_14_ipv4,
				})
				.then(res => {
					console.log(res.data)
				})
				.catch(err => {
					console.log(err.response.data)
					this.$page.props.flash.message = "Please correct the listed errors and try again"
					this.$page.props.flash.status = "error"
					this.errors = err.response.data
				})
			}
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

				// find RAM
				let ram_line = this.find_item_row('RAM', lines)
				if(ram_line) {
					this.ram = this.get_ram(lines[ram_line])
				}

				// find GB5 Single Core
				let gb5_single = this.find_item_row('Single Core', lines)
				if(gb5_single) {
					this.gb5_single = this.get_gb5(lines[gb5_single])
				}

				// find GB5 Multi Core
				let gb5_multi = this.find_item_row('Multi Core', lines)
				if(gb5_multi) {
					this.gb5_multi = this.get_gb5(lines[gb5_multi])
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

				// find ipv4 speeds
				let row_ipv4 = this.find_item_row('iperf3 Network Speed Tests (IPv4):', lines)
				if(row_ipv4) {
					for(let i = 1; i < 8; i++) {
						if(lines[i + row_ipv4 + 3].indexOf('|') > 0) {
							this['network_row_' + i + '_provider'] = this.get_network_row_provider(lines[i + row_ipv4 + 3])
							this['network_row_' + i + '_location'] = this.get_network_row_location(lines[i + row_ipv4 + 3])
							this['network_row_' + i + '_send_speed'] = this.get_network_row_send_speed(lines[i + row_ipv4 + 3])
							this['network_row_' + i + '_rec_speed'] = this.get_network_row_rec_speed(lines[i + row_ipv4 + 3])
						}
					}
				}

				// find ipv6 speeds
				let row_ipv6 = this.find_item_row('iperf3 Network Speed Tests (IPv6):', lines)
				if(row_ipv6) {
					for(let i = 1; i < 8; i++) {
						if(lines[i + row_ipv6 + 3].indexOf('|') > 0) {
							this['network_row_' + (i + 7) + '_provider'] = this.get_network_row_provider(lines[i + row_ipv6 + 3])
							this['network_row_' + (i + 7) + '_location'] = this.get_network_row_location(lines[i + row_ipv6 + 3])
							this['network_row_' + (i + 7) + '_send_speed'] = this.get_network_row_send_speed(lines[i + row_ipv6 + 3])
							this['network_row_' + (i + 7) + '_rec_speed'] = this.get_network_row_rec_speed(lines[i + row_ipv6 + 3])
						}
					}
				}
			}
		}
	}
</script>