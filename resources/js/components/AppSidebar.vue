<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Home, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
  {
    title: 'Home',
    href: route('home'),
    icon: Home,
  },
  {
    title: 'Browse Cards',
    href: route('cards.index'),
    icon: LayoutGrid,
  },
];

const footerNavItems: NavItem[] = [];

const loginSignin: NavItem[] = [
  {
    title: 'Log in',
    href: route('login'),
  },
  {
    title: 'Sign in',
    href: route('register'),
  },
];

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('home')">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser v-if="user" />
      <NavMain v-else :items="loginSignin"> </NavMain>
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
