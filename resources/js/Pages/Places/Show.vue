
<template>
    <Head :title="place.name" />

    <MainLayout>
        <template #breadcrumb>
            <li class="flex items-center">
                <Link
                    :href="route('places.index')"
                    class="text-gray-500 hover:text-gray-700"
                >
                    Places
                </Link>
                <ChevronRightIcon class="h-5 w-5 text-gray-400 mx-2" />
            </li>
            <li class="text-gray-700">{{ place.name }}</li>
        </template>

        <!-- Restaurant Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex justify-between items-start">
                <!-- Title and Basic Info -->
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <h1 class="text-3xl font-bold">{{ place.name }}</h1>
                        <div
                            v-if="place.verified"
                            class="bg-teal-50 text-teal-700 px-2 py-1 rounded text-sm font-medium"
                        >
                            Verified
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                        <span>{{ place.categories.map(c => c.name).join(' • ') }}</span>
                        <span>Average price: {{ place.average_price }}€</span>
                    </div>

                    <!-- Rating Overview -->
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <StarIcon class="w-5 h-5 text-yellow-400" fill="currentColor" />
                            <span class="font-semibold">{{ averageRating }}</span>
                            <span class="text-gray-500">({{ place.reviews_count }} reviews)</span>
                        </div>
                        <div v-if="place.is_open" class="text-green-600">Open Now</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4">
                    <button
                        @click="toggleFavorite"
                        class="p-2 rounded-full hover:bg-gray-100"
                        :class="{ 'text-red-500': isFavorite }"
                    >
                        <HeartIcon
                            class="w-6 h-6"
                            :fill="isFavorite ? 'currentColor' : 'none'"
                        />
                    </button>
                    <button
                        @click="sharePlace"
                        class="p-2 rounded-full hover:bg-gray-100"
                    >
                        <ShareIcon class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Photo Gallery -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div
                v-for="(image, index) in displayedImages"
                :key="index"
                :class="[
          'relative overflow-hidden rounded-lg cursor-pointer',
          index === 0 ? 'col-span-2 row-span-2' : ''
        ]"
                @click="openGallery(index)"
            >
                <img
                    :src="image.path"
                    :alt="place.name"
                    class="w-full h-full object-cover transition duration-300 hover:scale-105"
                />
                <div
                    v-if="index === 3 && place.images.length > 4"
                    class="absolute inset-0 bg-black/50 flex items-center justify-center text-white"
                >
                    <span class="text-lg font-medium">+{{ place.images.length - 4 }} photos</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-3 gap-6">
            <!-- Left Column: Details & Reviews -->
            <div class="col-span-2 space-y-6">
                <!-- About Section -->
                <section class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold mb-4">About</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ place.description }}</p>
                </section>

                <!-- Ratings Section -->
                <section class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl font-bold text-teal-700">{{ averageRating }}</div>
                            <div>
                                <div class="font-semibold mb-1">Exceptional</div>
                                <div class="text-sm text-gray-600">{{ place.reviews_count }} reviews</div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="(rating, label) in ratings"
                            :key="label"
                            class="flex items-center gap-4"
                        >
                            <span class="w-24 text-sm capitalize">{{ label }}</span>
                            <div class="flex-1 bg-gray-200 h-2 rounded-full">
                                <div
                                    class="bg-teal-700 h-2 rounded-full transition-all duration-500"
                                    :style="{ width: `${rating * 10}` }"
                                ></div>
                            </div>
                            <span class="text-sm">{{ rating }}</span>
                        </div>
                    </div>
                </section>

                <!-- Reviews Section -->
                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold">Reviews</h2>
                        <div class="flex gap-2">
                            <select
                                v-model="reviewsSort"
                                class="rounded-md border-gray-300 text-sm focus:border-teal-500 focus:ring-teal-500"
                            >
                                <option value="recent">Most Recent</option>
                                <option value="rating">Highest Rated</option>
                            </select>
                        </div>
                    </div>

                    <ReviewCard
                        v-for="review in sortedReviews"
                        :key="review.id"
                        :review="review"
                        :auth="auth"
                    />

                    <div
                        v-if="place.reviews_count > displayedReviews"
                        class="text-center"
                    >
                        <button
                            @click="loadMoreReviews"
                            class="text-teal-600 hover:text-teal-700"
                        >
                            Show more reviews
                        </button>
                    </div>
                </section>
            </div>

            <!-- Right Column: Location & Contact -->
            <div class="space-y-6">
                <!-- Location Map -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold mb-4">Location</h3>
                    <div class="aspect-square bg-gray-100 rounded-lg mb-4">
                        <!-- Map Component Here -->
                    </div>
                    <address class="text-gray-700 not-italic">
                        {{ place.address?.address }}<br>
                        {{ place.address?.zip }} {{ place.address?.city?.name }}<br>
                        {{ place.address?.country?.name }}
                    </address>
                </div>

                <!-- Opening Hours -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold mb-4">Opening Hours</h3>
                    <div class="space-y-2">
                        <!-- Add opening hours here -->
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold mb-4">Contact</h3>
                    <div class="space-y-3">
                        <a
                            v-if="place?.phone"
                            :href="place.phone"
                            class="flex items-center gap-3 text-gray-700 hover:text-teal-600"
                        >
                            <PhoneIcon class="w-5 h-5" />
                            {{ place.phone }}
                        </a>
                        <a
                            v-if="place.website"
                            :href="place.website"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-3 text-gray-700 hover:text-teal-600"
                        >
                            <GlobeIcon class="w-5 h-5" />
                            Website
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Review Button -->
        <div class="fixed bottom-8 right-8">
            <button
                @click="handleReviewClick"
                class="flex items-center gap-2 px-6 py-3 bg-teal-500 text-white rounded-full shadow-lg hover:bg-teal-600 transition"
            >
                <PenIcon class="w-5 h-5" />
                Write a Review
            </button>
        </div>

        <!-- Photo Gallery Modal -->
        <TransitionRoot appear :show="isGalleryOpen" as="template">
            <Dialog as="div" @close="closeGallery" class="relative z-50">
                <!-- Modal implementation -->
            </Dialog>
        </TransitionRoot>

        <!-- Review Modal -->
        <ReviewModal
            v-if="auth?.user"
            :is-open="isReviewModalOpen"
            :place-id="place.id"
            @close="closeReviewModal"
            @success="handleReviewSuccess"
        />

        <!-- Share Modal -->
        <TransitionRoot appear :show="isShareModalOpen" as="template">
            <Dialog as="div" @close="closeShareModal" class="relative z-50">
                <!-- Share modal implementation -->
            </Dialog>
        </TransitionRoot>
    </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel
} from '@headlessui/vue'
import {
    StarIcon,
    HeartIcon,
    ShareIcon,
    PenIcon,
    PhoneIcon,
    GlobeIcon,
    ChevronRightIcon
} from 'lucide-vue-next'
import MainLayout from '@/Layouts/MainLayout.vue'
import ReviewCard from '@/Components/ReviewCard.vue'
import ReviewModal from '@/Components/ReviewModal.vue'

