<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Add a Review</h2>
        <form @submit.prevent="submitReview">
            <!-- Rating Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <div class="flex items-center space-x-1 mt-2">
                    <span
                        v-for="star in 5"
                        :key="star"
                        class="cursor-pointer"
                        @click="form.rating = star"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            :class="[
                                'w-6 h-6',
                                form.rating >= star ? 'text-yellow-500' : 'text-gray-300',
                            ]"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 .587l3.668 7.568L24 9.748l-6 5.822 1.417 8.251L12 18.896l-7.417 4.925L6 15.57 0 9.748l8.332-1.593z"
                            />
                        </svg>
                    </span>
                </div>
                <p v-if="errors.rating" class="text-red-500 text-sm">{{ errors.rating }}</p>
            </div>

            <!-- Comment Input -->
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea
                    id="comment"
                    v-model="form.body"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    rows="4"
                ></textarea>
                <p v-if="errors.body" class="text-red-500 text-sm">{{ errors.body }}</p>
            </div>

            <!-- Multiple Image Upload -->
            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                <input
                    type="file"
                    id="images"
                    multiple
                    @change="handleImageUpload"
                    class="mt-1 block w-full"
                />
                <p v-if="errors.images" class="text-red-500 text-sm">{{ errors.images }}</p>

                <!-- Preview Section -->
                <div v-if="imagePreviews.length" class="mt-4 grid grid-cols-3 gap-4">
                    <div
                        v-for="(preview, index) in imagePreviews"
                        :key="index"
                        class="relative w-24 h-24"
                    >
                        <img
                            :src="preview"
                            alt="Image Preview"
                            class="w-full h-full object-cover rounded-lg"
                        />
                        <button
                            type="button"
                            class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center"
                            @click="removeImage(index)"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center space-x-4">
                <button
                    type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    :disabled="loading"
                >
                    {{ loading ? "Submitting..." : "Submit Review" }}
                </button>
                <p v-if="loading" class="text-gray-500 text-sm">Uploading images...</p>
            </div>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";
export default {
    props: {
        placeSlug: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        // Form data
        const form = useForm({
            rating: null,
            body: '',
            images: [], // For storing multiple image files
        });

        // Image previews and state
        const imagePreviews = ref([]);
        const errors = ref({});
        const loading = ref(false);

        // Handle image upload
        const handleImageUpload = (event) => {
            const files = event.target.files;
            if (files.length) {
                Array.from(files).forEach((file) => {
                    form.images.push(file);
                    imagePreviews.value.push(URL.createObjectURL(file));
                });
            }
        };

        // Remove image
        const removeImage = (index) => {
            form.images.splice(index, 1);
            imagePreviews.value.splice(index, 1);
        };

        // Submit form
        const submitReview = async () => {
            loading.value = true;
            form.post(route('places.reviews.store',props.placeSlug), {
                onError: (err) => {
                    errors.value = err;
                    loading.value = false;
                },
                onSuccess: () => {
                    form.reset('comment', 'rating', 'images');
                    imagePreviews.value = [];
                    loading.value = false;
                    alert('Review submitted successfully!');
                },
            });
        };

        return {
            form,
            imagePreviews,
            handleImageUpload,
            removeImage,
            submitReview,
            errors,
            loading,
        };
    },
};
</script>

<style>
/* Add custom styles if needed */
</style>
