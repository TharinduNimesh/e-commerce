<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import Underline from "@tiptap/extension-underline";
import TextAlign from "@tiptap/extension-text-align";
import StarterKit from "@tiptap/starter-kit";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
});
const editor = useEditor({
  editorProps: {
    attributes: {
      class:
        "h-[200px] border border-slate-300 dark:border-gray-700 bg-gray-50 dark:bg-[#2b2a33] p-5 border-t-none rounded-bl-lg rounded-br-lg outline-none overflow-y-auto",
    },
  },
  content: props.modelValue,
  extensions: [
    StarterKit,
    Underline,
    TextAlign.configure({
      types: ["heading", "paragraph"],
    }),
  ],
});

watch(
  () => editor.value?.getHTML(),
  (value) => {
    emit("update:modelValue", value);
  }
);

</script>

<template>
  <div class="w-full flex flex-col">
    <div
      v-if="editor"
      class="px-5 py-3 flex gap-3 border border-b-0 border-slate-300 dark:border-gray-700 bg-gray-50 dark:bg-[#2b2a33] rounded-t-lg"
    >
      <UButton
        @click="editor.chain().focus().toggleBold().run()"
        color="black"
        :disabled="!editor.can().chain().focus().toggleBold().run()"
        :variant="editor.isActive('bold') ? 'solid' : 'ghost'"
        icon="material-symbols:format-bold"
      />
      <UButton
        @click="editor.chain().focus().toggleItalic().run()"
        color="black"
        :disabled="!editor.can().chain().focus().toggleItalic().run()"
        :variant="editor.isActive('italic') ? 'solid' : 'ghost'"
        icon="material-symbols:format-italic"
      />
      <UButton
        color="black"
        @click="editor.chain().focus().setHorizontalRule().run()"
        icon="material-symbols:chrome-minimize"
      />
      <UButton
        @click="editor.chain().focus().toggleUnderline().run()"
        color="black"
        :variant="editor.isActive('underline') ? 'solid' : 'ghost'"
        icon="ic:twotone-format-underlined"
      />
      <UButton
        @click="editor.chain().focus().toggleBlockquote().run()"
        color="black"
        :variant="editor.isActive('blockquote') ? 'solid' : 'ghost'"
        icon="material-symbols:format-quote"
      />

      <!-- Text Alignment Start -->
      <div>
        <UButton
          v-if="editor.isActive({ textAlign: 'justify' })"
          @click="editor.chain().focus().setTextAlign('left').run()"
          color="black"
          icon="material-symbols:format-align-justify"
        />
        <UButton
          v-else-if="editor.isActive({ textAlign: 'left' })"
          @click="editor.chain().focus().setTextAlign('center').run()"
          color="black"
          icon="material-symbols:format-align-left"
        />
        <UButton
          v-else-if="editor.isActive({ textAlign: 'center' })"
          @click="editor.chain().focus().setTextAlign('right').run()"
          color="black"
          icon="material-symbols:format-align-center"
        />
        <UButton
          v-else
          @click="editor.chain().focus().setTextAlign('justify').run()"
          color="black"
          icon="material-symbols:format-align-right"
        />
      </div>
      <!-- Text Alignment End -->

      <UButton
        class="disabled:text-gray-200 dark:disabled:text-gray-600"
        @click="editor.chain().focus().undo().run()"
        :disabled="!editor.can().chain().focus().undo().run()"
        icon="ic:round-undo"
        color="black"
        variant="ghost"
      />
      <UButton
        class="disabled:text-gray-200 dark:disabled:text-gray-600"
        @click="editor.chain().focus().redo().run()"
        :disabled="!editor.can().chain().focus().redo().run()"
        icon="ic:round-redo"
        color="black"
        variant="ghost"
      />
      
    </div>
    <EditorContent :editor="editor" />
  </div>
</template>
