<template>
<div>
	<Head title="Guest Submission" />

	<main>
		<div class="flex justify-center bg-gray-200">
			<div class="max-w-7xl mx-auto mt-8 mb-16 py-6 px-4 sm:px-6 lg:px-8">
				<div class="rounded max-w-10xl mx-auto sm:px-6 lg:px-8">
					<Submit 
					:user=null
					:virt_types_string=virt_types
					></Submit>
				</div>
			</div>
			<FlashMessage></FlashMessage>
		</div>
	</main>

</div>
</template>


<script>
import { Head } from '@inertiajs/inertia-vue3';
import Submit from '@/Components/Submit.vue'
import FlashMessage from '@/Components/FlashMessage.vue';

export default {
		components: {
			Head,
			Submit,
			FlashMessage
		},
		props: [
				'user',
				'virt_types'
		],
		data() {
			return {

			}
		},
		mounted() {
				console.log('helllooooo')
		},
}
</script>
