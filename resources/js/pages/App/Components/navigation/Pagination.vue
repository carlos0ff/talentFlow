<script setup>
import { computed } from "vue";

const props = defineProps({
  currentPage: {
    type: Number,
    default: 1,
  },
  totalPages: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(["page-change"]);

const visiblePages = computed(() => {
  const pages = [];
  const total = props.totalPages;
  const current = props.currentPage;

  if (total <= 7) {
    return Array.from({ length: total }, (_, i) => i + 1);
  }

  pages.push(1);

  if (current > 4) pages.push("...");

  const start = Math.max(2, current - 1);
  const end = Math.min(total - 1, current + 1);

  for (let i = start; i <= end; i++) pages.push(i);

  if (current < total - 3) pages.push("...");

  pages.push(total);

  return pages;
});

const goToPage = (page) => {
  if (page !== "..." && page !== props.currentPage) {
    emit("page-change", page);
  }
};
</script>

<template>
  <div class="mt-8 flex justify-center">
    <div class="flex items-center space-x-2">
      <!-- Prev -->
      <button
        @click="goToPage(currentPage - 1)"
        :disabled="currentPage === 1"
        class="px-3 py-1 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
      </button>

      <!-- Pages -->
      <template v-for="page in visiblePages" :key="page">
        <span v-if="page === '...'" class="px-2 text-sm text-gray-500">...</span>
        <button
          v-else
          @click="goToPage(page)"
          :class="[
            'px-3 py-1 text-sm rounded-md border',
            page === currentPage
              ? 'bg-blue-600 text-white border-blue-600'
              : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50',
          ]"
          
        >
          {{ page }}
        </button>
      </template>

      <!-- Next -->
      <button
        @click="goToPage(currentPage + 1)"
        :disabled="currentPage === totalPages"
        class="px-3 py-1 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
      </button>
    </div>
  </div>
</template>