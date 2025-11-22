<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { useForm } from 'vee-validate';

interface Props {
  name: string;
  label: string;
  placeholder: string;
  options: string[];
  formatOption?: (option: string) => string;
}

const props = withDefaults(defineProps<Props>(), {
  formatOption: (option: string) => option,
});

const form = useForm();
</script>

<template>
  <FormField v-slot="{ componentField }" :name="name">
    <FormItem>
      <FormLabel>{{ label }}</FormLabel>
      <div class="flex gap-2">
        <Select v-bind="componentField" class="flex-1">
          <FormControl>
            <SelectTrigger>
              <SelectValue :placeholder="placeholder" />
            </SelectTrigger>
          </FormControl>
          <SelectContent>
            <SelectGroup>
              <SelectItem
                v-for="option in options"
                :key="option"
                :value="option"
              >
                {{ formatOption(option) }}
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
        <Button
          type="button"
          variant="outline"
          class="h-10 w-10 p-0"
          @click="form.setFieldValue(name, '')"
          :disabled="!componentField.modelValue"
        >
          ×
        </Button>
      </div>
      <FormMessage />
    </FormItem>
  </FormField>
</template>