const props = defineProps({
    auth: Object,
    place: {
        type: Object,
        required: true
    }
})

// State
const isFavorite = ref(false)
const isGalleryOpen = ref(false)
const isReviewModalOpen = ref(false)
const isShareModalOpen = ref(false)
const currentImageIndex = ref(0)
const reviewsSort = ref('recent')
const displayedReviews = ref(5)

// Computed
const averageRating = computed(() => {
    const ratings = {
        ambiance: 9.1,
        dishes: 9.4,
        service: 9.4
    }
    return ((ratings.ambiance + ratings.dishes + ratings.service) / 3).toFixed(1)
})

const ratings = computed(() => ({
    ambiance: 9.1,
    dishes: 9.4,
    service: 9.4
}))

const displayedImages = computed(() => {
    return props.place.images.slice(0, 4)
})

const sortedReviews = computed(() => {
    const reviews = [...props.place.reviews]
    if (reviewsSort.value === 'recent') {
        return reviews.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    }
    return reviews.sort((a, b) => b.rating - a.rating)
})

// Methods
const toggleFavorite = () => {
    if (!props.auth?.user) {
        router.visit(route('login'))
        return
    }
    isFavorite.value = !isFavorite.value
    // Implement favorite API call
}

const handleReviewClick = () => {
    if (!props.auth?.user) {
        router.visit(route('login'), {
            data: { redirect: route('places.show', props.place.id) }
        })
        return
    }
    isReviewModalOpen.value = true
}

const closeReviewModal = () => {
    isReviewModalOpen.value = false
}

const handleReviewSuccess = () => {
    router.reload({ only: ['place.reviews'] })
}

const sharePlace = () => {
    isShareModalOpen.value = true
}

const closeShareModal = () => {
    isShareModalOpen.value = false
}

const openGallery = (index) => {
    currentImageIndex.value = index
    isGalleryOpen.value = true
}

const closeGallery = () => {
    isGalleryOpen.value = false
}

const loadMoreReviews = () => {
    displayedReviews.value += 5
}
</script>
