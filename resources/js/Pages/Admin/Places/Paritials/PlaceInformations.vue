<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Modify Place Information</h2>
        <form @submit.prevent="updatePlace">
            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
                <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
            </div>

            <!-- Slug Field -->
            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input
                    type="text"
                    id="slug"
                    v-model="form.slug"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
                <p v-if="form.errors.slug" class="text-red-500 text-sm">{{ form.errors.slug }}</p>
            </div>

            <!-- Description Field -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                ></textarea>
                <p v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</p>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                :disabled="form.processing"
            >
                Save Changes
            </button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";

export default {
    props: {
        place: {
            type: Object,
            default: () => ({
                name: 'Name name',
                slug: 'name_name',
                description: 'description',
            }),
        },
    },
    setup(props) {
        // Initialize the form
        const form = useForm({
            name: props.place.name,
            slug: props.place.slug,
            description: props.place.description,
        });

        // Method to update the place
        const updatePlace = () => {
            form.put(`/admin/places/${props.place.id}`, {
                onSuccess: () => {
                    alert('Place information updated successfully!');
                },
                onError: () => {
                    alert('Failed to update place information. Please check the errors.');
                },
            });
        };

        return {
            form,
            updatePlace,
        };
    },
};
</script>

<style>
/* Add custom styles if needed */
</style>
