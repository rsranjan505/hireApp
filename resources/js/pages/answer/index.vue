<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="w-full mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Questions</h1>

            <table v-if="questions.length > 0" class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Description</th>
                <th class="p-2 border">Question</th>
                <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="q in questions" :key="q.id">
                    <td class="p-2 border">{{ q.title }}</td>
                    <td class="p-2 border">{{ q.description }}</td>
                    <td class="p-2 border">{{ q.question }}</td>
                    <td class="p-2 border">
                        <Link
                            :href="`/answers/create`"
                            class="bg-blue-600 text-white px-3 py-1 rounded mr-2"
                            >
                            Start Answer
                        </Link>

                    </td>
                </tr>
            </tbody>

            </table>
            <div v-else class="text-center">
                <p>No questions found.</p>
            </div>
        </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head,Link } from "@inertiajs/vue3";
import { BreadcrumbItem, Question } from "@/types";
import AppLayout from "@/layouts/AppLayout.vue";

// Interface
// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: "Take Interview",
    href: "/answers",
  },
];



defineProps({
  questions: Array,
})
</script>
