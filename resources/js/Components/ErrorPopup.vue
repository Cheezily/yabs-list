<template>
	<div v-if="error_message" class="error-popup">
		<p>{{ error_message }}</p>
	</div>
</template>

<script>
export default {
	props: [
		'error_message'
	]
}
</script>

<style scoped>
	.error-popup {
		position: fixed;
		bottom: 20px;
		right: 20px;
		z-index: 100;
		background: white;
		color: red;
		font-weight: bold;
		padding: 12px 16px;
		border: 2px solid red;
		box-shadow: 0 4px 4px 2px #555;
	}
</style>
