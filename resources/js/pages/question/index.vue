<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="w-full mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Questions</h1>

            <Link
            href="/questions/create"
            class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded"
            >
            + Create Question
            </Link>

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
                        :href="`/questions/${q.id}/edit`"
                        class="bg-blue-600 text-white px-3 py-1 rounded mr-2"
                        >
                        Edit
                        </Link>
                        <Link
                        as="button"
                        method="delete"
                        :href="`/questions/${q.id}`"
                        class="bg-red-600 text-white px-3 py-1 rounded"
                        onclick="return confirm('Are you sure you want to delete this?')"
                        >
                        Delete
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
    title: "Create Interview",
    href: "questions",
  },
];



defineProps({
  questions: Array,
})
</script>
