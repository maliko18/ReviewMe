<!-- resources/js/Components/ReviewModal.vue -->
<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-50">
            <TransitionChild
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-2xl bg-white rounded-xl shadow-lg">
                            <div class="px-6 py-4 border-b">
                                <DialogTitle class="text-lg font-semibold">
                                    Write a Review
                                </DialogTitle>
                            </div>

                            <form @submit.prevent="handleSubmit" class="p-6">
                                <!-- Star Rating -->
                                <div class="mb-6">
                                    <label class="block mb-2 font-medium">Your Rating</label>
                                    <div class="flex gap-2">
                                        <button
                                            v-for="star in 5"
                                            :key="star"
                                            type="button"
                                            @click="form.rating = star"
                                            class="text-2xl focus:outline-none"
                                            :class="star <= form.rating ? 'text-yellow-400' : 'text-gray-300'"
                                        >
                                            ★
                                        </button>
                                    </div>
                                    <div v-if="form.errors.rating" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.rating }}
                                    </div>
                                </div>

                                <!-- Review Text -->
                                <div class="mb-6">
                                    <label for="review" class="block mb-2 font-medium">
                                        Your Review
                                    </label>
                                    <textarea
                                        id="review"
                                        v-model="form.body"
                                        rows="4"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                        placeholder="Share your experience..."
                                    ></textarea>
                                    <div v-if="form.errors.body" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.body }}
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-6">
                                    <label class="block mb-2 font-medium">Add Photos</label>
                                    <div class="flex flex-wrap gap-4">
                                        <div
                                            v-for="(image, index) in imagePreviewUrls"
                                            :key="index"
                                            class="relative w-24 h-24"
                                        >
                                            <img
                                                :src="image"
                                                class="w-full h-full object-cover rounded-lg"
                                            />
                                            <button
                                                type="button"
                                                @click="removeImage(index)"
                                                class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600"
                                            >
                                                <XIcon class="w-4 h-4" />
                                            </button>
                                        </div>

                                        <label
                                            v-if="imagePreviewUrls.length < 5"
                                            class="w-24 h-24 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-teal-500"
                                        >
                                            <input
                                                type="file"
                                                multiple
                                                accept="image/*"
                                                class="hidden"
                                                @change="handleImageUpload"
                                            />
                                            <PlusIcon class="w-6 h-6 text-gray-400" />
                                        </label>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Upload up to 5 images (max 5MB each)
                                    </p>
                                    <div v-if="form.errors.images" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.images }}
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex justify-end gap-4">
                                    <button
                                        type="button"
                                        @click="closeModal"
                                        class="px-4 py-2 text-gray-700 hover:text-gray-900"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 disabled:opacity-50"
                                        :disabled="form.processing"
                                    >
                                        Post Review
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { XIcon, PlusIcon } from 'lucide-vue-next'

const props = defineProps({
    isOpen: Boolean,
    placeId: Number,
})

const emit = defineEmits(['close', 'success'])

const form = useForm({
    rating: 0,
    body: '',
    images: [],
})

const imagePreviewUrls = ref([])

const handleImageUpload = (event) => {
    const files = Array.from(event.target.files)
    const remainingSlots = 5 - imagePreviewUrls.value.length
    const validFiles = files.slice(0, remainingSlots)

    validFiles.forEach(file => {
        if (file.size <= 5 * 1024 * 1024) {
            form.images.push(file)
            const reader = new FileReader()
            reader.onload = (e) => {
                imagePreviewUrls.value.push(e.target.result)
            }
            reader.readAsDataURL(file)
        }
    })
}

const removeImage = (index) => {
    imagePreviewUrls.value.splice(index, 1)
    form.images.splice(index, 1)
}

const handleSubmit = () => {
    form.post(route('places.reviews.store', props.placeId), {
        preserveScroll: true,
        onSuccess: () => {
            emit('success')
            closeModal()
        },
    })
}

const closeModal = () => {
    form.reset()
    imagePreviewUrls.value = []
    emit('close')
}
</script>
