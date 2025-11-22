<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import FuzzySearch from './custom/FuzzySearch.vue';
import { ref, onMounted, onUnmounted } from 'vue';

withDefaults(
  defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
  }>(),
  {
    breadcrumbs: () => [],
  }
);

const isVisible = ref(true);
let lastScrollY = 0;
const scrollThreshold = 10;

const handleScroll = () => {
  const currentScrollY = window.scrollY;

  if (currentScrollY < scrollThreshold) {
    // Always show at top of page
    isVisible.value = true;
  } else if (currentScrollY < lastScrollY) {
    // Scrolling up
    isVisible.value = true;
  } else if (currentScrollY > lastScrollY) {
    // Scrolling down
    isVisible.value = false;
  }

  lastScrollY = currentScrollY;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
  <header
    class="border-sidebar-border/70 bg-background sticky top-0 z-50 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-all duration-300 ease-in-out group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    :class="{ '-translate-y-full': !isVisible }"
  >
    <SidebarTrigger />
    <div class="flex flex-grow-1">
      <template v-if="breadcrumbs && breadcrumbs.length > 0">
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </template>
    </div>
    <div class="">
      <FuzzySearch />
    </div>
  </header>
</template>
