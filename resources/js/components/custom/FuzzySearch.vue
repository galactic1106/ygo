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
import { ApiCard, YgoApiResponse } from '@/types';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { Search, Loader2, AlertCircle } from 'lucide-vue-next';
import { ref, Ref, onUnmounted, computed } from 'vue';
import CardListElement from './CardListElement.vue';

// Use environment variable or relative path
const endpoint: string = import.meta.env.VITE_API_ENDPOINT || '/yap';
const fname: Ref<string> = ref('');
const delay: number = 500; //ms
const minSearchLength: number = 2; // Don't search for single characters
const cards = ref<ApiCard[]>([]);
const isLoading = ref(false);
const error = ref<string | null>(null);
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

// Computed property for better empty state handling
const showEmptyState = computed(() => {
  return (
    !isLoading.value &&
    cards.value.length === 0 &&
    fname.value.length >= minSearchLength
  );
});

async function getCards(fname: string) {
  if (fname.length < minSearchLength) {
    return [];
  }

  try {
    const response = await axios.get(endpoint, {
      params: { fname: fname, offset: 0, num: 10 },
    });

    const ygoApiResponse: YgoApiResponse = response.data;

    if (ygoApiResponse.data) {
      return ygoApiResponse.data;
    }

    if (ygoApiResponse.error) {
      throw new Error(ygoApiResponse.error);
    }

    return [];
  } catch (err) {
    const errorMessage = axios.isAxiosError(err)
      ? err.response?.data?.message || err.message
      : 'An unexpected error occurred';
    throw new Error(errorMessage);
  }
}

async function updateCards(): Promise<void> {
  if (fname.value.length < minSearchLength) {
    cards.value = [];
    error.value = null;
    return;
  }

  isLoading.value = true;
  error.value = null;

  try {
    cards.value = await getCards(fname.value);
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Failed to fetch cards';
    cards.value = [];
    console.error('Error fetching cards:', err);
  } finally {
    isLoading.value = false;
  }
}

function handleDebounce(): void {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }

  searchTimeout = setTimeout(() => {
    updateCards();
  }, delay);
}

// Cleanup on unmount to prevent memory leaks
onUnmounted(() => {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }
});
</script>

<template>
  <Dialog>
    <DialogTrigger><Search class="size-4" /></DialogTrigger>
    <DialogContent class="flex h-[90vh] max-h-[900px] flex-col p-3">
      <DialogHeader class="shrink-0 space-y-4">
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
          >
            <Loader2 v-if="isLoading" class="size-4 animate-spin" />
            <Search v-else class="size-4" />
          </span>
        </div>
        <p
          v-if="fname.length > 0 && fname.length < minSearchLength"
          class="text-muted-foreground text-center text-sm"
        >
          Type at least {{ minSearchLength }} characters to search
        </p>
      </DialogHeader>

      <div class="min-h-0 flex-1 py-3">
        <ScrollArea class="h-full pe-1">
          <div class="space-y-2">
            <!-- Error state -->
            <div
              v-if="error"
              class="flex flex-col items-center justify-center gap-2 p-4 text-center"
            >
              <AlertCircle class="text-destructive size-8" />
              <p class="text-destructive font-medium">{{ error }}</p>
              <Button variant="outline" size="sm" @click="updateCards">
                Try Again
              </Button>
            </div>

            <!-- Results -->
            <div v-else-if="cards.length > 0">
              <div v-for="card in cards" :key="card.id" class="px-2">
                <CardListElement :card="card" class="h-32 w-full" />
                <Separator class="my-2" />
              </div>
            </div>

            <!-- Empty state -->
            <div
              v-else-if="showEmptyState"
              class="text-muted-foreground p-4 text-center"
            >
              <p class="font-medium">No cards found</p>
              <p class="text-sm">Try a different search term</p>
            </div>

            <!-- Initial state -->
            <div
              v-else-if="!fname"
              class="text-muted-foreground p-4 text-center"
            >
              <Search class="mx-auto mb-2 size-12 opacity-20" />
              <p>Start typing to search for cards</p>
            </div>
          </div>
        </ScrollArea>
      </div>

      <DialogFooter class="shrink-0">
        <Button as-child class="mx-auto">
          <Link :href="'/cards?fname=' + fname">Advanced Search</Link>
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
