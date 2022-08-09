<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="cancel">
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <DialogOverlay class="fixed inset-0 bg-black opacity-30" />
          </TransitionChild>

          <span class="inline-block h-screen align-middle" aria-hidden="true">
            &#8203;
          </span>

          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <div
              class="my-8 inline-block w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-zinc-800"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900 dark:text-zinc-50"
              >
                {{ title }}
              </DialogTitle>
              <div class="mt-2 dark:text-zinc-50">
                <slot name="content"></slot>
              </div>

              <div class="mt-4">
                <slot name="footer">
                  <button
                    type="button"
                    class="dark:bg-opacity-85 mr-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-sm font-medium transition-all duration-150 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                    :class="classes"
                    @click="confirm"
                  >
                    {{ confirmText }}
                  </button>
                  <button
                    type="button"
                    class="dark:bg-opacity-85 inline-flex justify-center rounded-md border border-transparent bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-900 transition-all duration-150 ease-out hover:bg-zinc-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-zinc-500 focus-visible:ring-offset-2 dark:bg-zinc-600 dark:text-zinc-50 dark:hover:bg-zinc-700 dark:focus-visible:ring-zinc-600"
                    @click="cancel"
                  >
                    Batal
                  </button>
                </slot>
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle,
} from "@headlessui/vue"

defineProps({
  isOpen: Boolean,
  title: String,
  confirmText: String,
  classes: String,
})

const emit = defineEmits(["confirm", "cancel"])

const cancel = () => emit("cancel")

const confirm = () => emit("confirm")
</script>
