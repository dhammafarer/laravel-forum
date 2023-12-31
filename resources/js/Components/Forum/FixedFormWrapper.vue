<script setup>
import axios from "axios";
import { ref, watch } from "vue";
import MarkdownShortcutToolbar from "@/Components/Forum/MarkdownShortcutToolbar.vue";

const props = defineProps({
    form: Object
});

const markdownPreviewEnabled = ref(false);
const markdownPreviewHtml = ref("");
const markdownPreviewLoading = ref(false);

watch(markdownPreviewEnabled, toggled => {
    if (!toggled) {
        return;
    }

    markdownPreviewLoading.value = true;

    axios.post(route("markdown"), { body: props.form.body }).then(response => {
        markdownPreviewHtml.value = response.data.html;
        markdownPreviewLoading.value = false;
    });
});
</script>

<template>
    <form
        class="fixed bottom-0 w-full bg-white p-6 border-t-4 border-gray-400 space-y-3"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <slot name="header" />
            </div>
            <div class="mt-4 space-y-3">
                <slot
                    name="main"
                    :markdownPreviewEnabled="markdownPreviewEnabled"
                />
                <div
                    v-if="markdownPreviewEnabled"
                    class="h-48 bg-gray-100 rounded-md px-3 py-2 overflow-y-scroll border border-gray-300 shadow-sm"
                    :class="{ 'opacity-50': markdownPreviewLoading }"
                    v-html="markdownPreviewHtml"
                />
                <div class="flex items-center justify-between">
                    <MarkdownShortcutToolbar for="body" />
                    <button
                        class="text-sm text-indigo-500"
                        type="button"
                        @click="
                            markdownPreviewEnabled = !markdownPreviewEnabled
                        "
                    >
                        Turn {{ !markdownPreviewEnabled ? "on" : "off" }}
                        markdown preview
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <slot name="button" />
            </div>
        </div>
    </form>
</template>
