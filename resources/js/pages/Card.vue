<script setup lang="ts">
import PriceTooltip from '@/components/custom/PriceTooltip.vue';
import { BarChart } from '@/components/ui/chart-bar';
import { Separator } from '@/components/ui/separator';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { ApiCard, BreadcrumbItemType } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
    card: ApiCard;
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

const chartData = computed(() => {
    const data = [];
    let key: keyof (typeof props.card.card_prices)[0];
    for (key in props.card.card_prices[0]) {
        const value = props.card.card_prices[0][key];
        const obj = {
            site: key,
            cardmarket_price: 0,
            tcgplayer_price: 0,
            ebay_price: 0,
            amazon_price: 0,
            coolstuffinc_price: 0,
        };
        obj[key] = value;

        data.push(obj);
    }
    return data;
});
</script>

<template>
    <Head :title="title"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <!-- <PageTitle :title="title" class="mb-5" /> -->
            <div class="flex w-full flex-1 flex-row items-start space-x-5">
                <div class="flex grow-0 basis-1/4">
                    <img :src="'/yap/img/card/' + card.id" alt="Image not found" class="!aspect-[2.25/3.25]" />
                </div>
                <div class="flex grow-1 basis-3/4">
                    <div class="flex flex-col space-y-3">
                        <div class="text-3xl font-bold">
                            {{ card.name }}
                        </div>
                        <Separator orientation="horizontal" class="!h-[2px]" />

                        <div v-if="card.pend_desc" class="rounded-2xl border bg-[#1E9C4B] p-2 text-lg">
                            {{ card.pend_desc }}
                        </div>
                        <div class="rounded-2xl border p-2 text-lg">
                            {{ card.desc }}
                        </div>

                        <Separator orientation="horizontal" class="!h-[2px]" />
                        <div class="flex w-full flex-1 flex-row">
                            <div>
                                <template v-if="card.level">
                                    <template v-if="card.frameType === 'xyz'">Rank</template>
                                    <template v-else>Level</template>
                                    : {{ card.level }}
                                </template>
                                <template v-else-if="card.linkval && card.linkval > 0">Linkval: {{ card.linkval }}</template>
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

                        <Separator orientation="horizontal" class="!h-[2px]" />
                        <div class="flex w-full flex-1 flex-row">
                            <Table>
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
                                    <template v-for="set in card.card_sets" :key="set.set_code">
                                        <TableRow>
                                            <TableCell>{{ set.set_code }}</TableCell>
                                            <TableCell>{{ set.set_name }}</TableCell>
                                            <TableCell>{{ set.set_price }}</TableCell>
                                            <TableCell>{{ set.set_rarity }}</TableCell>
                                            <TableCell>{{ set.set_rarity_code }}</TableCell>
                                        </TableRow>
                                    </template>
                                </TableBody>
                                <TableCaption> Sets in which contain the card </TableCaption>
                            </Table>
                        </div>
                        <Separator orientation="horizontal" class="!h-[2px]" />
                        <div class="flex w-full flex-1 flex-row">
                            <BarChart
                                :data="chartData"
                                index="site"
                                :categories="['cardmarket_price', 'tcgplayer_price', 'ebay_price', 'amazon_price', 'coolstuffinc_price']"
                                :colors="['hsl(12 76% 61%)', 'hsl(173 58% 39%)', 'hsl(197 37% 24%)', 'hsl(43 74% 66%)', 'hsl(27 87% 67%)']"
                                :type="'stacked'"
                                :rounded-corners="6"
                                :custom-tooltip="PriceTooltip"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
