<script setup lang="ts">
import MyCard from '@/components/custom/MyCard.vue';
import PageTitle from '@/components/PageTitle.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, YgoApiResponse } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
  latestMonsters: YgoApiResponse;
  latestSpells: YgoApiResponse;
  latestTraps: YgoApiResponse;
  latestExtra: YgoApiResponse;
  breadcrubs?: BreadcrumbItemType[];
}

const Props = withDefaults(defineProps<Props>(), {
  breadcrubs: () => [],
  latestMonsters: () => {
    return { data: [] };
  },
  latestSpells: () => {
    return { data: [] };
  },
  latestTraps: () => {
    return { data: [] };
  },
  latestExtra: () => {
    return { data: [] };
  },
});
const title = 'Home';
const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: title,
    href: '/',
  },
];
</script>

<template>
  <Head :title="title" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-5">
      <PageTitle :title="title" class="mb-5" />
      <Tabs defaultValue="monster" orientation="vertical">
        <div class="mb-8">
          <h2 class="text-foreground mb-4 text-3xl font-bold">Latest Cards</h2>
          <TabsList
            class="grid h-fit w-full grid-cols-1 gap-3 bg-transparent p-0 sm:grid-cols-2 lg:grid-cols-4"
          >
            <TabsTrigger
              value="monster"
              class="group relative h-20 overflow-hidden rounded-lg border-2 border-[#D19B6A] bg-gradient-to-br from-[#D19B6A] to-[#B8885A] text-xl font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl data-[state=active]:scale-105 data-[state=active]:border-[#E5AB7A] data-[state=active]:shadow-2xl"
            >
              <span class="relative z-10">Monsters</span>
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
              ></div>
            </TabsTrigger>
            <TabsTrigger
              value="spells"
              class="group relative h-20 overflow-hidden rounded-lg border-2 border-[#1E9C4B] bg-gradient-to-br from-[#1E9C4B] to-[#16803D] text-xl font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl data-[state=active]:scale-105 data-[state=active]:border-[#2EAC5B] data-[state=active]:shadow-2xl"
            >
              <span class="relative z-10">Spells</span>
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
              ></div>
            </TabsTrigger>
            <TabsTrigger
              value="traps"
              class="group relative h-20 overflow-hidden rounded-lg border-2 border-[#B85A8A] bg-gradient-to-br from-[#B85A8A] to-[#A04A7A] text-xl font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl data-[state=active]:scale-105 data-[state=active]:border-[#C86A9A] data-[state=active]:shadow-2xl"
            >
              <span class="relative z-10">Traps</span>
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
              ></div>
            </TabsTrigger>
            <TabsTrigger
              value="extras"
              class="group relative h-20 overflow-hidden rounded-lg border-2 border-[#3A6DB1] bg-gradient-to-br from-[#3A6DB1] to-[#2A5D9F] text-xl font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl data-[state=active]:scale-105 data-[state=active]:border-[#4A7DC1] data-[state=active]:shadow-2xl"
            >
              <span class="relative z-10">Extras</span>
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
              ></div>
            </TabsTrigger>
          </TabsList>
        </div>
        <TabsContent value="monster" class="mt-0">
          <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
          >
            <Alert variant="destructive" v-if="!latestMonsters.data">
              <AlertTitle> Latest Monsters not found </AlertTitle>
            </Alert>
            <template v-else v-for="card in latestMonsters.data" :key="card.id">
              <div class="">
                <MyCard
                  :card="card"
                  class="flex !aspect-[2.25/3.25] flex-0 shrink-0"
                />
              </div>
              <!-- <div>
                                <img :src="'/yap/img/card/' + card.id" alt="Image unavailable" class="aspect-[2.25/3.25]" />
                            </div> -->
            </template>
          </div>
        </TabsContent>

        <TabsContent value="spells" class="mt-0">
          <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
          >
            <Alert variant="destructive" v-if="!latestSpells.data">
              <AlertTitle> Latest Spells not found </AlertTitle>
            </Alert>
            <template v-else v-for="card in latestSpells.data" :key="card.id">
              <MyCard :card="card" />
            </template>
          </div>
        </TabsContent>

        <TabsContent value="traps" class="mt-0">
          <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
          >
            <Alert variant="destructive" v-if="!latestTraps.data">
              <AlertTitle> Latest Traps not found </AlertTitle>
            </Alert>
            <template v-else v-for="card in latestTraps.data" :key="card.id">
              <MyCard :card="card" />
            </template>
          </div>
        </TabsContent>

        <TabsContent value="extras" class="mt-0">
          <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
          >
            <Alert variant="destructive" v-if="!latestExtra.data">
              <AlertTitle> Latest Extra not found </AlertTitle>
            </Alert>
            <template v-else v-for="card in latestExtra.data" :key="card.id">
              <MyCard :card="card" />
            </template>
          </div>
        </TabsContent>
      </Tabs>
    </div>
  </AppLayout>
</template>
