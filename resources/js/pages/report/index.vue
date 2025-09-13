<template>
  <Head title="Answer Report" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="w-full mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Answer</h1>

        <table v-if="answers.length > 0" class="w-full border">
          <thead>
            <tr class="bg-gray-100">
              <th class="p-2 border">Candidate</th>
              <th class="p-2 border">Question</th>
              <th class="p-2 border">Answer</th>
              <th class="p-2 border">Score</th>
              <th class="p-2 border">Comment</th>
              <th class="p-2 border">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ans in answers" :key="ans.id">
              <td class="p-2 border">{{ ans.user?.name }}</td>
              <td class="p-2 border">{{ ans.question?.question }}</td>
              <td class="p-2 border">{{ ans.file_path }}</td>
              <td class="p-2 border">{{ ans.report?.score || "-" }}</td>
              <td class="p-2 border">{{ ans.report?.comment || "-" }}</td>
              <td class="p-2 border">
                <button
                  @click="openModal(ans)"
                  class="bg-blue-600 text-white px-3 py-1 rounded mr-2"
                >
                  View Answer
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-else class="text-center">
          <p>No answers found.</p>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative">
        <!-- Close -->
        <button
          class="absolute top-2 right-2 text-gray-600"
          @click="showModal = false"
        >
          ✖
        </button>

        <h2 class="text-lg font-bold mb-4">Candidate Answer</h2>

        <!-- Video -->
        <video
          v-if="selectedAnswer?.file_path"
          :src="`/storage/${selectedAnswer.file_path}`"
          controls
          class="w-full h-64 rounded mb-4"
        ></video>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label class="block font-medium mb-1">Comment</label>
            <textarea
              v-model="form.comment"
              class="w-full border rounded p-2"
              rows="3"
              placeholder="Write your feedback..."
            ></textarea>
            <div v-if="form.errors.comment" class="text-red-600 text-sm">
              {{ form.errors.comment }}
            </div>
          </div>

          <div>
            <label class="block font-medium mb-1">Score</label>
            <input
              type="number"
              v-model="form.score"
              class="w-full border rounded p-2"
              min="1"
              max="10"
              placeholder="Enter score (1-10)"
            />
            <div v-if="form.errors.score" class="text-red-600 text-sm">
              {{ form.errors.score }}
            </div>
          </div>

          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-green-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-green-700"
              :disabled="form.processing"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";

// Props
defineProps({
  answers: Array,
});

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: "Take Interview", href: "/answers" },
];

// Modal states
const showModal = ref(false);
const selectedAnswer = ref<any>(null);

// Form
const form = useForm({
  comment: "",
  score: "",
  answer_id: null,
  user_id: null,
});

// Open modal with selected answer
const openModal = (ans: any) => {
  selectedAnswer.value = ans;
  form.answer_id = ans.id;
  form.user_id = ans.user.id;
  showModal.value = true;
};

// Submit form
const submitForm = () => {
  form.post("/report-answers", {
    onSuccess: () => {
      form.reset();
      showModal.value = false;
      console.log("Form submitted successfully");
    },
  });
};
</script>
