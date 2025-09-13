<template>
  <Head title="Take Interview" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 container mx-auto w-screen-md">
      <div class="mb-4 grid grid-cols-2 gap-4">
        <!-- Questions and Text Answer -->
        <div class="col-span-1">
          <h2>Enter Your Answer</h2>
          <p class="mb-4 py-2 border-b">
            Answer the question in the video, then click "Record Your Answer".
          </p>

          <div class="mb-4" v-for="question in props.questions" :key="question.id">
            <input type="hidden" name="question_id" :value="question.id" />
            <h3 class="font-medium">{{ question.title }}</h3>
            <p class="mb-2 font-bold">{{ question.question }}</p>
            <p>{{ question.description }}</p>
          </div>

          <div>
            <label for="answer" class="block font-medium mb-2">Your Answer</label>
            <textarea
              v-model="form.answer"
              id="answer"
              class="w-full border p-2 rounded"
            ></textarea>
          </div>
        </div>

        <!-- Recording Section -->
        <div class="col-span-1">
          <h2>Record Your Answers</h2>

          <!-- Video preview -->
          <video ref="video" autoplay muted class="w-full h-64 bg-black mb-2"></video>

          <!-- Recording controls -->
          <div class="flex gap-2 mb-4">
            <button
              @click="startRecording"
              :disabled="recording"
              class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded"
            >
              Start Recording
            </button>
            <button
              @click="stopRecording"
              :disabled="!recording"
              class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded"
            >
              Stop Recording
            </button>
          </div>

          <!-- Recorded answers list -->
          <h3 class="mb-2">Recorded Answers</h3>
          <ul>
            <li
              v-for="(item, index) in recordings"
              :key="index"
              class="mb-4 border p-2 rounded"
            >
              <strong>Answer {{ index + 1 }}</strong>
              <video :src="item.url" controls class="w-full h-48 mt-1 mb-2"></video>

              <div class="flex items-center gap-2">
                <button
                  @click="uploadRecording(item)"
                  :disabled="item.uploading || item.uploaded || recording"
                  class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded"
                >
                  {{ item.uploaded ? "Uploaded" : item.uploading ? "Uploading..." : "Upload" }}
                </button>

                <button
                  @click="deleteRecording(index)"
                  :disabled="item.uploading || recording"
                  class="text-red-600 hover:text-red-700 py-2 px-4 rounded"
                >
                  Delete
                </button>

                <span v-if="item.uploading">{{ Math.round(item.progress) }}%</span>
              </div>

              <div v-if="item.uploading" class="bg-gray-300 h-2 w-full rounded mt-1">
                <div
                  class="bg-green-500 h-2 rounded"
                  :style="{ width: item.progress + '%' }"
                ></div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { BreadcrumbItem } from "@/types";
import AppLayout from "@/layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

// ✅ Props
const props = defineProps<{ questions: any[] }>();

// ✅ Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: "Take Interview", href: "/answers" },
];

// ✅ Refs
const video = ref<HTMLVideoElement | null>(null);
const mediaRecorder = ref<MediaRecorder | null>(null);
const chunks = ref<Blob[]>([]);
const recording = ref(false);
const recordings = ref<any[]>([]); // store multiple recordings

// ✅ Form
const form = useForm({
  question_id: "",
  answer: "",
});

// ✅ Recording functions
async function startRecording() {
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    alert("Your browser does not support media devices.");
    return;
  }

  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: true,
      audio: true,
    });
    if (video.value) video.value.srcObject = stream;

    mediaRecorder.value = new MediaRecorder(stream);
    chunks.value = [];

    mediaRecorder.value.ondataavailable = (e) => chunks.value.push(e.data);
    mediaRecorder.value.onstop = saveRecording;

    mediaRecorder.value.start();
    recording.value = true;
  } catch (err) {
    console.error("Error accessing media devices:", err);
    alert("Cannot access camera or microphone. Please check your device and permissions.");
  }
}

function stopRecording() {
  if (mediaRecorder.value && recording.value) {
    mediaRecorder.value.stop();
    recording.value = false;
  }
}

function saveRecording() {
  const blob = new Blob(chunks.value, { type: "video/webm" });
  const url = URL.createObjectURL(blob);
  const file = new File([blob], `answer_${Date.now()}.webm`, { type: "video/webm" });

  recordings.value.push({
    question_id: props.questions[0]?.id || "",
    answer: form.answer,
    file,
    url,
    progress: 0,
    uploading: false,
    uploaded: false,
  });
}

// ✅ Delete
function deleteRecording(index: number) {
  const item = recordings.value[index];
  URL.revokeObjectURL(item.url);
  recordings.value.splice(index, 1);
}

// ✅ Upload
async function uploadRecording(item: any) {
  if (item.uploaded || item.uploading) return;

  const formData = new FormData();
  formData.append("question_id", item.question_id);
  formData.append("answer", item.answer);
  formData.append("file", item.file);

  const token = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");

  try {
    item.uploading = true;

    const response = await fetch("/answers", {
      method: "POST",
      body: formData,
      headers: {
        "X-CSRF-TOKEN": token || "",
        Accept: "application/json",
      },
    });

    if (!response.ok) throw new Error("Upload failed");

    const data = await response.json();
    item.uploaded = true;
    item.progress = 100;
    item.uploading = false;
    console.log("Upload complete:", data);
  } catch (err) {
    item.uploading = false;
    console.error(err);
    alert("Upload failed. Please check your network or try again.");
  }
}
</script>
