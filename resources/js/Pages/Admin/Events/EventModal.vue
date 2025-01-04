<script setup>
import { onMounted } from 'vue';
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

const form = useForm({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
    status: true,
    place_id: '',
    meta: {}
});

onMounted(() => {
    if (props.event) {
        form.name = props.event.name;
        form.description = props.event.description;
        form.start_date = props.event.start_date;
        form.end_date = props.event.end_date;
        form.status = props.event.status;
        form.place_id = props.event.place_id;
        form.meta = props.event.meta || {};
    }
});

const submit = () => {
    if (props.event) {
        form.put(route('admin.events.update', props.event.id), {
            onSuccess: () => {
                emit('close');
                form.reset();
            }
        });
    } else {
        form.post(route('admin.events.store'), {
            onSuccess: () => {
                emit('close');
                form.reset();
            }
        });
    }
};
</script>

<template>
    <Modal
        :show="modelValue"
        @close="$emit('update:modelValue', false)"
        :maxWidth="'2xl'"
    >
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ event ? 'Edit Event' : 'Create New Event' }}
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Event Name -->
                    <div class="sm:col-span-4">
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
                    <div class="sm:col-span-4">
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
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-4">
                    <SecondaryButton @click="$emit('close')" type="button">
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
