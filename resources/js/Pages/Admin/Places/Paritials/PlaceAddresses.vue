<template>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Manage Place Addresses</h2>

        <!-- Address List -->
        <div v-if="addresses.length" class="space-y-4 mb-6">
            <div
                v-for="(address, index) in addresses"
                :key="address.id"
                class="flex justify-between items-center bg-gray-100 p-4 rounded"
            >
                <div>
                    <p class="font-semibold">{{ address.street }}</p>
                    <p class="text-sm text-gray-600">{{ address.city }}, {{ address.zip_code }}</p>
                </div>
                <div class="flex space-x-2">
                    <!-- Edit Button -->
                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        @click="editAddress(index)"
                    >
                        Edit
                    </button>
                    <!-- Delete Button -->
                    <button
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                        @click="deleteAddress(address.id)"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Add/Edit Address Form -->
        <form @submit.prevent="saveAddress" class="space-y-4">
            <h3 class="text-lg font-semibold">
                {{ editingIndex !== null ? 'Edit Address' : 'Add Address' }}
            </h3>
            <div>
                <label class="block text-sm font-medium text-gray-700">Street</label>
                <input
                    type="text"
                    v-model="form.street"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
                <p v-if="form.errors.street" class="text-red-500 text-sm">{{ form.errors.street }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input
                    type="text"
                    v-model="form.city"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
                <p v-if="form.errors.city" class="text-red-500 text-sm">{{ form.errors.city }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Zip Code</label>
                <input
                    type="text"
                    v-model="form.zip_code"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                />
                <p v-if="form.errors.zip_code" class="text-red-500 text-sm">{{ form.errors.zip_code }}</p>
            </div>
            <button
                type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
                {{ editingIndex !== null ? 'Update Address' : 'Add Address' }}
            </button>
            <button
                v-if="editingIndex !== null"
                type="button"
                class="ml-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700"
                @click="cancelEdit"
            >
                Cancel
            </button>
        </form>
    </div>
</template>

<script  setup>
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";
const props=defineProps({
    placeId: {
        type: Number,
        required: true,
    },
    existingAddresses: {
        type: Array,
        default: () => [
            {
                id: 1,
                street: '123 Main St',
                city: 'Springfield',
                zip_code: '12345',
            },
            {
                id: 1,
                street: '123 Main St',
                city: 'Springfield',
                zip_code: '12345',
            },
        ],
    },
})
// Addresses
const addresses = ref([...props.existingAddresses]);

// Form for adding/editing addresses
const form = useForm({
    street: '',
    city: '',
    zip_code: '',
});

// State for editing
const editingIndex = ref(null);

// Save Address (Add or Update)
const saveAddress = () => {
    if (editingIndex.value !== null) {
        // Update address
        const addressId = addresses.value[editingIndex.value].id;
        form.put(`/admin/places/${props.placeId}/addresses/${addressId}`, {
            onSuccess: () => {
                addresses.value[editingIndex.value] = { ...form, id: addressId };
                cancelEdit();
                alert('Address updated successfully!');
            },
        });
    } else {
        // Add new address
        form.post(`/admin/places/${props.placeId}/addresses`, {
            onSuccess: ({ props }) => {
                addresses.value.push(props.address);
                form.reset();
                alert('Address added successfully!');
            },
        });
    }
};

// Edit Address
const editAddress = (index) => {
    editingIndex.value = index;
    form.street = addresses.value[index].street;
    form.city = addresses.value[index].city;
    form.zip_code = addresses.value[index].zip_code;
};

// Cancel Editing
const cancelEdit = () => {
    editingIndex.value = null;
    form.reset();
};

// Delete Address
const deleteAddress = (id) => {
    if (confirm('Are you sure you want to delete this address?')) {
        form.delete(`/admin/places/${props.placeId}/addresses/${id}`, {
            onSuccess: () => {
                addresses.value = addresses.value.filter((address) => address.id !== id);
                alert('Address deleted successfully!');
            },
        });
    }
};
</script>

