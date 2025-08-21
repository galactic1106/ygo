<script setup lang="ts">
import {
    Drawer,
    /*
DrawerClose,
DrawerContent,
DrawerDescription,
DrawerFooter,
DrawerHeader,
DrawerTitle,
*/
    DrawerTrigger,
} from '@/components/ui/drawer';
import { Search } from 'lucide-vue-next';
</script>

<template>
    <Drawer>
        <DrawerTrigger><Search /></DrawerTrigger>
    </Drawer>
</template>
