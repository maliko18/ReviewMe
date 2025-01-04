<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import {TrashIcon} from 'lucide-react';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    place: {
        type: Object,
        default: () => ({})
    },
    categories: Array,
    cities: Array,
    countries: Array
});

const form = useForm({
    name: props.place?.name || '',
    description: props.place?.description || '',
    categories: props.place?.categories?.map(c => c.id) || [],
    address: {
        address: props.place?.addresses?.[0]?.address || '',
        state: props.place?.addresses?.[0]?.state || '',
        zip: props.place?.addresses?.[0]?.zip || '',
        city_id: props.place?.addresses?.[0]?.city_id || '',
        country_id: props.place?.addresses?.[0]?.country_id || '',
        coordinates: props.place?.addresses?.[0]?.coordinates || null
    },
    images: [],
    deleted_images: []
});

const previewImages = ref([]);
const existingImages = ref(props.place?.images || []);

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    form.images = files;
    previewImages.value = [];
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => previewImages.value.push(e.target.result);
        reader.readAsDataURL(file);
    });
};

const removeExistingImage = (image) => {
    existingImages.value = existingImages.value.filter(img => img.id !== image.id);
    form.deleted_images.push(image.id);
};

const removeNewImage = (index) => {
    form.images.splice(index, 1);
    previewImages.value.splice(index, 1);
};

const submit = () => {
    if (props.place?.id) {
        form.put(route('admin.places.update', props.place.id));
    } else {
        form.post(route('admin.places.store'));
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-8 divide-y divide-gray-200">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ place ? 'Edit' : 'Create New' }} Place
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Provide the details for your place.
                    </p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <InputLabel for="name" value="Name"/>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-6">
                        <InputLabel for="description" value="Description"/>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        />
                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-6">
                        <InputLabel value="Categories"/>
                        <div class="mt-2 grid grid-cols-2 gap-4 sm:grid-cols-3">
                            <label
                                v-for="category in categories"
                                :key="category.id"
                                class="relative flex items-start"
                            >
                                <div class="flex h-5 items-center">
                                    <input
                                        type="checkbox"
                                        :value="category.id"
                                        v-model="form.categories"
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    />
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700">{{ category.name }}</span>
                                </div>
                            </label>
                        </div>
                        <InputError :message="form.errors.categories" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Address</h3>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <InputLabel for="country" value="Country"/>
                        <select
                            id="country"
                            v-model="form.address.country_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        >
                            <option value="">Select a country</option>
                            <option v-for="country in countries" :key="country.id" :value="country.id">
                                {{ country.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors['address.country_id']" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-3">
                        <InputLabel for="city" value="City"/>
                        <select
                            id="city"
                            v-model="form.address.city_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        >
                            <option value="">Select a city</option>
                            <option v-for="city in cities" :key="city.id" :value="city.id">
                                {{ city.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors['address.city_id']" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-6">
                        <InputLabel for="street-address" value="Street Address"/>
                        <TextInput
                            id="street-address"
                            v-model="form.address.address"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors['address.address']" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-3">
                        <InputLabel for="state" value="State / Province"/>
                        <TextInput
                            id="state"
                            v-model="form.address.state"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors['address.state']" class="mt-2"/>
                    </div>

                    <div class="sm:col-span-3">
                        <InputLabel for="zip" value="ZIP / Postal Code"/>
                        <TextInput
                            id="zip"
                            v-model="form.address.zip"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors['address.zip']" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Images</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Add images of your place. You can upload multiple images.
                    </p>
                </div>

                <div class="mt-6">
                    <label class="block">
                        <span class="sr-only">Choose images</span>
                        <input
                            type="file"
                            multiple
                            @change="handleImageUpload"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        />
                    </label>

                    <div v-if="previewImages.length || existingImages.length"
                         class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        <!-- Existing Images -->
                        <div
                            v-for="image in existingImages"
                            :key="image.id"
                            class="relative group aspect-w-1 aspect-h-1"
                        >
                            <img
                                :src="`/storage/${image.path}`"
                                class="object-cover rounded-lg h-32 w-full"
                            />
                            <button
                                type="button"
                                @click="removeExistingImage(image)"
                                class="absolute top-2 right-2 p-1 bg-red-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <TrashIcon class="h-4 w-4 text-red-600"/>
                            </button>
                        </div>

                        <!-- New Image Previews -->
                        <div
                            v-for="(preview, index) in previewImages"
                            :key="index"
                            class="relative group aspect-w-1 aspect-h-1"
                        >
                            <img
                                :src="preview"
                                class="object-cover rounded-lg h-32 w-full"
                            />
                            <button
                                type="button"
                                @click="removeNewImage(index)"
                                class="absolute top-2 right-2 p-1 bg-red-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <TrashIcon class="h-4 w-4 text-red-600"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <SecondaryButton
                    type="button"
                    :href="route('places.index')"
                    class="mr-3"
                >
                    Cancel
                </SecondaryButton>
                <PrimaryButton
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                >
                    {{ place ? 'Update' : 'Create' }} Place
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
