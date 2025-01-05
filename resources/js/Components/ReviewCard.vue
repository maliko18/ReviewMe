<!-- resources/js/Components/ReviewCard.vue -->
<template>
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <!-- Header: User Info and Rating -->
        <div class="flex justify-between mb-4">
            <!-- User Information -->
            <div class="flex items-center gap-4">
                <!-- User Avatar -->
                <div v-if="review.user?.profile_photo_url" class="relative w-12 h-12">
                    <img
                        :src="review.user?.profile_photo_url"
                        :alt="review.user?.name"
                        class="rounded-full w-full h-full object-cover"
                    />
                </div>
                <div v-else class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                    <UserIcon class="w-6 h-6 text-gray-400" />
                </div>

                <!-- User Name and Date -->
                <div>
                    <div class="font-semibold">{{ review?.user?.name }}</div>
                    <div class="text-sm text-gray-600">
                        {{ formatDate(review.created_at) }}
                    </div>
                    <div v-if="review.user.reviews_count" class="text-xs text-gray-500">
                        {{ review.user.reviews_count }} reviews
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="text-xl font-bold">
                {{ review.rating }}/10
            </div>
        </div>

        <!-- Review Content -->
        <div>
            <!-- Review Text -->
            <p class="text-gray-700 mb-4">{{ review.body }}</p>

            <!-- Review Images -->
            <div v-if="review.images?.length" class="mb-4">
                <div class="grid grid-cols-4 gap-2">
                    <div
                        v-for="(image, index) in review.images"
                        :key="image.id"
                        class="relative aspect-square rounded-lg overflow-hidden cursor-pointer"
                        @click="openImageGallery(index)"
                    >
                        <img
                            :src="image.path"
                            :alt="'Review image ' + (index + 1)"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-200"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-4 flex items-center justify-between">
            <div class="flex gap-4">
                <!-- Like Button -->
                <button
                    @click="handleLike"
                    class="flex items-center gap-2 text-sm hover:text-teal-600 transition-colors"
                    :class="review.is_liked ? 'text-teal-600' : 'text-gray-600'"
                >
                    <ThumbsUpIcon
                        class="w-4 h-4"
                        :fill="review.is_liked ? 'currentColor' : 'none'"
                    />
                    <span>{{ likeCount }}</span>
                </button>

                <!-- Report Button -->
                <button
                    v-if="canReport"
                    @click="handleReport"
                    class="flex items-center gap-2 text-sm text-gray-600 hover:text-red-600 transition-colors"
                >
                    <FlagIcon class="w-4 h-4" />
                    Report
                </button>
            </div>

            <!-- Review Date -->
            <div class="text-sm text-gray-500">
                {{ formatTimeAgo(review.created_at) }}
            </div>
        </div>

        <!-- Image Gallery Modal -->
        <TransitionRoot appear :show="isGalleryOpen" as="template">
            <Dialog as="div" @close="closeImageGallery" class="relative z-50">
                <TransitionChild
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/90" />
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
                            <DialogPanel class="relative w-full max-w-4xl">
                                <!-- Close Button -->
                                <button
                                    @click="closeImageGallery"
                                    class="absolute -top-10 right-0 text-white hover:text-gray-300"
                                >
                                    <XIcon class="w-6 h-6" />
                                </button>

                                <!-- Navigation Buttons -->
                                <div class="absolute inset-y-0 left-0 flex items-center">
                                    <button
                                        v-if="currentImageIndex > 0"
                                        @click="previousImage"
                                        class="p-2 bg-black/50 text-white rounded-full hover:bg-black/70"
                                    >
                                        <ChevronLeftIcon class="w-6 h-6" />
                                    </button>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <button
                                        v-if="currentImageIndex < review.images.length - 1"
                                        @click="nextImage"
                                        class="p-2 bg-black/50 text-white rounded-full hover:bg-black/70"
                                    >
                                        <ChevronRightIcon class="w-6 h-6" />
                                    </button>
                                </div>

                                <!-- Current Image -->
                                <img
                                    :src="currentImage?.path"
                                    :alt="'Review image ' + (currentImageIndex + 1)"
                                    class="w-full h-auto"
                                />
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel
} from '@headlessui/vue'
import {
    UserIcon,
    ThumbsUpIcon,
    FlagIcon,
    XIcon,
    ChevronLeftIcon,
    ChevronRightIcon
} from 'lucide-vue-next'

const props = defineProps({
    review: {
        type: Object,
        required: true
    },
    auth: Object
})

// Computed
const canReport = computed(() => {
    return props.auth?.user && props.auth.user.id !== props.review.user.id
})

const likeCount = computed(() => {
    return props.review.likes_count || 0
})

// Gallery State
const isGalleryOpen = ref(false)
const currentImageIndex = ref(0)
const currentImage = computed(() => {
    return props.review.images?.[currentImageIndex.value]
})

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const formatTimeAgo = (date) => {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    let interval = Math.floor(seconds / 31536000)

    if (interval > 1) return interval + ' years ago'
    interval = Math.floor(seconds / 2592000)
    if (interval > 1) return interval + ' months ago'
    interval = Math.floor(seconds / 86400)
    if (interval > 1) return interval + ' days ago'
    interval = Math.floor(seconds / 3600)
    if (interval > 1) return interval + ' hours ago'
    interval = Math.floor(seconds / 60)
    if (interval > 1) return interval + ' minutes ago'
    return 'just now'
}

const handleLike = () => {
    if (!props.auth?.user) {
        router.visit(route('login'))
        return
    }

    useForm({}).post(route('reviews.like', props.review.id), {
        preserveScroll: true
    })
}

const handleReport = () => {
    if (!props.auth?.user) {
        router.visit(route('login'))
        return
    }

    useForm({}).post(route('reviews.report', props.review.id), {
        preserveScroll: true
    })
}

// Gallery Methods
const openImageGallery = (index) => {
    currentImageIndex.value = index
    isGalleryOpen.value = true
}

const closeImageGallery = () => {
    isGalleryOpen.value = false
}

const previousImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--
    }
}

const nextImage = () => {
    if (currentImageIndex.value < props.review.images.length - 1) {
        currentImageIndex.value++
    }
}
</script>
