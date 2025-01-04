// resources/js/Pages/Categories/Index.vue
<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import { PlusIcon, PencilIcon, TrashIcon } from 'lucide-react';

const props = defineProps({
    categories: Object
});

const showingCreateModal = ref(false);
const showingEditModal = ref(false);
const editingCategory = ref(null);

const form = useForm({
    name: '',
    description: '',
    category_id: '',
    meta: {}
});

const openCreateModal = () => {
    form.reset();
    showingCreateModal.value = true;
};

const openEditModal = (category) => {
    editingCategory.value = category;
    form.name = category.name;
    form.description = category.description;
    form.category_id = category.category_id;
    form.meta = category.meta || {};
    showingEditModal.value = true;
};

const submit = () => {
    if (editingCategory.value) {
        form.put(route('admin.categories.update', editingCategory.value.id), {
            onSuccess: () => {
                showingEditModal.value = false;
                editingCategory.value = null;
            }
        });
    } else {
        form.post(route('admin.categories.store'), {
            onSuccess: () => showingCreateModal.value = false
        });
    }
};

const deleteCategory = (category) => {
    if (confirm('Are you sure you want to delete this category?')) {
        form.delete(route('admin.categories.destroy', category.id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Categories</h2>
            <button
                @click="openCreateModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
            >
                <PlusIcon class="w-5 h-5 inline-block mr-2" />
                Add Category
            </button>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="category in categories.data" :key="category.id" class="px-4 py-4 sm:px-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ category.name }}</h3>
                            <p class="text-sm text-gray-500">{{ category.description }}</p>
                            <div class="mt-2">
                <span class="text-sm text-gray-600">
                  {{ category.places_count }} places
                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                @click="openEditModal(category)"
                                class="text-blue-600 hover:text-blue-900"
                            >
                                <PencilIcon class="w-5 h-5" />
                            </button>
                            <button
                                @click="deleteCategory(category)"
                                class="text-red-600 hover:text-red-900"
                            >
                                <TrashIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Create/Edit Modal -->
        <Modal
            :show="showingCreateModal || showingEditModal"
            @close="showingCreateModal ? (showingCreateModal = false) : (showingEditModal = false)"
        >
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ editingCategory ? 'Edit Category' : 'Create Category' }}
                </h3>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Parent Category</label>
                        <select
                            v-model="form.category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">None</option>
                            <option
                                v-for="category in categories.data"
                                :key="category.id"
                                :value="category.id"
                                :disabled="editingCategory && category.id === editingCategory.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button
                            type="button"
                            @click="showingCreateModal ? (showingCreateModal = false) : (showingEditModal = false)"
                            class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="ml-3 bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            {{ editingCategory ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
