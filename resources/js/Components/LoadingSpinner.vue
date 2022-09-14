<template>
	<div class="loading-spinner">
		<div class="lds-hourglass"></div>
	</div>
</template>

<style scoped>
	.loading-spinner {
		position: fixed;
		bottom: 20px;
		right: 20px;
		z-index: 30;
	}

	.lds-hourglass {
		display: inline-block;
		position: relative;
		width: 60px;
		height: 60px;
	}
	.lds-hourglass:after {
		content: " ";
		display: block;
		border-radius: 50%;
		width: 0;
		height: 0;
		margin: 8px;
		box-sizing: border-box;
		border: 26px solid limegreen;
		border-color: limegreen transparent limegreen transparent;
		animation: lds-hourglass 1.2s infinite;
	}
	@keyframes lds-hourglass {
		0% {
			transform: rotate(0);
			animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
		}
		50% {
			transform: rotate(900deg);
			animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
		}
		100% {
			transform: rotate(1800deg);
		}
	}
</style>
