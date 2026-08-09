<script lang="ts">
	import Skeleton from '../lib/components/ui/skeleton/skeleton.svelte';
	import { getCardImage } from '../lib/helpers/images';

	let loaded = $state(false);
</script>

<div class="relative flex aspect-2.5/3.5 h-75 w-fit rounded-xs">
	{#if !loaded}
		<Skeleton class="absolute inset-0 h-full w-full rounded-xs" />
		<div class="pointer-events-none absolute inset-0 flex items-center justify-center">
			<Skeleton class="aspect-2.5/4 h-1/2 animate-ping rounded-[50%]" />
		</div>
	{/if}
	<img
		src={getCardImage(70491682)}
		alt=""
		loading="lazy"
		decoding="async"
		onload={() => {
			loaded = true;
		}}
        class="rounded-xs"
	/>
</div>
