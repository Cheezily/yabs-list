<template>
	<tr class="" @mouseover="hover_server" @mouseleave="clear_hovered_server">
		<td class="pl-2">{{ server.provider_name }}</td>
		<td class="pl-2">{{ server.type }}</td>
		<td class="pl-2">{{ new Date(server.when).toLocaleString() }}</td>
		<td class="pl-2">{{ server.city }}</td>
		<td class="pl-2">{{ server.cpu }}</td>
		<td class="pl-2">{{ server.cores }}</td>
		<td class="pl-2">{{ format_ram_swap(server.ram) }}</td>
		<td class="pl-2">{{ format_disk_speed(server.disk_4k_total_speed) }}</td>
		<td class="pl-2">{{ format_iops(server.disk_4k_total_iops) }}</td>
		<td class="pl-2">{{ average_network_speed(server.networks) }}</td>
		<td class="pl-2 pr-2">{{ server.geekbench_5_single }}</td>
		<td class="pl-2 pr-2">{{ server.geekbench_5_multi }}</td>
	</tr>
</template>

<script>
	export default {
		props: [
			'server'
		],
		data() {
			return {
				selected_server: []
			}
		},
		methods: {
			hover_server(server) {
				// console.log(this.server)
				this.$emit('hover_on_server', this.server)
			},
			clear_hovered_server() {
				this.$emit('clear_hovered_server', true)
			},
			format_ram_swap(mem) {
				if(mem > 1000) {return (mem / 1000).toFixed(2) + 'G'}
				return mem + "M"
			},
			format_disk_speed(speed) {
				let speed_k = speed / 1000
				if(speed_k > 1000000) return (speed_k / 1000000).toFixed(2) + ' GB/s'
				if(speed_k > 1000) return (speed_k / 1000).toFixed(2) + ' MB/s'
				return speed_k.toFixed(2) + ' KB/s'
			},
			format_iops(iops) {
				if(iops > 1000) {return (iops / 1000).toFixed(2) + 'K'}
				return iops
			},
			average_network_speed(networks) {
				let total = 0
				let average = 0
				for(let i = 0; i < networks.length; i++) {
					total += networks[i].send_speed
					total += networks[i].receive_speed
				}
				average = total / (networks.length * 2) / 1000
				if(average > 1000000) return (average / 1000000).toFixed(2) + ' GB/s'
				if(average > 1000) return (average / 1000).toFixed(2) + ' MB/s'
				return average.toFixed(2) + ' KB/s'
			}
		}
	}
</script>


<style scoped>
	tr:hover {
		/* background: #ddf; */
		background: rgb(224,223,255);
		background: linear-gradient(176deg, rgba(224,223,255,1) 0%, rgba(191,191,255,1) 39%, rgba(153,238,255,1) 100%);
		cursor: help;
	}
</style>