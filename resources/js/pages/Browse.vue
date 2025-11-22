<script setup lang="ts">
import PageTitle from '@/components/PageTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItemType, ApiCard } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form';
import CardListElement from '@/components/custom/CardListElement.vue';
import SelectWithClear from '@/components/custom/SelectWithClear.vue';
import FormInputField from '@/components/custom/FormInputField.vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

interface Meta {
  current_rows: number;
  total_rows: number;
  rows_remaining: number;
  total_pages: number;
  pages_remaining: number;
  next_page?: string;
  next_page_offset?: number;
  previous_page?: string;
  previous_page_offset?: number;
}

interface Props {
  races: string[];
  types: string[];
  frameTypes: string[];
  archetypes: string[];
  attributes: string[];
  linkMarkers: string[];
  formats: string[];
  sortables: string[];
  banLists: string[];
  regions: string[];
  cards: ApiCard[];
  filters: Record<string, any>;
  meta: Meta | null;
}

const props = defineProps<Props>();

const title = 'Cards';
const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: title,
    href: '/cards',
  },
];

const formSchema = toTypedSchema(
  z.object({
    id: z.number().int().positive().optional(),
    fname: z.string().max(100).optional(),
    type: z.string().optional(),
    frameType: z.string().optional(),
    atk: z.number().int().min(0).max(99999).optional(),
    def: z.number().int().min(0).max(99999).optional(),
    level: z.number().int().min(0).max(12).optional(),
    race: z.string().optional(),
    attribute: z.string().optional(),
    archetype: z.string().optional(),
    linkval: z.number().int().min(1).max(8).optional(),
    linkmarkers: z.array(z.string()).optional(),
    num: z.string().optional(),
    offset: z.number().int().min(0).optional(),
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    id: props.filters.id ? Number(props.filters.id) : undefined,
    fname: props.filters.fname || '',
    type: props.filters.type || '',
    frameType: props.filters.frameType || '',
    atk: props.filters.atk ? Number(props.filters.atk) : undefined,
    def: props.filters.def ? Number(props.filters.def) : undefined,
    level: props.filters.level ? Number(props.filters.level) : undefined,
    race: props.filters.race || '',
    attribute: props.filters.attribute || '',
    archetype: props.filters.archetype || '',
    linkval: props.filters.linkval ? Number(props.filters.linkval) : undefined,
    linkmarkers: props.filters.linkmarkers || [],
    num: String(props.filters.num || 20),
    offset: props.filters.offset ? Number(props.filters.offset) : 0,
  },
});

// Calculate total pages correctly since API might return incorrect value
const totalPages = computed(() => {
  if (!props.meta || !props.filters.num) return 1;
  return Math.ceil(props.meta.total_rows / (props.filters.num || 20));
});

const onSubmit = form.handleSubmit((values) => {
  // Filter out empty values except num and offset
  const filters = Object.fromEntries(
    Object.entries(values).filter(([key, v]) => {
      // Always include num and offset if they have values
      if (key === 'num' || key === 'offset') {
        return v !== undefined && v !== null && v !== '';
      }
      // For other fields, exclude empty values
      return v !== '' && v !== undefined && v !== null;
    })
  );

  // Ensure num is present and converted to number
  if (filters.num && typeof filters.num === 'string') {
    filters.num = parseInt(filters.num, 10);
  } else if (!filters.num) {
    filters.num = 20; // Default page size
  }

  // Always reset to first page on new search
  filters.offset = 0;

  // Navigate to the same route with filters as query params
  router.get('/cards', filters, {
    preserveState: false,
    preserveScroll: false,
  });
});

const goToPage = (offset: number) => {
  const filters = { ...props.filters, offset };
  router.get('/cards', filters, {
    preserveState: false,
    preserveScroll: true,
  });
};

const goToNextPage = () => {
  if (props.meta?.next_page_offset !== undefined) {
    goToPage(props.meta.next_page_offset);
  }
};

const goToPreviousPage = () => {
  if (props.meta?.previous_page_offset !== undefined) {
    goToPage(props.meta.previous_page_offset);
  }
};
</script>

