<script setup lang="ts">
import MyCard from '@/components/MyCard.vue';
import {
    Drawer,
    // DrawerClose,
    DrawerContent,
    // DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from '@/components/ui/drawer';
import { Input } from '@/components/ui/input';
import { ScrollArea } from '@/components/ui/scroll-area';
import { ApiCard } from '@/types';
import axios from 'axios';
import { Search } from 'lucide-vue-next';
import { ref, Ref } from 'vue';

const endpoint: string = 'http://localhost:8000/yap';
const fname: Ref<string, string> = ref('');
const delay: number = 500; //ms
const cards = ref<ApiCard[]>([]);
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

async function getCards(fname: string): Promise<ApiCard[]> {
    try {
        const response = await axios.get(endpoint, { params: { fname: fname, offset: 0, num: 10 } });
        const ygoApiResponse = response.data;
        if (ygoApiResponse.data) {
            console.log('returned data: ');
            console.log(ygoApiResponse);
            return ygoApiResponse.data;
        }
        if (ygoApiResponse.error) console.error('Response: ' + ygoApiResponse.error);
    } catch (error) {
        console.error('Error fetching cards: ' + error);
        return [];
    }
    return [];
}

async function updateCards(): Promise<void> {
    cards.value = await getCards(fname.value);
}

function handleDebounce(): void {
    if (searchTimeout) clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        updateCards();
        console.log('runned');
    }, delay);
}
</script>

<template>
    <Drawer>
        <DrawerTrigger><Search class="size-4" /></DrawerTrigger>
        <DrawerContent class="h-[70%]">
            <DrawerHeader class="h-1/4">
                <div class="mb-2 flex w-full justify-center">
                    <DrawerTitle class="text-xl">Fuzzy search cards!</DrawerTitle>
                </div>
                <div class="relative mx-auto flex w-1/3 justify-center">
                    <Input v-model="fname" @input="handleDebounce" type="text" placeholder="Dark Magician" class="pl-7"> </Input>
                    <span class="absolute inset-y-0 start-0 flex items-center justify-center px-2"><Search class="size-4"></Search></span>
                </div>
            </DrawerHeader>
            <div class="mb-5 flex h-3/4 flex-row justify-center">
                <div class="flex w-full flex-row space-x-4 p-4">
                    <ScrollArea class="w-[95%] rounded-md border whitespace-nowrap">
                        <template v-for="card in cards" :key="card.id">
                            <div class="w-1/5">
                                <MyCard :card="card" />
                            </div>
                        </template>
                        <ScrollBar orientation="horizontal" />
                    </ScrollArea>
                </div>
            </div>
        </DrawerContent>
    </Drawer>
</template>
