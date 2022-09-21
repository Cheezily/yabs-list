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
							<Submit
							:user="user"
							>
							</Submit>
						</div>
				</div>
		</AuthenticatedLayout>
</template>


<script>
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
	import { Head } from '@inertiajs/inertia-vue3';
	import ServerTable from '@/Components/ServerList/ServerTable.vue';
	import Submit from '@/Components/Submit.vue'
	
	export default {
			components: {
				Head,
				ServerTable,
				Submit
			},
			layout: AuthenticatedLayout,
			props: {
					user: Object,
			},
			data() {
				return {

				}
			},
			mounted() {
					console.log('helllooooo')
			},
	}
</script>
	