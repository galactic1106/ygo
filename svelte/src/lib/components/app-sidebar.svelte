<script lang="ts">
	import * as Sidebar from '#lib/components/ui/sidebar/index.js';
	import type { ComponentProps } from 'svelte';

	export type NavItem = {
		title: string;
		url: string;
		icon?: any;
	};
	let {
		items,
		ref = $bindable(null),
		...restProps
	}: ComponentProps<typeof Sidebar.Root> & { items: NavItem[] } = $props();
</script>

<Sidebar.Root bind:ref {...restProps}>
	<Sidebar.Header></Sidebar.Header>
	<Sidebar.Content class="gap-0">
		<Sidebar.Group>
			<Sidebar.GroupLabel>Application</Sidebar.GroupLabel>
			<Sidebar.GroupContent>
				<Sidebar.Menu>
					{#each items as item (item.title)}
						<Sidebar.MenuItem>
							<Sidebar.MenuButton>
								{#snippet child({ props })}
									<a href={item.url} {...props}>
										{#if item.icon}
											<item.icon />
										{/if}
										<span>{item.title}</span>
									</a>
								{/snippet}
							</Sidebar.MenuButton>
						</Sidebar.MenuItem>
					{/each}
				</Sidebar.Menu>
			</Sidebar.GroupContent>
		</Sidebar.Group>
	</Sidebar.Content>
	<Sidebar.Rail />
</Sidebar.Root>
