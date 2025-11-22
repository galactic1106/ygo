<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import { ApiCard } from '@/types';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { Search } from 'lucide-vue-next';
import { ref, Ref } from 'vue';
import CardListElement from './CardListElement.vue';

const endpoint: string = 'http://localhost:8000/yap';
const fname: Ref<string, string> = ref('');
const delay: number = 500; //ms
const cards = ref<ApiCard[]>([]);
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

async function getCards(fname: string): Promise<ApiCard[]> {
  try {
    const response = await axios.get(endpoint, {
      params: { fname: fname, offset: 0, num: 10 },
    });
    console.log(response);
    const ygoApiResponse = response.data;
    if (ygoApiResponse.data) {
      console.log('returned data: ');
      console.log(ygoApiResponse);
      return ygoApiResponse.data;
    }
    if (ygoApiResponse.error)
      console.error('Response: ' + ygoApiResponse.error);
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
  <Dialog>
    <DialogTrigger><Search class="size-4" /></DialogTrigger>
    <DialogContent class="flex h-[90vh] max-h-[900px] flex-col p-3">
      <DialogHeader class="flex-shrink-0 space-y-4">
        <DialogTitle class="flex w-full justify-center text-xl"
          >Fuzzy search cards!</DialogTitle
        >
        <div class="relative mx-auto flex w-full justify-center">
          <Input
            v-model="fname"
            @input="handleDebounce"
            type="text"
            placeholder="Dark Magician"
            class="pl-7"
          >
          </Input>
          <span
            class="absolute inset-y-0 start-0 flex items-center justify-center px-2"
            ><Search class="size-4"></Search
          ></span>
        </div>
      </DialogHeader>

      <div class="min-h-0 flex-1 py-3">
        <ScrollArea class="h-full pe-1">
          <div class="space-y-2">
            <div v-for="card in cards" :key="card.id" class="px-2">
              <CardListElement :card="card" class="h-32 w-full" />
              <Separator class="mt-2" />
            </div>
            <div
              v-if="cards.length === 0 && fname"
              class="text-muted-foreground p-4 text-center"
            >
              No cards found
            </div>
          </div>
        </ScrollArea>
      </div>

      <DialogFooter class="flex-shrink-0">
        <Button as-child class="mx-auto">
          <Link href="/cards">Enhance!</Link>
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
