<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, CardSet } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage
} from '@/components/ui/form';


interface filterType {
    id?: number;
    name?: string;
    type?: string;
    frameType?: string;
    desc?: string;
    pend_desc?: string;
    atk?: number;
    def?: number;
    level?: number;
    race?: string;
    attribute?: string;
    archetype?: string;
    linkval?: number;
    linkmarkers?: string[];
    ygoprodeck_url?: string;
    card_sets?: CardSet[];
}
const filter = reactive<filterType>({});
const title = 'Cards';
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: title,
        href: '/cards',
    },
];

const cardNumber = ref<number>(20);
</script>

<template>

    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <PageTitle :title="title" class="mb-5" />


        </div>
    </AppLayout>
</template>
