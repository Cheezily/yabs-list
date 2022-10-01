<template>
<div>

	<div v-if="!$page.props.auth.user">
		<h1 class="logo ml-3 -mt-6 left">
			<Link href="/">YABSLIST</Link>
		</h1>

		<h2 class="text-gray-600 py-6 px-6 rounded mb-6 bg-white text-lg">
			If you have an account, please log in to submit your results
			<Link :href="route('login')" class="font-bold text-orange-500 hover:text-orange-700 underline">Here</Link>
		</h2>
	</div>

	<div class="overflow-hidden shadow-sm sm:rounded-lg mb-32">
		<div class="rounded bg-white px-4 pb-4 pt-4 flex flex-wrap justify-content">
			<h2 class="mb-8 text-slate-700 text-xl w-full">
				Please fill in these fileds and paste your YABS output into the textarea below
				<button class="bg-amber-500 float-right text-white text-sm rounded hover:bg-amber-600 px-4 py-2 font-bold"
				@click="clear_all()">Clear All</button>
			</h2>

			<div class="pl-2 w-full">
				<label class="w-1/3 text-right inline-block text-gray-700" for="provider_name">
					What is the name of the service provider?
				</label>
				<font-awesome-icon class="absolute mr-2 w-10 text-gray-400 mt-2 ml-1" icon="fa-search" />
				<input v-model="provider_name" @focus="prevent_provider_search = false"
				id="provider_name" class="h-8 ml-2 w-1/2 rounded pl-7" type="text" />
				<p v-if="errors['provider_name']" class="w-1/3 text-xs italic text-red-500 text-right">
					{{ capitalize(errors.provider_name[0]) }}
				</p>
				<transition name="slide">
					<div v-if="provider_search_results.length > 0" class="mt-2 mb-4 flex justify-start">
						<p class="mr-2 w-1/3 text-right text-sm italic text-green-700">
							Suggestions:
						</p>
						<ul class="">
							<li v-for="result in provider_search_results" :key="result"
							class="w-full hover:font-bold cursor-pointer"
							@click="prevent_provider_search = true; provider_name = result.provider_name; provider_search_results = []">
								{{ result.provider_name }}
							</li>
						</ul>
					</div>
				</transition>
			</div>

			<div class="my-1 pl-2 w-full">
				<label class="w-1/3 text-right inline-block text-gray-700" for="city">
					What city is this server located in? <span class="text-gray-500">(Optional)</span>
				</label>
				<font-awesome-icon class="absolute mr-2 w-10 text-gray-400 mt-2 ml-1" icon="fa-search" />
				<input v-model="city" @focus="prevent_city_search = false"
				id="city" class="h-8 ml-2 w-1/2 rounded pl-7" type="text" />
				<p v-if="errors['city']" class="w-1/3 text-xs italic text-red-500 text-right">
					{{ capitalize(errors.city[0]) }}
				</p>
				<transition name="slide">
					<div v-if="city_search_results.length > 0" class="mt-2 mb-4 flex justify-start">
						<p class="mr-2 w-1/3 text-right text-sm italic text-green-700">
							Suggestions:
						</p>
						<ul class="">
							<li v-for="result in city_search_results" :key="result"
							class="w-full hover:font-bold cursor-pointer"
							@click="prevent_city_search = true; city = result.city; city_search_results = []">
								{{ result.city }}
							</li>
						</ul>
					</div>
				</transition>
			</div>

			<div class="my-1 pl-2 w-full">
				<label class="w-1/3 text-right inline-block text-gray-700" for="type">
					Is this a VPS or dedicated server?
				</label>
				<select class="h-8 text-sm pt-1 rounded ml-2" v-model="type">
					<option value="" disabled selected>Select One</option>
					<option value="vps">VPS</option>
					<option value="dedi">Dedicated</option>
				</select>
				<p v-if="errors['type']" class="w-1/3 text-xs italic text-red-500 text-right">
					{{ capitalize(errors.type[0]) }}
				</p>
			</div>

			<transition name="slide">
				<div v-if="type == 'vps'" class="my-1 pl-2 w-full">
					<label class="w-1/3 text-right inline-block text-gray-700" for="type">
						Virtualization Type? <span class="text-gray-500">(Optional)</span>
					</label>
					<select class="h-8 text-sm pt-1 rounded ml-2" v-model="virtualization">
						<option value="" disabled selected>Select One</option>
						<option v-for="virt_type in virt_types" :key="virt_type" :value=virt_type>{{ virt_type }}</option>
					</select>
					<p v-if="errors['virtualization']" class="w-1/3 text-xs italic text-red-500 text-right">
						{{ capitalize(errors.virtualization[0]) }}
					</p>
				</div>
			</transition>

			<div class="my-1 pl-2 w-full">
				<label class="align-top w-1/3 text-right inline-block text-gray-700" for="city">
					Any notes about this server you'd like to add? <span class="text-gray-500">(Optional)</span>
				</label>
				<textarea v-model="note"
				id="city" class="h-20 ml-2 w-1/2 rounded" type="text" />
			</div>

			<h1 class="text-slate-700 text-xl w-full mt-6">
				Paste your YABS output in the textarea below
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
		</div>

		<div class="rounded mt-6 bg-white px-6 pb-6 pt-3 border-2 border-amber-500">
			<h2 class="mb-6 text-gray-700 text-xl">
				These details should be auto-populated. Please make any corrections below.
			</h2>

			<div class="mt-1 flex flex-wrap justify-center text-gray-600">
				<div class="my-1 pl-2 w-1/2">
					<label class="w-1/3 inline-block text-sm text-right" for="when">When Was This Run?</label>
					<input v-model="when"
					id="when" class="ml-2 w-1/2 rounded text-sm h-7" type="text" />
					<p v-if="errors['when']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.cpu[0]) }}</p>
				</div>
			</div>

			<hr class="mt-2">

			<div class="mt-1 flex flex-wrap justify-content text-gray-600">
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
					<label class="w-1/4 inline-block text-sm text-right" for="ram">RAM (MB)</label>
					<input v-model="ram"
					id="ram" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
				</div>
				<div class="my-1 pl-2 w-1/2">
					<label class="w-1/4 inline-block text-sm text-right" for="swap">Swap (MB)</label>
					<input v-model="swap"
					id="swap" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
				</div>
				<div class="my-1 pl-2 w-1/2">
					<label class="w-1/4 inline-block text-sm text-right" for="geekbench_5_single">GB 5 Single Score</label>
					<input v-model="geekbench_5_single"
					id="geekbench_5_single" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
				</div>
				<div class="my-1 pl-2 w-1/2">
					<label class="w-1/4 inline-block text-sm text-right" for="geekbench_5_multi">GB 5 Multi Score</label>
					<input v-model="geekbench_5_multi"
					id="geekbench_5_multi" class="ml-2 rounded w-3/6 text-sm h-7" type="text" />
				</div>
				<p v-if="errors['cpu']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.cpu[0]) }}</p>
				<p v-if="errors['cores']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.cores[0]) }}</p>
				<p v-if="errors['clock_speed']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.clock_speed[0]) }}</p>
				<p v-if="errors['ram']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.ram[0]) }}</p>
				<p v-if="errors['swap']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.swap[0]) }}</p>
				<p v-if="errors['geekbench_5_single']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.geekbench_5_single[0]) }}</p>
				<p v-if="errors['geekbench_5_multi']" class="w-full text-xs italic text-red-500 text-center">{{ capitalize(errors.geekbench_5_multi[0]) }}</p>
			</div>

			<hr class="mt-2 mb-2">

			<div class="mt-1 flex flex-wrap justify-content text-gray-600">
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

			<div class="mt-1 flex flex-wrap justify-content text-gray-600">
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

			<h2 class="mt-3 mb-3 text-gray-600 text-m text-center">
				Disk Performance - All data should be an integer with speed denoted in bytes/s, not MB/s or GB/s
			</h2>

			<div class="mt-1 flex flex-wrap justify-content">
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_read_speed">4K Read Speed</label>
					<input v-model="disk_4k_read_speed"
					id="disk_4k_read_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_write_speed">4K Write Speed</label>
					<input v-model="disk_4k_write_speed"
					id="disk_4k_write_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_total_speed">4K Total Speed</label>
					<input v-model="disk_4k_total_speed"
					id="disk_4k_total_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_4k_read_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_read_speed[0]) }}</p>
				<p v-if="errors['disk_4k_write_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_write_speed[0]) }}</p>
				<p v-if="errors['disk_4k_total_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_total_speed[0]) }}</p>
				
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_read_iops">4K Read IOPS</label>
					<input v-model="disk_4k_read_iops"
					id="disk_4k_read_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_write_iops">4K Write IOPS</label>
					<input v-model="disk_4k_write_iops"
					id="disk_4k_write_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_4k_total_iops">4K Total IOPS</label>
					<input v-model="disk_4k_total_iops"
					id="disk_4k_total_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_4k_read_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_read_iops[0]) }}</p>
				<p v-if="errors['disk_4k_write_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_write_iops[0]) }}</p>
				<p v-if="errors['disk_4k_total_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_4k_total_iops[0]) }}</p>

				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_read_speed">64K Read Speed</label>
					<input v-model="disk_64k_read_speed"
					id="disk_64k_read_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_write_speed">64K Write Speed</label>
					<input v-model="disk_64k_write_speed"
					id="disk_64k_write_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_total_speed">64K Total Speed</label>
					<input v-model="disk_64k_total_speed"
					id="disk_64k_total_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_64k_read_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_read_speed[0]) }}</p>
				<p v-if="errors['disk_64k_write_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_write_speed[0]) }}</p>
				<p v-if="errors['disk_64k_total_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_total_speed[0]) }}</p>

				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_read_iops">64K Read IOPS</label>
					<input v-model="disk_64k_read_iops"
					id="disk_64k_read_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_write_iops">64K Write IOPS</label>
					<input v-model="disk_64k_write_iops"
					id="disk_64k_write_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_64k_total_iops">64K Total IOPS</label>
					<input v-model="disk_64k_total_iops"
					id="disk_64k_total_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_64k_read_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_read_iops[0]) }}</p>
				<p v-if="errors['disk_64k_write_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_write_iops[0]) }}</p>
				<p v-if="errors['disk_64k_total_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_64k_total_iops[0]) }}</p>

				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_read_speed">512K Read Speed</label>
					<input v-model="disk_512k_read_speed"
					id="disk_512k_read_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_write_speed">512K Write Speed</label>
					<input v-model="disk_512k_write_speed"
					id="disk_512k_write_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_total_speed">512K Total Speed</label>
					<input v-model="disk_512k_total_speed"
					id="disk_512k_total_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_512k_read_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_read_speed[0]) }}</p>
				<p v-if="errors['disk_512k_write_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_write_speed[0]) }}</p>
				<p v-if="errors['disk_512k_total_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_total_speed[0]) }}</p>
				
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_read_iops">512K Read IOPS</label>
					<input v-model="disk_512k_read_iops"
					id="disk_512k_read_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_write_iops">512K Write IOPS</label>
					<input v-model="disk_512k_write_iops"
					id="disk_512k_write_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_512k_total_iops">512K Total IOPS</label>
					<input v-model="disk_512k_total_iops"
					id="disk_512k_total_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				
				<p v-if="errors['disk_512k_read_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_read_iops[0]) }}</p>
				<p v-if="errors['disk_512k_write_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_write_iops[0]) }}</p>
				<p v-if="errors['disk_512k_total_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_512k_total_iops[0]) }}</p>

				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_read_speed">1M Read Speed</label>
					<input v-model="disk_1m_read_speed"
					id="disk_1m_read_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_write_speed">1M Write Speed</label>
					<input v-model="disk_1m_write_speed"
					id="disk_1m_write_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_total_speed">1M Total Speed</label>
					<input v-model="disk_1m_total_speed"
					id="disk_1m_total_speed" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_1m_read_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_read_speed[0]) }}</p>
				<p v-if="errors['disk_1m_write_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_write_speed[0]) }}</p>
				<p v-if="errors['disk_1m_total_speed']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_total_speed[0]) }}</p>
				
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_read_iops">1M Read IOPS</label>
					<input v-model="disk_1m_read_iops"
					id="disk_1m_read_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_write_iops">1M Write IOPS</label>
					<input v-model="disk_1m_write_iops"
					id="disk_1m_write_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>
				<div class="mt-1 pl-2 w-1/3 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" for="disk_1m_total_iops">1M Total IOPS</label>
					<input v-model="disk_1m_total_iops"
					id="disk_1m_total_iops" class="rounded w-2/3 h-7 text-sm" type="text" />
				</div>

				<p v-if="errors['disk_1m_read_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_read_iops[0]) }}</p>
				<p v-if="errors['disk_1m_write_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_write_iops[0]) }}</p>
				<p v-if="errors['disk_1m_total_iops']" class="w-1/3 text-xs italic text-red-500 text-right">{{ capitalize(errors.disk_1m_total_iops[0]) }}</p>
			</div>

			<hr class="mt-4 mb-2">

			<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
				IPv4 Network Performance - All speed data should be an integer, denoted in bits/s, not MB/s or GB/s
			</h2>

			<div v-for="i in 7" :key="i" class="mt-1 flex flex-wrap justify-content">
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + i + '_provider'">Provider</label>
					<input v-model="$data['network_row_' + i + '_provider']"
					:id="'network_row_' + i + '_provider'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + i + '_provider']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + i + '_provider'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + i + '_location'">Location</label>
					<input v-model="$data['network_row_' + i + '_location']"
					:id="'network_row_' + i + '_location'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + i + '_location']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + i + '_location'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + i + '_send_speed'">Send Speed</label>
					<input v-model="$data['network_row_' + i + '_send_speed']"
					:id="'network_row_' + i + '_send_speed'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + i + '_send_speed']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + i + '_send_speed'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + i + '_rec_speed'">Rec Speed</label>
					<input v-model="$data['network_row_' + i + '_rec_speed']"
					:id="'network_row_' + i + '_rec_speed'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + i + '_rec_speed']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + i + '_rec_speed'][0] }}</p>
				</div>
			</div>

			<hr class="mt-4 mb-2">

			<h2 class="mt-3 mb-3 text-gray-700 text-m text-center">
				IPv6 Network Performance - All speed data should be an integer, denoted in bits/s, not MB/s or GB/s
			</h2>
			
			<div v-for="i in 7" :key="i" class="mt-1 flex flex-wrap justify-content">
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + (i + 7) + '_provider'">Provider</label>
					<input v-model="$data['network_row_' + (i + 7) + '_provider']"
					:id="'network_row_' + (i + 7) + '_provider'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + (i + 7) + '_provider']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + (i + 7) + '_provider'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + (i + 7) + '_location'">Location</label>
					<input v-model="$data['network_row_' + (i + 7) + '_location']"
					:id="'network_row_' + (i + 7) + '_location'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + (i + 7) + '_location']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + (i + 7) + '_location'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + (i + 7) + '_send_speed'">Send Speed</label>
					<input v-model="$data['network_row_' + (i + 7) + '_send_speed']"
					:id="'network_row_' + (i + 7) + '_send_speed'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + (i + 7) + '_send_speed']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + (i + 7) + '_send_speed'][0] }}</p>
				</div>
				<div class="mt-1 pl-2 w-1/4 ">
					<label class="w-1/3 inline-block text-xs text-right pr-2 text-gray-600" :for="'network_row_' + (i + 7) + '_rec_speed'">Rec Speed</label>
					<input v-model="$data['network_row_' + (i + 7) + '_rec_speed']"
					:id="'network_row_' + (i + 7) + '_rec_speed'" class="rounded w-2/3 h-7 text-sm" type="text" />
					<p v-if="errors['network_row_' + (i + 7) + '_rec_speed']" class="w-full text-xs italic text-red-500 text-right">
						{{ errors['network_row_' + (i + 7) + '_rec_speed'][0] }}</p>
				</div>
			</div>

			<div class="flex justify-end mt-8">
				<button type="submit" class="bg-green-400 rounded px-4 py-2 text-white font-bold shadow hover:bg-green-600"
				@click="submit">Submit</button>
			</div>

		</div>
	</div>
