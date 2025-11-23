<script setup lang="ts">
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { useFieldValue, useSetFieldValue } from 'vee-validate';

interface Props {
  name: string;
  label: string;
  placeholder?: string;
  type?: 'text' | 'number';
  min?: number;
  max?: number;
  showClearButton?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  placeholder: '',
  showClearButton: false,
});

// Use vee-validate composables to interact with the parent form context
const fieldValue = useFieldValue(() => props.name);
const setFieldValue = useSetFieldValue(() => props.name);
</script>

<template>
  <FormField v-slot="{ componentField }" :name="name">
    <FormItem>
      <FormLabel>{{ label }}</FormLabel>
      <div v-if="showClearButton" class="flex gap-2">
        <FormControl class="flex-1">
          <Input
            :type="type"
            :placeholder="placeholder"
            :min="min"
            :max="max"
            v-bind="componentField"
          />
        </FormControl>
        <Button
          type="button"
          variant="outline"
          class="h-10 w-10 p-0"
          @click="setFieldValue(type === 'number' ? undefined : '')"
          :disabled="!fieldValue"
        >
          ×
        </Button>
      </div>
      <FormControl v-else>
        <Input
          :type="type"
          :placeholder="placeholder"
          :min="min"
          :max="max"
          v-bind="componentField"
        />
      </FormControl>
      <FormMessage />
    </FormItem>
  </FormField>
</template>
