<script>
	import Skeleton from '../lib/components/ui/skeleton/skeleton.svelte';
</script>

<div class="relative flex aspect-2.5/3.5 h-75 w-fit rounded-sm justify-center items-center">
	<Skeleton class="absolute inset-0 inline-flex h-full w-full rounded-sm" />
	<Skeleton class="aspect-2.5/4 h-1/2 rounded-[50%] animate-ping" />
</div>
