<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import { ScrollArea } from '@/components/ui/scroll-area';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from '@/components/ui/carousel';
import AppLayout from '@/layouts/AppLayout.vue';
import { ApiCard, BreadcrumbItemType } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
  card: ApiCard;
  other?: {
    id: number;
    image_url: string;
    image_url_small: string;
    image_url_cropped: string;
  }[];
}
const props = defineProps<Props>();

const title = 'Card: ' + props.card.name;
const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: 'Cards',
    href: '/cards',
  },
  {
    title: props.card.name,
    href: '/cards/' + props.card.id,
  },
];
</script>

<template>
  <Head :title="title"></Head>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="w-full p-5">
      <div class="w-full overflow-hidden px-12">
        <Carousel class="mx-auto mb-5 w-fit max-w-full">
          <CarouselContent class="w-fit">
            <CarouselItem
              v-for="img in other"
              :key="img.id"
              class="basis-auto py-2 pl-3"
            >
              <Link
                :href="route('card.show', img.id)"
                class="block cursor-pointer transition-transform hover:scale-105"
              >
                <img
                  v-if="img.image_url"
                  :src="'/yap/img/card/' + img.id"
                  class="aspect-[2.25/3.25]! h-60 w-auto"
                />
              </Link>
            </CarouselItem>
          </CarouselContent>
          <CarouselNext />
          <CarouselPrevious />
        </Carousel>
      </div>
      <div
        class="flex w-full max-w-full flex-1 flex-col items-start space-y-5 lg:flex-row lg:space-y-0 lg:space-x-5"
      >
        <div
          class="flex w-full shrink-0 justify-center sm:w-auto sm:min-w-[300px] lg:w-1/4 lg:min-w-0"
        >
          <img
            :src="'/yap/img/card/' + card.id"
            alt="Image not found"
            class="aspect-[2.25/3.25] h-auto w-full max-w-[400px] sm:max-w-none"
          />
        </div>
        <div class="flex w-full min-w-0 grow overflow-x-hidden lg:w-3/4">
          <div class="flex w-full min-w-0 flex-col space-y-3 overflow-x-hidden">
            <div class="text-3xl font-bold">
              {{ card.name }}
            </div>
            <Separator orientation="horizontal" class="h-0.5!" />

            <div
              v-if="card.pend_desc"
              class="rounded-2xl border bg-[#1E9C4B] p-2 text-lg"
            >
              {{ card.pend_desc }}
            </div>
            <div class="rounded-2xl border p-2 text-lg">
              {{ card.desc }}
            </div>

            <Separator orientation="horizontal" class="h-0.5!" />
            <div class="flex w-full flex-1 flex-row">
              <div>
                <template v-if="card.level">
                  <template v-if="card.frameType === 'xyz'">Rank</template>
                  <template v-else>Level</template>
                  : {{ card.level }}
                </template>
                <template v-else-if="card.linkval && card.linkval > 0"
                  >Linkval: {{ card.linkval }}</template
                >
              </div>

              <template v-if="card.archetype">
                <Separator orientation="vertical" class="mx-2 !h-6 !w-[2x]" />
                <div>Archetype: {{ card.archetype }}</div>
              </template>
              <div v-else style="min-height: 1rem"></div>

              <template v-if="card.attribute">
                <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                <div class="">{{ card.attribute }}</div>
              </template>
              <template v-if="card.type">
                <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                <div>{{ card.type }}</div>
              </template>

              <template v-if="card.atk">
                <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                <div>Atk: {{ card.atk }}</div>
              </template>

              <template v-if="card.def">
                <Separator orientation="vertical" class="mx-2 !h-6 !w-[2px]" />
                <div>Def: {{ card.def }}</div>
              </template>
            </div>

            <Separator orientation="horizontal" class="h-[2px]!" />
            <div class="w-full overflow-x-auto">
              <ScrollArea class="h-[400px] w-full rounded-md border">
                <div class="min-w-[600px]">
                  <Table class="w-full">
                    <TableHeader>
                      <TableRow>
                        <TableHead>Code</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Price</TableHead>
                        <TableHead>Rarity</TableHead>
                        <TableHead>Rarity code</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      <template
                        v-for="set in card.card_sets"
                        :key="set.set_code"
                      >
                        <TableRow>
                          <TableCell>{{ set.set_code }}</TableCell>
                          <TableCell>{{ set.set_name }}</TableCell>
                          <TableCell>{{ set.set_price }}</TableCell>
                          <TableCell>{{ set.set_rarity }}</TableCell>
                          <TableCell>{{ set.set_rarity_code }}</TableCell>
                        </TableRow>
                      </template>
                    </TableBody>
                    <TableCaption>
                      Sets in which contain the card
                    </TableCaption>
                  </Table>
                </div>
              </ScrollArea>
            </div>
            <Separator orientation="horizontal" class="h-[2px]!" />
            <div class="w-full">
              <!--chart here-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
