<template>
  <Head title="Create Question" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="w-full mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Question</h1>

        <form @submit.prevent="form.post('/questions')" class="space-y-4">
          <div>
            <label class="block font-medium">Title</label>
            <input v-model="form.title" type="text" class="w-full border p-2 rounded" />
            <span v-if="form.errors.title" class="text-red-600 text-sm">{{ form.errors.title }}</span>
          </div>

          <div>
            <label class="block font-medium">Description</label>
            <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
            <span v-if="form.errors.description" class="text-red-600 text-sm">{{ form.errors.description }}</span>
          </div>

          <div>
            <label class="block font-medium">Question</label>
            <textarea v-model="form.question" class="w-full border p-2 rounded"></textarea>
            <span v-if="form.errors.question" class="text-red-600 text-sm">{{ form.errors.question }}</span>
          </div>

          <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Save
          </button>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: "Questions",
    href: "/questions",
  },
  {
    title: "Create",
    href: "/questions/create",
  },
];

// Form
const form = useForm({
  title: "",
  description: "",
  question: "",
});
</script>
