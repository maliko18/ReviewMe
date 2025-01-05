# AdBannerForm.vue
<script setup>
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Switch } from '@headlessui/vue';

const props = defineProps({
    modelValue: Boolean,
    banner: Object,
    places: Array
});

const emit = defineEmits(['update:modelValue', 'close']);
const previewImages = ref([]);

const form = useForm({
    title: '',
    description: '',
    status: true,
    start_date: '',
    end_date: '',
    place_id: '',
    images: []
});

onMounted(() => resetForm());

const resetForm = () => {
    previewImages.value = [];
    form.reset();

    if (props.banner) {
        form.title = props.banner.title;
        form.description = props.banner.description;
        form.start_date = props.banner.start_date;
        form.end_date = props.banner.end_date;
        form.status = props.banner.status;
        form.place_id = props.banner.place_id;

        if (props.banner.images) {
            previewImages.value = props.banner.images.map(img => ({
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
};

const removeImage = (index) => {
    previewImages.value.splice(index, 1);
    if (form.images[index]) {
        form.images.splice(index, 1);
    }
};

const submit = () => {
    if (props.banner) {
        form.post(route('admin.banners.update', props.banner.id), {
            onSuccess: () => {
                emit('close');
                resetForm();
            },
            preserveScroll: true,
            forceFormData: true
        });
    } else {
        form.post(route('admin.banners.store'), {
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
                {{ banner ? 'Edit Banner' : 'Create New Banner' }}
            </h2>

            <form @submit.prevent="submit" class="mt-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="col-span-6">
                        <InputLabel for="title" value="Title"/>
                        <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required/>
                        <InputError :message="form.errors.title" class="mt-2"/>
                    </div>

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

                    <div class="sm:col-span-3">
                        <InputLabel for="start_date" value="Start Date"/>
                        <input
                            id="start_date"
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
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

                    <div class="sm:col-span-6">
                        <div class="flex items-center">
                            <Switch
                                v-model="form.status"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                :class="[form.status ? 'bg-indigo-600' : 'bg-gray-200']"
                            >
                                <span
                                    aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    :class="[form.status ? 'translate-x-5' : 'translate-x-0']"
                                />
                            </Switch>
                            <span class="ml-3">{{ form.status ? 'Active' : 'Inactive' }}</span>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <InputLabel value="Banner Images"/>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"/>
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600">
                                        <span>Upload banner images</span>
                                        <input type="file" class="sr-only" multiple accept="image/*" @change="handleImageUpload">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div v-if="previewImages.length" class="mt-4 grid grid-cols-4 gap-4">
                            <div v-for="(image, index) in previewImages" :key="index" class="relative">
                                <img :src="image.url" class="h-24 w-24 object-cover rounded-lg">
                                <button
                                    @click.prevent="removeImage(index)"
                                    class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white p-1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-x-4">
                    <SecondaryButton type="button" @click="$emit('close')">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">
                        {{ banner ? 'Update' : 'Create' }} Banner
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
