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
    <div class="flex w-full justify-center py-8">
      <div class="w-full max-w-7xl space-y-4">
        <PageTitle :title="title" class="text-center" />

        <div class="bg-card rounded-lg border p-4 shadow-sm md:p-6">
          <h2 class="mb-4 text-2xl font-semibold">Latest Cards</h2>
          <Tabs defaultValue="monster" orientation="vertical">
            <TabsList
              class="bg-muted grid h-fit w-full grid-cols-1 gap-3 p-2 sm:grid-cols-2 lg:grid-cols-4"
            >
              <TabsTrigger
                value="monster"
                class="border-2 border-[#D19B6A] data-[state=active]:bg-[#D19B6A] data-[state=active]:text-white"
              >
                Monsters
              </TabsTrigger>
              <TabsTrigger
                value="spells"
                class="border-2 border-[#1E9C4B] data-[state=active]:bg-[#1E9C4B] data-[state=active]:text-white"
              >
                Spells
              </TabsTrigger>
              <TabsTrigger
                value="traps"
                class="border-2 border-[#B85A8A] data-[state=active]:bg-[#B85A8A] data-[state=active]:text-white"
              >
                Traps
              </TabsTrigger>
              <TabsTrigger
                value="extras"
                class="border-2 border-[#3A6DB1] data-[state=active]:bg-[#3A6DB1] data-[state=active]:text-white"
              >
                Extras
              </TabsTrigger>
            </TabsList>
            <TabsContent value="monster" class="mt-6">
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
              >
                <Alert variant="destructive" v-if="!latestMonsters.data">
                  <AlertTitle> Latest Monsters not found </AlertTitle>
                </Alert>
                <template
                  v-else
                  v-for="card in latestMonsters.data"
                  :key="card.id"
                >
                  <div class="">
                    <MyCard
                      :card="card"
                      class="flex !aspect-[2.25/3.25] flex-0 shrink-0"
                    />
                  </div>
                </template>
              </div>
            </TabsContent>

            <TabsContent value="spells" class="mt-6">
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
              >
                <Alert variant="destructive" v-if="!latestSpells.data">
                  <AlertTitle> Latest Spells not found </AlertTitle>
                </Alert>
                <template
                  v-else
                  v-for="card in latestSpells.data"
                  :key="card.id"
                >
                  <MyCard :card="card" />
                </template>
              </div>
            </TabsContent>

            <TabsContent value="traps" class="mt-6">
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
              >
                <Alert variant="destructive" v-if="!latestTraps.data">
                  <AlertTitle> Latest Traps not found </AlertTitle>
                </Alert>
                <template
                  v-else
                  v-for="card in latestTraps.data"
                  :key="card.id"
                >
                  <MyCard :card="card" />
                </template>
              </div>
            </TabsContent>

            <TabsContent value="extras" class="mt-6">
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
              >
                <Alert variant="destructive" v-if="!latestExtra.data">
                  <AlertTitle> Latest Extra not found </AlertTitle>
                </Alert>
                <template
                  v-else
                  v-for="card in latestExtra.data"
                  :key="card.id"
                >
                  <MyCard :card="card" />
                </template>
              </div>
            </TabsContent>
          </Tabs>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