</div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

	export default {
		props: [
			'user',
			'virt_types_string'
		],
		components: {
			Link
		},
		data() {
			return {
				provider_search_results: [],
				city_search_results: [],
				prevent_provider_search: false,
				prevent_city_search: false,
				virt_types: [],
				errors: {},
				yabs_text: '',
				provider_name: '',
				type: 'vps',
				when: '',
				city: '',
				virtualization: '',
				note: '',
				cpu: '',
				cores: '',
				clock_speed: '',
				ram: '',
				swap: '',
				geekbench_5_single: '',
				geekbench_5_multi: '',
				aes_ni: false,
				vm_x: false,
				distro: '',
				kernel: '',
				disk_4k_read_speed: '',
				disk_4k_write_speed: '',
				disk_4k_total_speed: '',
				disk_4k_read_iops: '',
				disk_4k_write_iops: '',
				disk_4k_total_iops: '',
				disk_64k_read_speed: '',
				disk_64k_write_speed: '',
				disk_64k_total_speed: '',
				disk_64k_read_iops: '',
				disk_64k_write_iops: '',
				disk_64k_total_iops: '',
				disk_512k_read_speed: '',
				disk_512k_write_speed: '',
				disk_512k_total_speed: '',
				disk_512k_read_iops: '',
				disk_512k_write_iops: '',
				disk_512k_total_iops: '',
				disk_1m_read_speed: '',
				disk_1m_write_speed: '',
				disk_1m_total_speed: '',
				disk_1m_read_iops: '',
				disk_1m_write_iops: '',
				disk_1m_total_iops: '',
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
			clear_all() {
				this.errors = {}
				this.yabs_text = ''
				this.provider_name = ''
				this.type = ''
				this.when = ''
				this.city = ''
				this.virtualization = ''
				this.note = ''
				this.cpu = ''
				this.cores = ''
				this.clock_speed = ''
				this.ram = ''
				this.swap = ''
				this.geekbench_5_single = ''
				this.geekbench_5_multi = ''
				this.aes_ni = false
				this.vm_x = false
				this.distro = ''
				this.kernel = ''
				this.disk_4k_read_speed = ''
				this.disk_4k_write_speed = ''
				this.disk_4k_total_speed = ''
				this.disk_4k_read_iops = ''
				this.disk_4k_write_iops = ''
				this.disk_4k_total_iops = ''
				this.disk_64k_read_speed = ''
				this.disk_64k_write_speed = ''
				this.disk_64k_total_speed = ''
				this.disk_64k_read_iops = ''
				this.disk_64k_write_iops = ''
				this.disk_64k_total_iops = ''
				this.disk_512k_read_speed = ''
				this.disk_512k_write_speed = ''
				this.disk_512k_total_speed = ''
				this.disk_512k_read_iops = ''
				this.disk_512k_write_iops = ''
				this.disk_512k_total_iops = ''
				this.disk_1m_read_speed = ''
				this.disk_1m_write_speed = ''
				this.disk_1m_total_speed = ''
				this.disk_1m_read_iops = ''
				this.disk_1m_write_iops = ''
				this.disk_1m_total_iops = ''
				this.network_row_1_provider = ''
				this.network_row_1_location = ''
				this.network_row_1_send_speed = ''
				this.network_row_1_rec_speed = ''
				this.network_row_1_ipv4 = true
				this.network_row_2_provider = ''
				this.network_row_2_location = ''
				this.network_row_2_send_speed = ''
				this.network_row_2_rec_speed = ''
				this.network_row_2_ipv4 = true
				this.network_row_3_provider = ''
				this.network_row_3_location = ''
				this.network_row_3_send_speed = ''
				this.network_row_3_rec_speed = ''
				this.network_row_3_ipv4 = true
				this.network_row_4_provider = ''
				this.network_row_4_location = ''
				this.network_row_4_send_speed = ''
				this.network_row_4_rec_speed = ''
				this.network_row_4_ipv4 = true
				this.network_row_5_provider = ''
				this.network_row_5_location = ''
				this.network_row_5_send_speed = ''
				this.network_row_5_rec_speed = ''
				this.network_row_5_ipv4 = true
				this.network_row_6_provider = ''
				this.network_row_6_location = ''
				this.network_row_6_send_speed = ''
				this.network_row_6_rec_speed = ''
				this.network_row_6_ipv4 = true
				this.network_row_7_provider = ''
				this.network_row_7_location = ''
				this.network_row_7_send_speed = ''
				this.network_row_7_rec_speed = ''
				this.network_row_7_ipv4 = true
				this.network_row_8_provider = ''
				this.network_row_8_location = ''
				this.network_row_8_send_speed = ''
				this.network_row_8_rec_speed = ''
				this.network_row_8_ipv4 = false
				this.network_row_9_provider = ''
				this.network_row_9_location = ''
				this.network_row_9_send_speed = ''
				this.network_row_9_rec_speed = ''
				this.network_row_9_ipv4 = false
				this.network_row_10_provider = ''
				this.network_row_10_location = ''
				this.network_row_10_send_speed = ''
				this.network_row_10_rec_speed = ''
				this.network_row_10_ipv4 = false
				this.network_row_11_provider = ''
				this.network_row_11_location = ''
				this.network_row_11_send_speed = ''
				this.network_row_11_rec_speed = ''
				this.network_row_11_ipv4 = false
				this.network_row_12_provider = ''
				this.network_row_12_location = ''
				this.network_row_12_send_speed = ''
				this.network_row_12_rec_speed = ''
				this.network_row_12_ipv4 = false
				this.network_row_13_provider = ''
				this.network_row_13_location = ''
				this.network_row_13_send_speed = ''
				this.network_row_13_rec_speed = ''
				this.network_row_13_ipv4 = false
				this.network_row_14_provider = ''
				this.network_row_14_location = ''
				this.network_row_14_send_speed = ''
				this.network_row_14_rec_speed = ''
				this.network_row_14_ipv4 = false
			},
			provider_search(search_terms) {
				axios.get(route('provider_search'), 
					{
						params: {
							search_terms
						}
					})
					.then(res => {
						this.provider_search_results = res.data
					})
			},
			city_search(search_terms) {
				axios.get(route('city_search'), 
					{
						params: {
							search_terms
						}
					})
					.then(res => {
						this.city_search_results = res.data
					})
			},
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
			get_when(line) {
				return line.trim()
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
					ram *= 1000
				} else {
					ram *= 1
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
					swap *= 1000
				} else {
					swap *= 1
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
				if(isNaN(speed)) {return 0}

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
				if(isNaN(speed)) {return 0}

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
				axios.post(route('create_server'),{
					provider_name: this.provider_name.trim(),
					type: this.type.trim(),
					when: this.when.trim(),
					city: this.city.trim(),
					virtualization: this.virtualization.trim(),
					note: this.note.trim(),
					cpu: this.cpu,
					cores: this.cores,
					clock_speed: this.clock_speed,
					ram: this.ram,
					swap: this.swap,
					geekbench_5_single: this.geekbench_5_single,
					geekbench_5_multi: this.geekbench_5_multi,
					aes_ni: this.aes_ni,
					vm_x: this.vm_x,
					distro: this.distro,
					kernel: this.kernel,
					disk_4k_read_speed: this.disk_4k_read_speed,
					disk_4k_write_speed: this.disk_4k_write_speed,
					disk_4k_total_speed: this.disk_4k_total_speed,
					disk_4k_read_iops: this.disk_4k_read_iops,
					disk_4k_write_iops: this.disk_4k_write_iops,
					disk_4k_total_iops: this.disk_4k_total_iops,
					disk_64k_read_speed: this.disk_64k_read_speed,
					disk_64k_write_speed: this.disk_64k_write_speed,
					disk_64k_total_speed: this.disk_64k_total_speed,
					disk_64k_read_iops: this.disk_64k_read_iops,
					disk_64k_write_iops: this.disk_64k_write_iops,
					disk_64k_total_iops: this.disk_64k_total_iops,
					disk_512k_read_speed: this.disk_512k_read_speed,
					disk_512k_write_speed: this.disk_512k_write_speed,
					disk_512k_total_speed: this.disk_512k_total_speed,
					disk_512k_read_iops: this.disk_512k_read_iops,
					disk_512k_write_iops: this.disk_512k_write_iops,
					disk_512k_total_iops: this.disk_512k_total_iops,
					disk_1m_read_speed: this.disk_1m_read_speed,
					disk_1m_write_speed: this.disk_1m_write_speed,
					disk_1m_total_speed: this.disk_1m_total_speed,
					disk_1m_read_iops: this.disk_1m_read_iops,
					disk_1m_write_iops: this.disk_1m_write_iops,
					disk_1m_total_iops: this.disk_1m_total_iops,
					network_row_1_provider: this.network_row_1_provider.length > 0 ? this.network_row_1_provider : null,
					network_row_1_location: this.network_row_1_location,
					network_row_1_send_speed: this.network_row_1_send_speed,
					network_row_1_rec_speed: this.network_row_1_rec_speed,
					network_row_1_ipv4: this.network_row_1_ipv4,
					network_row_2_provider: this.network_row_2_provider.length  > 0 ? this.network_row_2_provider : null,
					network_row_2_location: this.network_row_2_location,
					network_row_2_send_speed: this.network_row_2_send_speed,
					network_row_2_rec_speed: this.network_row_2_rec_speed,
					network_row_2_ipv4: this.network_row_2_ipv4,
					network_row_3_provider: this.network_row_3_provider.length  > 0 ? this.network_row_3_provider : null,
					network_row_3_location: this.network_row_3_location,
					network_row_3_send_speed: this.network_row_3_send_speed,
					network_row_3_rec_speed: this.network_row_3_rec_speed,
					network_row_3_ipv4: this.network_row_3_ipv4,
					network_row_4_provider: this.network_row_4_provider.length  > 0 ? this.network_row_4_provider : null,
					network_row_4_location: this.network_row_4_location,
					network_row_4_send_speed: this.network_row_4_send_speed,
					network_row_4_rec_speed: this.network_row_4_rec_speed,
					network_row_4_ipv4: this.network_row_4_ipv4,
					network_row_5_provider: this.network_row_5_provider.length  > 0 ? this.network_row_5_provider : null,
					network_row_5_location: this.network_row_5_location,
					network_row_5_send_speed: this.network_row_5_send_speed,
					network_row_5_rec_speed: this.network_row_5_rec_speed,
					network_row_5_ipv4: this.network_row_5_ipv4,
					network_row_6_provider: this.network_row_6_provider.length  > 0 ? this.network_row_6_provider : null,
					network_row_6_location: this.network_row_6_location,
					network_row_6_send_speed: this.network_row_6_send_speed,
					network_row_6_rec_speed: this.network_row_6_rec_speed,
					network_row_6_ipv4: this.network_row_6_ipv4,
					network_row_7_provider: this.network_row_7_provider.length > 0 ? this.network_row_7_provider : null,
					network_row_7_location: this.network_row_7_location,
					network_row_7_send_speed: this.network_row_7_send_speed,
					network_row_7_rec_speed: this.network_row_7_rec_speed,
					network_row_7_ipv4: this.network_row_7_ipv4,
					network_row_8_provider: this.network_row_8_provider.length  > 0 ? this.network_row_8_provider : null,
					network_row_8_location: this.network_row_8_location,
					network_row_8_send_speed: this.network_row_8_send_speed,
					network_row_8_rec_speed: this.network_row_8_rec_speed,
					network_row_8_ipv4: this.network_row_8_ipv4,
					network_row_9_provider: this.network_row_9_provider.length  > 0 ? this.network_row_9_provider : null,
					network_row_9_location: this.network_row_9_location,
					network_row_9_send_speed: this.network_row_9_send_speed,
					network_row_9_rec_speed: this.network_row_9_rec_speed,
					network_row_9_ipv4: this.network_row_9_ipv4,
					network_row_10_provider: this.network_row_10_provider.length  > 0 ? this.network_row_10_provider : null,
					network_row_10_location: this.network_row_10_location,
					network_row_10_send_speed: this.network_row_10_send_speed,
					network_row_10_rec_speed: this.network_row_10_rec_speed,
					network_row_10_ipv4: this.network_row_10_ipv4,
					network_row_11_provider: this.network_row_11_provider.length  > 0 ? this.network_row_11_provider : null,
					network_row_11_location: this.network_row_11_location,
					network_row_11_send_speed: this.network_row_11_send_speed,
					network_row_11_rec_speed: this.network_row_11_rec_speed,
					network_row_11_ipv4: this.network_row_11_ipv4,
					network_row_12_provider: this.network_row_12_provider.length  > 0 ? this.network_row_12_provider : null,
					network_row_12_location: this.network_row_12_location,
					network_row_12_send_speed: this.network_row_12_send_speed,
					network_row_12_rec_speed: this.network_row_12_rec_speed,
					network_row_12_ipv4: this.network_row_12_ipv4,
					network_row_13_provider: this.network_row_13_provider.length  > 0 ? this.network_row_13_provider : null,
					network_row_13_location: this.network_row_13_location,
					network_row_13_send_speed: this.network_row_13_send_speed,
					network_row_13_rec_speed: this.network_row_13_rec_speed,
					network_row_13_ipv4: this.network_row_13_ipv4,
					network_row_14_provider: this.network_row_14_provider.length  > 0 ? this.network_row_14_provider : null,
					network_row_14_location: this.network_row_14_location,
					network_row_14_send_speed: this.network_row_14_send_speed,
					network_row_14_rec_speed: this.network_row_14_rec_speed,
					network_row_14_ipv4: this.network_row_14_ipv4,
				})
				.then(res => {
					this.$page.props.flash.status = 'success'
					this.$page.props.flash.message = res.data
					this.clear_all()
				})
				.catch(err => {
					if (err.response.data.flash) {
						this.$page.props.flash.message = err.response.data.flash[0]
					} else {
						this.$page.props.flash.message = "Please correct the listed errors and try again"
					}
					
					this.$page.props.flash.status = "error"
					this.errors = err.response.data
				})
			}
		},
		watch: {
			provider_name(r) {
				if (!this.prevent_provider_search) {
					if (r.length > 0) {
						this.provider_search(r)
					} else {
						this.provider_search_results = []
					}
				}
			},
			city(r) {
				if (!this.prevent_city_search) {
					if (r.length > 0) {
						this.city_search(r)
					} else {
						this.city_search_results = []
					}
				}
			},
			type(r) {
				if(r != 'dedi') {
					this.virtualization = ''
				}
			},
			when(r) {
				console.log(new Date(r))
			},
			yabs_text(r) {
				let lines = r.split('\n')

				// find CPU
				let when_line = this.find_item_row('Basic System Information:', lines)
				if(when_line) {
					this.when = this.get_when(lines[when_line - 2])
				}

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
				let geekbench_5_single = this.find_item_row('Single Core', lines)
				if(geekbench_5_single) {
					this.geekbench_5_single = this.get_gb5(lines[geekbench_5_single])
				}

				// find GB5 Multi Core
				let geekbench_5_multi = this.find_item_row('Multi Core', lines)
				if(geekbench_5_multi) {
					this.geekbench_5_multi = this.get_gb5(lines[geekbench_5_multi])
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
					this.disk_4k_read_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k])
					this.disk_4k_write_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k + 1])
					this.disk_4k_total_speed = this.get_4k_64k_disk_speed(lines[row_4k_64k + 2])

					this.disk_64k_read_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k])
					this.disk_64k_write_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k + 1])
					this.disk_64k_total_speed = this.get_512k_1m_disk_speed(lines[row_4k_64k + 2])

					this.disk_4k_read_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k])
					this.disk_4k_write_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k + 1])
					this.disk_4k_total_iops = this.get_4k_64k_disk_iops(lines[row_4k_64k + 2])

					this.disk_64k_read_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k])
					this.disk_64k_write_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k + 1])
					this.disk_64k_total_iops = this.get_512k_1m_disk_iops(lines[row_4k_64k + 2])
				}

				// find 512K speeds
				let row_512k_1m = this.find_item_second_row('Read', lines)
				if(row_512k_1m) {
					this.disk_512k_read_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m])
					this.disk_512k_write_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m + 1])
					this.disk_512k_total_speed = this.get_4k_64k_disk_speed(lines[row_512k_1m + 2])
					
					this.disk_1m_read_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m])
					this.disk_1m_write_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m + 1])
					this.disk_1m_total_speed = this.get_512k_1m_disk_speed(lines[row_512k_1m + 2])

					this.disk_512k_read_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m])
					this.disk_512k_write_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m + 1])
					this.disk_512k_total_iops = this.get_4k_64k_disk_iops(lines[row_512k_1m + 2])
					
					this.disk_1m_read_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m])
					this.disk_1m_write_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m + 1])
					this.disk_1m_total_iops = this.get_512k_1m_disk_iops(lines[row_512k_1m + 2])
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
		},
		mounted() {
			this.virt_types = this.virt_types_string.split(',')
		}
	}
</script>

<style scoped>
	.slide-enter-active {
			transition: all 0.2s ease-out;
	}
	
	.slide-leave-active {
			transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
	}
	
	.slide-enter-from,
	.slide-leave-to {
			transform: translateX(350px);
	}
</style>