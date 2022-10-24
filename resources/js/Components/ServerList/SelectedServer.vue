<template>
	<div>
		<Transition name="slide-fade">
			<div v-if="Object.keys(server).length > 0" 
				class="hovered-server text-xs rounded-tl rounded-tr">

				<button 
				@click="$emit('clear_selected_server')"
				class="close-options">
					<font-awesome-icon class="close-icon" icon="fa-xmark" />
				</button>

				<div class="md:flex justify-between">
					<div class="-mt-4 w-full md:w-6/12">
						<p class="column-title mb-2 text-sm">Network Tests</p>
						<ul class="">
							<li v-for="network in server.networks" :key=network.id
							class="mb-3">
								<p>
									<b>{{ network.location }}</b> - 
									{{ network.provider }} 
									<b>({{ network.ipv4 ? 'IPv4' : 'IPv6' }})</b>
								</p>
								<p>Receive Speed: ({{ format_network_speed(network.receive_speed) }})</p>
								<p>Send Speed: ({{ format_network_speed(network.send_speed) }})</p>
							</li>
						</ul>
					</div>

					<div class="mt-10 mb-8 md:-mt-4 md:w-5/12 sm:w-full">
						<p class="column-title mb-2 text-sm md:ml-10 sm:mr-0">Note:</p>
						<div class="text-xs md:ml-10">
							{{ server.note }}
						</div>
					</div>

					<div class="-ml-2 w-60"></div>
				</div>
			</div>
		</Transition>
	</div>
</template>

<script>
	export default {
		props: [
			'selected_server'
		],
		data() {
			return {
				server: {}
			}
		},
		methods: {
			format_network_speed(speed) {
				if(speed === 0) {return 'Busy'}
				let speed_k = speed / 1000
				if(speed_k > 1000000) return (speed_k / 1000000).toFixed(2) + ' GB/s'
				if(speed_k > 1000) return (speed_k / 1000).toFixed(2) + ' MB/s'
				return speed_k.toFixed(2) + ' KB/s'
			},
			get_server_details() {
				axios.post(route('get_network_details'), {
					server: this.selected_server.id
				})
				.then(res => {
					console.log()
					this.server = res.data
				})
			}
		},
		watch: {
			selected_server() {
				console.log('clicked on server')
				console.log(this.selected_server)
				this.server = this.selected_server
				this.get_server_details()
			}
		},
		mounted() {
			console.log(this.selected_server)
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
		z-index: 10;
		height: 360px;
		max-width: 800px;
		padding: 10px 12px 20px;
		overflow: auto;
		box-shadow: 0 10px 10px 4px #777;
		background: linear-gradient(180deg, rgb(233, 232, 255) 0%, rgb(230, 230, 255) 40%, rgb(232, 251, 255) 100%); 
	}

	@media screen and (max-width: 1440px) {
		.hovered-server {
			right: 0;
			left: auto;
			
		}
	}

	.divider {
		border-bottom: 1px solid #bbb;
		margin-top: 5px;
		margin-bottom: 5px;
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
		transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
	}

	.slide-fade-enter-from,
	.slide-fade-leave-to {
		transform: translateY(10px);
		opacity: 0;
	}
</style>