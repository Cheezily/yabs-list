<template>
	<tr class="">
		<td @click="click_on_server" v-if="passed_show_columns.provider_name" class="row-item pl-1">
			<span v-if="server.note" class="text-purple-700 w-20"><font-awesome-icon icon="fa-message" /></span>
			<span v-else class="pl-4"></span>
			{{ server.provider_name }}
		</td>
		<td @click="click_on_server" v-if="passed_show_columns.type" class="row-item pl-2">{{ server.type }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.virtualization" class="row-item pl-2">{{ server.virtualization }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.when" class="row-item pl-2">{{ new Date(server.when).toLocaleString([], {
			month: 'short', day: '2-digit', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true}) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.city" class="row-item pl-2">{{ server.city }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.cpu" class="row-item pl-2">{{ server.cpu }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.cores" class="row-item pl-2">{{ server.cores }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.clock_speed" class="row-item pl-2">{{ server.clock_speed }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.ram" class="row-item pl-2">{{ format_ram_swap(server.ram) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.swap" class="row-item pl-2">{{ format_ram_swap(server.swap) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.distro" class="row-item pl-2">{{ server.distro }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.kernel" class="row-item pl-2">{{ server.kernel }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.aes_ni" class="row-item pl-2">{{ server.aes_ni ? 'Yes' : 'No' }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.vm_x" class="row-item pl-2">{{ server.vm_x ? 'Yes' : 'No' }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.geekbench_5_single" class="row-item pl-2">{{ server.geekbench_5_single }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.geekbench_5_multi" class="row-item pl-2">{{ server.geekbench_5_multi }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_read_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_4k_read_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_write_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_4k_write_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_total_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_4k_total_speed) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_read_iops" class="row-item pl-2">{{ format_iops(server.disk_4k_read_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_write_iops" class="row-item pl-2">{{ format_iops(server.disk_4k_write_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_4k_total_iops" class="row-item pl-2">{{ format_iops(server.disk_4k_total_iops) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_read_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_64k_read_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_write_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_64k_write_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_total_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_64k_total_speed) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_read_iops" class="row-item pl-2">{{ format_iops(server.disk_64k_read_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_write_iops" class="row-item pl-2">{{ format_iops(server.disk_64k_write_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_64k_total_iops" class="row-item pl-2">{{ format_iops(server.disk_64k_total_iops) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_read_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_512k_read_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_write_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_512k_write_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_total_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_512k_total_speed) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_read_iops" class="row-item pl-2">{{ format_iops(server.disk_512k_read_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_write_iops" class="row-item pl-2">{{ format_iops(server.disk_512k_write_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_512k_total_iops" class="row-item pl-2">{{ format_iops(server.disk_512k_total_iops) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_read_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_1m_read_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_write_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_1m_write_speed) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_total_speed" class="row-item pl-2">{{ format_disk_speed(server.disk_1m_total_speed) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_read_iops" class="row-item pl-2">{{ format_iops(server.disk_1m_read_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_write_iops" class="row-item pl-2">{{ format_iops(server.disk_1m_write_iops) }}</td>
		<td @click="click_on_server" v-if="passed_show_columns.disk_1m_total_iops" class="row-item pl-2">{{ format_iops(server.disk_1m_total_iops) }}</td>

		<td @click="click_on_server" v-if="passed_show_columns.average_network_speed" class="row-item pl-2">{{ format_disk_speed(server.average_network_speed) }}</td>

		<td v-if="user && server.user_id == user.id" class="delete-icon pl-2">
			<font-awesome-icon class="text-red-700 hover:text-red-500 text-xl" 
				@click="$emit('delete_server', server)"
				icon="fa-trash" aria-hidden="true" />
		</td>
	</tr>
</template>

<script>
	export default {
		props: [
			'user',
			'server',
			'passed_show_columns'
		],
		data() {
			return {
				selected_server: []
			}
		},
		methods: {
			click_on_server() {
				this.$emit('click_on_server', this.server)
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
	tr:hover > .row-item {
		background: rgb(224,223,255);
		background: linear-gradient(180deg, rgba(224,223,255,1) 0%, rgba(191,191,255,1) 39%, rgb(207, 229, 255) 100%);
		cursor: help;
	}

	.delete-icon:hover {
		background: white;
		cursor: pointer;
	}
</style>