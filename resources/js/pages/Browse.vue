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
  FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

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
// const filter = reactive<filterType>({});

const title = 'Cards';
const breadcrumbs: BreadcrumbItemType[] = [
  {
    title: title,
    href: '/cards',
  },
];

const cardNumber = ref<number>(20);

const formSchema = toTypedSchema(
  z.object({
    id: z.number().int().positive().optional(),
    name: z.string().min(1, 'Name must not be empty').max(100).optional(),
    type: z.string().optional(),
    frameType: z.string().optional(),
    desc: z.string().optional(),
    pend_desc: z.string().optional(),
    atk: z.number().int().min(0).max(99999).optional(),
    def: z.number().int().min(0).max(99999).optional(),
    level: z.number().int().min(0).max(12).optional(),
    race: z.string().optional(),
    attribute: z.string().optional(),
    archetype: z.string().optional(),
    linkval: z.number().int().min(1).max(8).optional(),
    linkmarkers: z.array(z.string()).optional(),
    ygoprodeck_url: z
      .string()
      .url('Must be a valid URL')
      .optional()
      .or(z.literal('')),
  })
);

const form = useForm({
  validationSchema: formSchema,
  initialValues: {
    id: undefined,
    name: '',
    type: '',
    frameType: '',
    desc: '',
    pend_desc: '',
    atk: undefined,
    def: undefined,
    level: undefined,
    race: '',
    attribute: '',
    archetype: '',
    linkval: undefined,
    linkmarkers: [],
    ygoprodeck_url: '',
  },
});

const onSubmit = form.handleSubmit((values) => {
  console.log('Form submitted!', values);
});
</script>

<template>
  <Head :title="title" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <PageTitle :title="title" class="mb-5" />
    <form @submit="onSubmit" class="max-w-4xl space-y-6">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- ID -->
        <FormField v-slot="{ componentField }" name="id">
          <FormItem>
            <FormLabel>Card ID</FormLabel>
            <FormControl>
              <Input
                type="number"
                placeholder="12345"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Name -->
        <FormField v-slot="{ componentField }" name="name">
          <FormItem>
            <FormLabel>Card Name</FormLabel>
            <FormControl>
              <Input
                type="text"
                placeholder="Blue-Eyes White Dragon"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Type -->
        <FormField v-slot="{ componentField }" name="type">
          <FormItem>
            <FormLabel>Type</FormLabel>
            <FormControl>
              <Input
                type="text"
                placeholder="Effect Monster"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Frame Type -->
        <FormField v-slot="{ componentField }" name="frameType">
          <FormItem>
            <FormLabel>Frame Type</FormLabel>
            <FormControl>
              <Input type="text" placeholder="normal" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Race -->
        <FormField v-slot="{ componentField }" name="race">
          <FormItem>
            <FormLabel>Race</FormLabel>
            <FormControl>
              <Input type="text" placeholder="Dragon" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Attribute -->
        <FormField v-slot="{ componentField }" name="attribute">
          <FormItem>
            <FormLabel>Attribute</FormLabel>
            <FormControl>
              <Input type="text" placeholder="LIGHT" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- ATK -->
        <FormField v-slot="{ componentField }" name="atk">
          <FormItem>
            <FormLabel>ATK</FormLabel>
            <FormControl>
              <Input type="number" placeholder="3000" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- DEF -->
        <FormField v-slot="{ componentField }" name="def">
          <FormItem>
            <FormLabel>DEF</FormLabel>
            <FormControl>
              <Input type="number" placeholder="2500" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Level -->
        <FormField v-slot="{ componentField }" name="level">
          <FormItem>
            <FormLabel>Level</FormLabel>
            <FormControl>
              <Input
                type="number"
                placeholder="8"
                min="0"
                max="12"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Link Value -->
        <FormField v-slot="{ componentField }" name="linkval">
          <FormItem>
            <FormLabel>Link Value</FormLabel>
            <FormControl>
              <Input
                type="number"
                placeholder="4"
                min="1"
                max="8"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- Archetype -->
        <FormField v-slot="{ componentField }" name="archetype">
          <FormItem>
            <FormLabel>Archetype</FormLabel>
            <FormControl>
              <Input
                type="text"
                placeholder="Blue-Eyes"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <!-- YGOPRODeck URL -->
        <FormField v-slot="{ componentField }" name="ygoprodeck_url">
          <FormItem>
            <FormLabel>YGOPRODeck URL</FormLabel>
            <FormControl>
              <Input
                type="url"
                placeholder="https://ygoprodeck.com/card/..."
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>

      <!-- Description (Full Width) -->
      <FormField v-slot="{ componentField }" name="desc">
        <FormItem>
          <FormLabel>Description</FormLabel>
          <FormControl>
            <Input
              type="text"
              placeholder="Card description"
              v-bind="componentField"
            />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <!-- Pendulum Description (Full Width) -->
      <FormField v-slot="{ componentField }" name="pend_desc">
        <FormItem>
          <FormLabel>Pendulum Description</FormLabel>
          <FormControl>
            <Input
              type="text"
              placeholder="Pendulum effect"
              v-bind="componentField"
            />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>

      <Button type="submit" class="w-full md:w-auto"> Search Cards </Button>
    </form>
  </AppLayout>
</template>
