<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Place Gallery</h2>

        <!-- Existing Images -->
        <div v-if="images.length" class="grid grid-cols-3 gap-4 mb-6">
            <div v-for="(image, index) in images" :key="image.id" class="relative">
                <img
                    :src="image.url"
                    alt="Place Image"
                    class="w-full h-40 object-cover rounded-lg"
                />
                <button
                    class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700"
                    @click="deleteImage(image.id)"
                >
                    ✕
                </button>
            </div>
        </div>

        <!-- Upload New Images -->
        <form @submit.prevent="uploadImages">
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700">Add Images</label>
                <input
                    type="file"
                    id="images"
                    multiple
                    @change="handleImageSelection"
                    class="mt-2 block w-full"
                />
            </div>

            <!-- Selected Images Preview -->
            <div v-if="selectedImagePreviews.length" class="grid grid-cols-3 gap-4 mt-4">
                <div
                    v-for="(preview, index) in selectedImagePreviews"
                    :key="index"
                    class="relative"
                >
                    <img
                        :src="preview"
                        alt="Selected Image Preview"
                        class="w-full h-40 object-cover rounded-lg"
                    />
                    <button
                        type="button"
                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-2 hover:bg-red-700"
                        @click="removeSelectedImage(index)"
                    >
                        ✕
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700"
            >
                Upload Images
            </button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";

export default {
    props: {
        placeId: {
            type: Number,
            required: true,
        },
        existingImages: {
            type: Array,
            default: () => {
                return Array.from({ length: 10 }).map((_, index) => ({
                    id: index + 1,
                    url: `https://via.placeholder.com/300x200?text=Image+${index + 1}`,
                }));
            },
        },
    },
    setup(props) {
        // Existing images
        const images = ref([...props.existingImages]);

        // Selected images for upload
        const selectedImages = ref([]);
        const selectedImagePreviews = ref([]);

        // Form for uploading images
        const form = useForm({
            images: [],
        });

        // Handle image selection
        const handleImageSelection = (event) => {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                selectedImages.value.push(files[i]);
                selectedImagePreviews.value.push(URL.createObjectURL(files[i]));
            }
        };

        // Remove selected image
        const removeSelectedImage = (index) => {
            selectedImages.value.splice(index, 1);
            selectedImagePreviews.value.splice(index, 1);
        };

        // Upload images
        const uploadImages = () => {
            form.images = selectedImages.value;
            form.post(`/admin/places/${props.placeId}/images`, {
                onSuccess: ({ props }) => {
                    images.value.push(...props.newImages);
                    selectedImages.value = [];
                    selectedImagePreviews.value = [];
                    alert('Images uploaded successfully!');
                },
            });
        };

        // Delete image
        const deleteImage = (id) => {
            if (confirm('Are you sure you want to delete this image?')) {
                form.delete(`/admin/places/${props.placeId}/images/${id}`, {
                    onSuccess: () => {
                        images.value = images.value.filter((image) => image.id !== id);
                        alert('Image deleted successfully!');
                    },
                });
            }
        };

        return {
            images,
            selectedImages,
            selectedImagePreviews,
            handleImageSelection,
            removeSelectedImage,
            uploadImages,
            deleteImage,
        };
    },
};
</script>

<style>
/* Add custom styles if needed */
</style>
