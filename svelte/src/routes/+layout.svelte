<script lang="ts" module>
	import HouseIcon from '@lucide/svelte/icons/house';
	import SettingsIcon from '@lucide/svelte/icons/settings';
	import AppSidebar from '#lib/components/app-sidebar.svelte';

	type Item = {
		title: string;
		url: string;
		icon?: any;
		crumb: string;
		item?: Item;
	};
	const items: Item[] = [
		{
			title: 'Home',
			url: '#',
			icon: HouseIcon,
			crumb: 'Home'
		},
		{
			title: 'Settings',
			url: '#',
			icon: SettingsIcon,
			crumb: 'Settings'
		}
	];
</script>

<script lang="ts">
	import './layout.css';
	import favicon from '#lib/assets/favicon.svg';
	import * as Breadcrumb from '#lib/components/ui/breadcrumb/index.js';
	import * as Sidebar from '#lib/components/ui/sidebar/index.js';
	import { Separator } from '#lib/components/ui/separator/index.js';
	import { ModeWatcher } from 'mode-watcher';
	import ModeToggle from '#lib/custom-components/mode-toggle.svelte';

	let { children } = $props();
</script>

<svelte:head><link rel="icon" href={favicon} /></svelte:head>
<ModeWatcher />

<Sidebar.Provider>
	<AppSidebar {items} />
	<Sidebar.Inset>
		<header class="sticky top-0 flex h-16 shrink-0 items-center gap-2 border-b bg-background px-4">
			<Sidebar.Trigger />
			<ModeToggle />

			<Separator orientation="vertical" class="mx-2 h-4" />
			<Breadcrumb.Root>
				<Breadcrumb.List>
					<Breadcrumb.Item class="hidden md:block">
						<Breadcrumb.Link href="##">Build Your Application</Breadcrumb.Link>
					</Breadcrumb.Item>
					<Breadcrumb.Separator class="hidden md:block" />
					<Breadcrumb.Item>
						<Breadcrumb.Page>Data Fetching</Breadcrumb.Page>
					</Breadcrumb.Item>
				</Breadcrumb.List>
			</Breadcrumb.Root>
		</header>

		<div class="flex flex-1 flex-col gap-4 p-4">
			{@render children()}
		</div>
	</Sidebar.Inset>
</Sidebar.Provider>
