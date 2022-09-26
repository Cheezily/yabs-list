<template>
	<tr class="" @click="hover_server">
		<td v-if="passed_show_columns.provider_name" class="pl-1">
			<span v-if="server.note" class="text-purple-700 w-20"><font-awesome-icon icon="fa-message" /></span>
			<span v-else class="pl-4"></span>
			{{ server.provider_name }}
		</td>
		<td v-if="passed_show_columns.type" class="pl-2">{{ server.type }}</td>
		<td v-if="passed_show_columns.virtualization" class="pl-2">{{ server.virtualization }}</td>
		<td v-if="passed_show_columns.when" class="pl-2">{{ new Date(server.when).toLocaleString() }}</td>
		<td v-if="passed_show_columns.city" class="pl-2">{{ server.city }}</td>
		<td v-if="passed_show_columns.cpu" class="pl-2">{{ server.cpu }}</td>
		<td v-if="passed_show_columns.cores" class="pl-2">{{ server.cores }}</td>
		<td v-if="passed_show_columns.clock_speed" class="pl-2">{{ server.clock_speed }}</td>
		<td v-if="passed_show_columns.ram" class="pl-2">{{ format_ram_swap(server.ram) }}</td>
		<td v-if="passed_show_columns.swap" class="pl-2">{{ format_ram_swap(server.swap) }}</td>
		<td v-if="passed_show_columns.distro" class="pl-2">{{ server.distro }}</td>
		<td v-if="passed_show_columns.kernel" class="pl-2">{{ server.kernel }}</td>
		<td v-if="passed_show_columns.aes_ni" class="pl-2">{{ server.aes_ni ? 'Yes' : 'No' }}</td>
		<td v-if="passed_show_columns.vm_x" class="pl-2">{{ server.vm_x ? 'Yes' : 'No' }}</td>
		<td v-if="passed_show_columns.geekbench_5_single" class="pl-2">{{ server.geekbench_5_single }}</td>
		<td v-if="passed_show_columns.geekbench_5_multi" class="pl-2">{{ server.geekbench_5_multi }}</td>

		<td v-if="passed_show_columns.disk_4k_read_speed" class="pl-2">{{ format_disk_speed(server.disk_4k_read_speed) }}</td>
		<td v-if="passed_show_columns.disk_4k_write_speed" class="pl-2">{{ format_disk_speed(server.disk_4k_write_speed) }}</td>
		<td v-if="passed_show_columns.disk_4k_total_speed" class="pl-2">{{ format_disk_speed(server.disk_4k_total_speed) }}</td>

		<td v-if="passed_show_columns.disk_4k_read_iops" class="pl-2">{{ format_iops(server.disk_4k_read_iops) }}</td>
		<td v-if="passed_show_columns.disk_4k_write_iops" class="pl-2">{{ format_iops(server.disk_4k_write_iops) }}</td>
		<td v-if="passed_show_columns.disk_4k_total_iops" class="pl-2">{{ format_iops(server.disk_4k_total_iops) }}</td>

		<td v-if="passed_show_columns.disk_64k_read_speed" class="pl-2">{{ format_disk_speed(server.disk_64k_read_speed) }}</td>
		<td v-if="passed_show_columns.disk_64k_write_speed" class="pl-2">{{ format_disk_speed(server.disk_64k_write_speed) }}</td>
		<td v-if="passed_show_columns.disk_64k_total_speed" class="pl-2">{{ format_disk_speed(server.disk_64k_total_speed) }}</td>

		<td v-if="passed_show_columns.disk_64k_read_iops" class="pl-2">{{ format_iops(server.disk_64k_read_iops) }}</td>
		<td v-if="passed_show_columns.disk_64k_write_iops" class="pl-2">{{ format_iops(server.disk_64k_write_iops) }}</td>
		<td v-if="passed_show_columns.disk_64k_total_iops" class="pl-2">{{ format_iops(server.disk_64k_total_iops) }}</td>

		<td v-if="passed_show_columns.disk_512k_read_speed" class="pl-2">{{ format_disk_speed(server.disk_512k_read_speed) }}</td>
		<td v-if="passed_show_columns.disk_512k_write_speed" class="pl-2">{{ format_disk_speed(server.disk_512k_write_speed) }}</td>
		<td v-if="passed_show_columns.disk_512k_total_speed" class="pl-2">{{ format_disk_speed(server.disk_512k_total_speed) }}</td>

		<td v-if="passed_show_columns.disk_512k_read_iops" class="pl-2">{{ format_iops(server.disk_512k_read_iops) }}</td>
		<td v-if="passed_show_columns.disk_512k_write_iops" class="pl-2">{{ format_iops(server.disk_512k_write_iops) }}</td>
		<td v-if="passed_show_columns.disk_512k_total_iops" class="pl-2">{{ format_iops(server.disk_512k_total_iops) }}</td>

		<td v-if="passed_show_columns.disk_1m_read_speed" class="pl-2">{{ format_disk_speed(server.disk_1m_read_speed) }}</td>
		<td v-if="passed_show_columns.disk_1m_write_speed" class="pl-2">{{ format_disk_speed(server.disk_1m_write_speed) }}</td>
		<td v-if="passed_show_columns.disk_1m_total_speed" class="pl-2">{{ format_disk_speed(server.disk_1m_total_speed) }}</td>

		<td v-if="passed_show_columns.disk_1m_read_iops" class="pl-2">{{ format_iops(server.disk_1m_read_iops) }}</td>
		<td v-if="passed_show_columns.disk_1m_write_iops" class="pl-2">{{ format_iops(server.disk_1m_write_iops) }}</td>
		<td v-if="passed_show_columns.disk_1m_total_iops" class="pl-2">{{ format_iops(server.disk_1m_total_iops) }}</td>

		<td v-if="passed_show_columns.average_network_speed" class="pl-2">{{ format_disk_speed(server.average_network_speed) }}</td>
	</tr>
</template>

<script>
	export default {
		props: [
			'server',
			'passed_show_columns'
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
		}
	}
</script>


<style scoped>
	tr:hover {
		background: rgb(224,223,255);
		background: linear-gradient(176deg, rgba(224,223,255,1) 0%, rgba(191,191,255,1) 39%, rgba(153,238,255,1) 100%);
		cursor: help;
	}
</style>