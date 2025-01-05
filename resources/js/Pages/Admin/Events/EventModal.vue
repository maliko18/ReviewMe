# EventForm.vue
<script setup>
import {onMounted, ref, watch} from 'vue';
import {useForm} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {Switch} from '@headlessui/vue';

const props = defineProps({
    modelValue: Boolean,
    event: {
        type: Object,
        default: null
    },
    places: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['update:modelValue', 'close']);
const previewImages = ref([]);
const imageInput = ref(null);
const deletingImages = ref([]);

const form = useForm({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
    status: true,
    place_id: '',
    meta: {},
    images: [],
    deleted_images: []
});

onMounted(() => {
    resetForm();
});

watch(() => props.event, () => {
    resetForm();
});

const resetForm = () => {
    previewImages.value = [];
    deletingImages.value = [];
    form.reset();

    if (props.event) {
        form.name = props.event.name;
        form.description = props.event.description;
        form.start_date = props.event.start_date;
        form.end_date = props.event.end_date;
        form.status = props.event.status;
        form.place_id = props.event.place_id;
        form.meta = props.event.meta || {};

        if (props.event.images) {
            previewImages.value = props.event.images.map(img => ({
                id: img.id,
                url: img.path,
                existing: true
            }));
        }
    }
};

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    form.images = [...form.images, ...files];

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImages.value.push({
                url: e.target.result,
                file,
                existing: false
            });
        };
        reader.readAsDataURL(file);
    });

    // Clear input
    e.target.value = '';
};

const removeImage = (index) => {
    const image = previewImages.value[index];

    if (image.existing) {
        deletingImages.value.push(image.id);
        form.deleted_images.push(image.id);
    }

    previewImages.value.splice(index, 1);
    if (form.images[index]) {
        form.images.splice(index, 1);
    }
};

const submit = () => {
    if (props.event) {
        form.post(route('admin.events.update', props.event.id), {
            onSuccess: () => {
                emit('close');
                resetForm();
            },
            preserveScroll: true,
            forceFormData: true
        });
    } else {
        form.post(route('admin.events.store'), {
            onSuccess: () => {
                emit('close');
                resetForm();
            },
            preserveScroll: true,
            forceFormData: true
        });
    }
};
</script>

<template>
    <Modal :show="modelValue" @close="$emit('update:modelValue', false)" :maxWidth="'2xl'">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ event ? 'Edit Event' : 'Create New Event' }}
            </h2>

            <form @submit.prevent="submit" class="mt-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Event Name -->
                    <div class="sm:col-span-6">
                        <InputLabel for="name" value="Event Name"/>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <!-- Place Selection -->
                    <div class="sm:col-span-6">
                        <InputLabel for="place_id" value="Place"/>
                        <select
                            id="place_id"
                            v-model="form.place_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        >
                            <option value="">Select a place</option>
                            <option v-for="place in places" :key="place.id" :value="place.id">
                                {{ place.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.place_id" class="mt-2"/>
                    </div>

                    <!-- Event Description -->
                    <div class="sm:col-span-6">
                        <InputLabel for="description" value="Description"/>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        />
                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                    <!-- Date Range -->
                    <div class="sm:col-span-3">
                        <InputLabel for="start_date" value="Start Date"/>
                        <input
                            id="start_date"
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                            :min="new Date().toISOString().split('T')[0]"
                        />
                        <InputError :message="form.errors.start_date" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-3">
                        <InputLabel for="end_date" value="End Date"/>
                        <input
                            id="end_date"
                            v-model="form.end_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                            :min="form.start_date"
                        />
                        <InputError :message="form.errors.end_date" class="mt-2"/>
                    </div>

                    <!-- Status Toggle -->
                    <div class="sm:col-span-6">
                        <Switch
                            v-model="form.status"
                            class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            :class="[form.status ? 'bg-indigo-600' : 'bg-gray-200']"
                        >
                            <span class="sr-only">Event Status</span>
                            <span
                                aria-hidden="true"
                                class="pointer-events-none absolute h-4 w-4 rounded-full bg-white shadow ring-0 transition-transform"
                                :class="[form.status ? 'translate-x-5' : 'translate-x-0']"
                            />
                        </Switch>
                        <span class="ml-3 text-sm">
                            {{ form.status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Image Upload -->
                    <div class="sm:col-span-6">
                        <InputLabel value="Event Images"/>
                        <div
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600">
                                        <span>Upload images</span>
                                        <input
                                            ref="imageInput"
                                            type="file"
                                            multiple
                                            accept="image/*"
                                            class="sr-only"
                                            @change="handleImageUpload"
                                        >
                                    </label>
                                </div>
                            </div>
                        </div>
                        <InputError :message="form.errors.images" class="mt-2"/>

                        <!-- Image Previews -->
                        <div v-if="previewImages.length" class="mt-4 grid grid-cols-4 gap-4">
                            <div v-for="(image, index) in previewImages"
                                 :key="index"
                                 class="relative"
                                 :class="{ 'opacity-50': deletingImages.includes(image.id) }"
                            >
                                <img :src="image.url"
                                     class="h-24 w-24 object-cover rounded-lg">
                                <button
                                    @click.prevent="removeImage(index)"
                                    class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white p-1"
                                    :disabled="form.processing"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-4">
                    <SecondaryButton @click="$emit('close')" type="button" :disabled="form.processing">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :disabled="form.processing">
                        {{ event ? 'Update' : 'Create' }} Event
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
