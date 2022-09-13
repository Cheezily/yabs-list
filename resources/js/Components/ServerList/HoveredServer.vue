<template>
	<div>
		<Transition name="slide-fade">
			<div v-if="Object.keys(hovered_server).length > 0" 
				class="hovered-server text-xs rounded-tl rounded-tr">
				<div class="flex justify-between">
					<div>
						<p class="column-title mb-2">Disk Speed</p>
						<ul>
							<li>4K Read Speed 
								{{ format_disk_speed(hovered_server.disk_4k_read_speed) }} 
								<b>({{ format_iops(hovered_server.disk_4k_read_iops) }} IOPS)</b>
							</li>
							<li>4K Write Speed 
								{{ format_disk_speed(hovered_server.disk_4k_write_speed) }}
								<b>({{ format_iops(hovered_server.disk_4k_write_iops) }} IOPS)</b>
							</li>
							<li>4K Total Speed 
								{{ format_disk_speed(hovered_server.disk_4k_total_speed) }}
								<b>({{ format_iops(hovered_server.disk_4k_total_iops) }} IOPS)</b>
							</li>
							<li class="divider"></li>
							<li>64K Read Speed 
								{{ format_disk_speed(hovered_server.disk_64k_read_speed) }} 
								<b>({{ format_iops(hovered_server.disk_64k_read_iops) }} IOPS)</b>
							</li>
							<li>64K Write Speed 
								{{ format_disk_speed(hovered_server.disk_64k_write_speed) }}
								<b>({{ format_iops(hovered_server.disk_64k_write_iops) }} IOPS)</b>
							</li>
							<li>64K Total Speed 
								{{ format_disk_speed(hovered_server.disk_64k_total_speed) }}
								<b>({{ format_iops(hovered_server.disk_64k_total_iops) }} IOPS)</b>
							</li>
							<li class="divider"></li>
							<li>512K Read Speed 
								{{ format_disk_speed(hovered_server.disk_512k_read_speed) }} 
								<b>({{ format_iops(hovered_server.disk_512k_read_iops) }} IOPS)</b>
							</li>
							<li>512K Write Speed 
								{{ format_disk_speed(hovered_server.disk_512k_write_speed) }}
								<b>({{ format_iops(hovered_server.disk_512k_write_iops) }} IOPS)</b>
							</li>
							<li>512K Total Speed 
								{{ format_disk_speed(hovered_server.disk_512k_total_speed) }}
								<b>({{ format_iops(hovered_server.disk_512k_total_iops) }} IOPS)</b>
							</li>
							<li class="divider"></li>
							<li>1M Read Speed 
								{{ format_disk_speed(hovered_server.disk_1m_read_speed) }} 
								<b>({{ format_iops(hovered_server.disk_1m_read_iops) }} IOPS)</b>
							</li>
							<li>1M Write Speed 
								{{ format_disk_speed(hovered_server.disk_1m_write_speed) }}
								<b>({{ format_iops(hovered_server.disk_1m_write_iops) }} IOPS)</b>
							</li>
							<li>1M Total Speed 
								{{ format_disk_speed(hovered_server.disk_1m_total_speed) }}
								<b>({{ format_iops(hovered_server.disk_1m_total_iops) }} IOPS)</b>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</Transition>
	</div>
</template>

<script>
	export default {
		props: [
			'hovered_server'
		],
		methods: {
			format_disk_speed(speed) {
				let speed_k = speed / 1000
				if(speed_k > 1000000) return (speed_k / 1000000).toFixed(2) + ' GB/s'
				if(speed_k > 1000) return (speed_k / 1000).toFixed(2) + ' MB/s'
				return speed_k.toFixed(2) + ' KB/s'
			},
			format_iops(iops) {
				if(iops > 1000) {return (iops / 1000).toFixed(2) + 'K'}
				return iops
			}
		},
		mounted() {
			console.log(this.hovered_server)
		}
	}
</script>

<style>
	.column-title {
		font-weight: bold;
	}

	.hovered-server {
		position: fixed;
		bottom: 0;
		left: 0;
		right: 0;
		margin: 0 auto;
		z-index: 100;
		height: 280px;
		max-width: 1000px;
		padding: 10px 12px 20px;
		box-shadow: 0 10px 10px 4px #777;
		background: rgb(224,223,255);
		background: linear-gradient(180deg, rgb(233, 232, 255) 0%, rgb(230, 230, 255) 40%, rgb(232, 251, 255) 100%); 
	}

	.divider {
		border-bottom: 1px solid #bbb;
		margin-top: 5px;
		margin-bottom: 5px;
	}

	.slide-fade-enter-active {
		transition: all 0.3s ease-out;
	}

	.slide-fade-leave-active {
		transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
	}

	.slide-fade-enter-from,
	.slide-fade-leave-to {
		transform: translateY(10px);
		opacity: 0;
	}
</style>