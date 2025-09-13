<template>
  <Head title="Candidates" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="w-full mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Candidates</h1>

        <!-- <Link
          href="/candidates/create"
          class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded"
        >
          + Add Candidate
        </Link> -->

        <table v-if="candidates.length > 0" class="w-full border">
          <thead>
            <tr class="bg-gray-100">
              <th class="p-2 border">Name</th>
              <th class="p-2 border">Email</th>
              <th class="p-2 border">Created At</th>
              <!-- <th class="p-2 border">Actions</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="c in candidates" :key="c.id">
              <td class="p-2 border">{{ c.name }}</td>
              <td class="p-2 border">{{ c.email }}</td>
              <td class="p-2 border">{{ new Date(c.created_at).toLocaleDateString() }}</td>
              <td class="p-2 border">
                <!-- <Link
                  :href="`/candidates/${c.id}/edit`"
                  class="bg-blue-600 text-white px-3 py-1 rounded mr-2"
                >
                  Edit
                </Link>
                <Link
                  as="button"
                  method="delete"
                  :href="`/candidates/${c.id}`"
                  class="bg-red-600 text-white px-3 py-1 rounded"
                  onclick="return confirm('Are you sure you want to delete this candidate?')"
                >
                  Delete
                </Link> -->
              </td>
            </tr>
          </tbody>
        </table>

        <div v-else class="text-center">
          <p>No candidates found.</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { BreadcrumbItem } from "@/types";
import AppLayout from "@/layouts/AppLayout.vue";

defineProps<{
  candidates: Array<{
    id: number;
    name: string;
    email: string;
    created_at: string;
  }>;
}>();

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: "Candidates",
    href: "/candidates",
  },
];
</script>