<template>
  <Head :title="title" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex w-full justify-center py-8">
      <div class="w-full max-w-4xl space-y-4">
        <PageTitle :title="title" class="text-center" />

        <div class="bg-card rounded-lg border p-4 shadow-sm md:p-6">
          <form @submit="onSubmit" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- ID -->
              <FormInputField
                name="id"
                label="Card ID"
                type="number"
                placeholder="12345"
              />

              <!-- Name -->
              <FormInputField
                name="fname"
                label="Card Name (Fuzzy Search)"
                type="text"
                placeholder="Blue-Eyes"
              />

              <!-- Type -->
              <SelectWithClear
                name="type"
                label="Type"
                placeholder="Select a type"
                :options="props.types"
              />

              <!-- Frame Type -->
              <SelectWithClear
                name="frameType"
                label="Frame Type"
                placeholder="Select a frame type"
                :options="props.frameTypes"
              />

              <!-- Race -->
              <SelectWithClear
                name="race"
                label="Race"
                placeholder="Select a race"
                :options="props.races"
              />

              <!-- Attribute -->
              <SelectWithClear
                name="attribute"
                label="Attribute"
                placeholder="Select an attribute"
                :options="props.attributes"
                :format-option="(option) => option.toUpperCase()"
              />

              <!-- ATK -->
              <FormInputField
                name="atk"
                label="ATK"
                type="number"
                placeholder="3000"
              />

              <!-- DEF -->
              <FormInputField
                name="def"
                label="DEF"
                type="number"
                placeholder="2500"
              />

              <!-- Level -->
              <FormInputField
                name="level"
                label="Level"
                type="number"
                placeholder="8"
                :min="0"
                :max="12"
              />

              <!-- Link Value -->
              <FormInputField
                name="linkval"
                label="Link Value"
                type="number"
                placeholder="4"
                :min="1"
                :max="8"
              />

              <!-- Archetype -->
              <SelectWithClear
                name="archetype"
                label="Archetype"
                placeholder="Select an archetype"
                :options="props.archetypes"
              />

              <!-- Results Per Page -->
              <FormField v-slot="{ componentField }" name="num">
                <FormItem>
                  <FormLabel>Results Per Page</FormLabel>
                  <Select v-bind="componentField">
                    <FormControl>
                      <SelectTrigger>
                        <SelectValue placeholder="20" />
                      </SelectTrigger>
                    </FormControl>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem value="10">10</SelectItem>
                        <SelectItem value="20">20</SelectItem>
                        <SelectItem value="50">50</SelectItem>
                        <SelectItem value="100">100</SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <FormMessage />
                </FormItem>
              </FormField>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-2 pt-1">
              <Button type="submit" class="flex-1"> Search Cards </Button>
              <Button
                type="button"
                variant="outline"
                class="flex-1"
                @click="
                  () => {
                    form.resetForm();
                    router.get('/cards');
                  }
                "
              >
                Clear All Filters
              </Button>
            </div>
          </form>
        </div>

        <!-- Cards Grid -->
        <div v-if="props.cards.length > 0" class="space-y-4">
          <!-- Results Header with Pagination Info -->
          <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold">Results</h2>
            <div v-if="props.meta" class="text-muted-foreground text-sm">
              Showing {{ props.meta.current_rows }} of
              {{ props.meta.total_rows }} cards
              <span
                v-if="
                  props.meta.next_page_offset ||
                  props.meta.previous_page_offset !== undefined
                "
              >
                (Page
                {{
                  Math.floor(
                    (props.filters.offset || 0) / (props.filters.num || 20)
                  ) + 1
                }}
                of {{ totalPages }})
              </span>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4">
            <div
              v-for="card in props.cards"
              :key="card.id"
              class="bg-card rounded-lg border p-4 shadow-sm transition-shadow hover:shadow-md"
            >
              <CardListElement :card="card" class="h-48 w-full" />
            </div>
          </div>

          <!-- Pagination Controls -->
          <div
            v-if="
              props.meta &&
              (props.meta.next_page_offset ||
                props.meta.previous_page_offset !== undefined)
            "
            class="flex items-center justify-center gap-2 pt-4"
          >
            <Button
              variant="outline"
              :disabled="
                !props.meta.previous_page_offset &&
                props.meta.previous_page_offset !== 0
              "
              @click="goToPreviousPage"
            >
              Previous
            </Button>
            <div class="text-muted-foreground px-4 text-sm">
              Page
              {{
                Math.floor(
                  (props.filters.offset || 0) / (props.filters.num || 20)
                ) + 1
              }}
              of {{ totalPages }}
            </div>
            <Button
              variant="outline"
              :disabled="!props.meta.next_page_offset"
              @click="goToNextPage"
            >
              Next
            </Button>
          </div>
        </div>

        <!-- No Results Message -->
        <div
          v-else-if="Object.keys(props.filters).length > 0"
          class="bg-muted/50 rounded-lg border border-dashed p-8 text-center"
        >
          <p class="text-muted-foreground text-lg">
            No cards found matching your search criteria.
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
