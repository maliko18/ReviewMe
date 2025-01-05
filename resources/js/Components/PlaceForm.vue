```vue
<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {TrashIcon} from 'lucide-vue-next';

const props = defineProps({
    place: {
        type: Object,
        default: () => ({})
    },
    categories: Array,
    cities: Array,
    countries: Array
});

const emit = defineEmits(['submitted']);

const form = useForm({
    name: props.place?.name || '',
    description: props.place?.description || '',
    categories: props.place?.categories?.map(c => c.id) || [],
    address: {
        address: props.place?.address?.address || '',
        state: props.place?.address?.state || '',
        zip: props.place?.address?.zip || '',
        city_id: props.place?.address?.city_id || '',
        country_id: props.place?.address?.country_id || ''
    },
    images: [],
    deleted_images: []
});

const previewImages = ref([]);
const existingImages = ref(props.place?.images || []);

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    form.images = [...form.images, ...files];
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
        form.post(route('admin.places.update', props.place.id), {
            onSuccess: () => emit('submitted')
        });
    } else {
        form.post(route('admin.places.store'), {
            onSuccess: () => emit('submitted')
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="p-6">
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">
                    {{ props.place.id ? 'Edit' : 'Create New' }} Place
                </h3>
            </div>

            <div class="space-y-4">
                <div class="flex flex-col items-start">
                    <InputLabel for="name" value="Name"/>
                    <TextInput
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError :message="form.errors.name"/>
                </div>

                <div class="flex flex-col items-start">
                    <InputLabel for="description" value="Description"/>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    />
                    <InputError :message="form.errors.description"/>
                </div>

                <div class="flex flex-col items-start">
                    <InputLabel value="Categories"/>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <label v-for="category in categories" :key="category.id" class="flex items-center">
                            <input
                                type="checkbox"
                                :value="category.id"
                                v-model="form.categories"
                                class="rounded border-gray-300 text-indigo-600"
                            />
                            <span class="ml-2">{{ category.name }}</span>
                        </label>
                    </div>
                    <InputError :message="form.errors.categories"/>
                </div>

                <!-- Address Section -->
                <div class="space-y-4">
                    <h4 class="font-medium">Address</h4>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col items-start">
                            <InputLabel for="country" value="Country"/>
                            <select
                                id="country"
                                v-model="form.address.country_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Country</option>
                                <option v-for="country in countries" :key="country.id" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors['address.country_id']"/>
                        </div>

                        <div class="flex flex-col items-start">
                            <InputLabel for="city" value="City"/>
                            <select
                                id="city"
                                v-model="form.address.city_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select City</option>
                                <option v-for="city in cities" :key="city.id" :value="city.id">
                                    {{ city.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors['address.city_id']"/>
                        </div>
                    </div>

                    <div class="flex flex-col items-start">
                        <InputLabel for="address" value="Street Address"/>
                        <TextInput
                            id="address"
                            v-model="form.address.address"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors['address.address']"/>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col items-start">
                            <InputLabel for="state" value="State"/>
                            <TextInput
                                id="state"
                                v-model="form.address.state"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors['address.state']"/>
                        </div>

                        <div class="flex flex-col items-start">
                            <InputLabel for="zip" value="ZIP Code"/>
                            <TextInput
                                id="zip"
                                v-model="form.address.zip"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors['address.zip']"/>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div>
                    <h4 class="font-medium mb-2">Images</h4>

                    <input
                        type="file"
                        multiple
                        @change="handleImageUpload"
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    />

                    <div v-if="previewImages.length || existingImages.length" class="mt-4 grid grid-cols-3 gap-4">
                        <div v-for="image in existingImages" :key="image.id" class="relative group">
                            <img :src="`${image.path}`" class="h-24 w-full object-cover rounded"/>
                            <button
                                type="button"
                                @click="removeExistingImage(image)"
                                class="absolute top-1 right-1 p-1 bg-red-100 rounded-full opacity-0 group-hover:opacity-100"
                            >
                                <TrashIcon class="h-4 w-4 text-red-600"/>
                            </button>
                        </div>

                        <div v-for="(preview, index) in previewImages" :key="index" class="relative group">
                            <img :src="preview" class="h-24 w-full object-cover rounded"/>
                            <button
                                type="button"
                                @click="removeNewImage(index)"
                                class="absolute top-1 right-1 p-1 bg-red-100 rounded-full opacity-0 group-hover:opacity-100"
                            >
                                <TrashIcon class="h-4 w-4 text-red-600"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <PrimaryButton
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                >
                    {{ props.place.id ? 'Update' : 'Create' }}
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
```
