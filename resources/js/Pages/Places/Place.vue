<template>
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb Navigation -->
        <nav class="text-sm text-gray-500 mb-4">
            <span>Accueil</span> &gt;
            <span>Restaurants à Marseille</span> &gt;
            <span>Boccascena</span>
        </nav>

        <!-- Restaurant Overview -->
        <section>
            <div class="flex justify-between items-start">
                <!-- Left Section: Details -->
                <div>
                    <p class="bg-blue-100 text-blue-600 inline-block px-2 py-1 text-xs font-semibold rounded">
                        🏆 Top50
                    </p>
                    <h1 class="text-3xl font-bold mt-2">{{place.name}}</h1>
                    <p class="text-gray-500 mt-2 flex items-center space-x-2">
                        <span>📍 50 Quai du Lazaret, 13002, Marseille</span>
                        <span>•</span>
                        <span>🍴 Italien</span>
                        <span>•</span>
                        <span>💶 Prix moyen: 33 €</span>
                    </p>
                    <p class="mt-4 text-lg font-bold flex items-center space-x-2">
                        ⭐ 9,1
                        <span class="text-gray-500 text-sm">(6249 avis)</span>
                    </p>
                </div>

                <!-- Right Section: Favorite Icon -->
                <div>
                    <button class="text-gray-500 hover:text-gray-800">
                        ❤️
                    </button>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="mt-6 grid grid-cols-5 gap-4">
                <div class="col-span-2">
                    <img
                        src="https://via.placeholder.com/800x400"
                        alt="Main Photo"
                        class="rounded-lg w-full object-cover"
                    />
                </div>
                <div class="grid grid-cols-2 gap-4 col-span-3">
                    <img
                        src="https://via.placeholder.com/400x400/FF0000"
                        alt="Photo 1"
                        class="rounded-lg w-full object-cover"
                    />
                    <img
                        src="https://via.placeholder.com/400x400/00FF00"
                        alt="Photo 2"
                        class="rounded-lg w-full object-cover"
                    />
                    <img
                        src="https://via.placeholder.com/400x400/0000FF"
                        alt="Photo 3"
                        class="rounded-lg w-full object-cover"
                    />
                    <div
                        class="rounded-lg bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-semibold cursor-pointer"
                    >
                        Voir 548 autres photos
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mt-6 border-b">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    :class="[
                        'px-4 py-2',
                        activeTab === tab.id
                            ? 'border-b-2 border-green-600 font-bold'
                            : 'text-gray-500',
                    ]"
                >
                    {{ tab.name }}
                </button>
            </div>
            <div class="container mx-auto px-4 py-6">
                <!-- Reviews Header -->
                <h2 class="text-2xl font-bold mb-6">Avis</h2>

                <!-- Overall Rating and Details -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <div class="flex items-center space-x-6">
                        <!-- Main Rating -->
                        <div class="text-center">
                            <div class="text-green-600 text-4xl font-bold">9.1</div>
                            <div class="text-gray-500 text-sm">sur 10</div>
                        </div>
                        <!-- Rating Badge -->
                        <div>
                    <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                        Table exceptionnelle
                    </span>
                            <p class="text-gray-500 mt-2 text-sm">6249 avis</p>
                        </div>
                        <!-- Detailed Ratings -->
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span>Ambiance</span>
                                <div class="w-3/4 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 91%;"></div>
                                </div>
                                <span>9.1</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Plats</span>
                                <div class="w-3/4 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 91%;"></div>
                                </div>
                                <span>9.1</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Service</span>
                                <div class="w-3/4 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: 93%;"></div>
                                </div>
                                <span>9.3</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Info -->
                    <div class="mt-6 bg-gray-100 rounded-lg p-4 text-sm text-gray-700">
                        <p>De vraies expériences vécues par de vrais clients</p>
                        <p class="mt-2 text-xs text-gray-500">
                            Seuls les clients qui ont réservé avec TheFork ou payé avec TheFork Pay
                            peuvent publier des notes et des avis.
                            <a href="#" class="text-blue-600 hover:underline">
                                Comment les notes sont-elles calculées ?
                            </a>
                        </p>
                    </div>
                </div>

                <!-- AI-Generated Summary -->
                <div class="bg-pink-100 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-bold mb-2">Ce qu'en disent nos clients</h3>
                    <p class="text-sm text-gray-500 mb-4">✨ créé à l'aide de l'IA</p>
                    <p class="text-gray-800 leading-relaxed">
                        Boccascena séduit par son ambiance conviviale et une décoration soignée, offrant un cadre
                        agréable et calme. Les plats, bien que certains soient basiques, se distinguent par leur générosité
                        et leur goût, notamment la burrata avec pain noir et le tartare de bœuf, qualifié de meilleur au monde.
                        Le service est impeccable, avec un personnel attentionné et souriant, assurant une expérience agréable
                        malgré une salle comble.
                    </p>
                    <p class="text-xs text-gray-500 mt-4">Dernière mise à jour : 3 décembre 2024</p>

                    <p class="text-xs text-gray-500 mt-2">
                        Ce récapitulatif est généré par l'IA pour fournir un aperçu rapide des avis de vrais clients.
                        Notez que TheFork n'est pas responsable de ce récapitulatif ni des opinions qu'il contient.
                    </p>

                    <!-- Feedback Buttons -->
                    <div class="flex items-center justify-between mt-4">
                        <p class="text-gray-800 text-sm font-semibold">
                            Ce récapitulatif vous a-t-il été utile ?
                        </p>
                        <div class="flex space-x-4">
                            <button
                                class="flex items-center space-x-1 text-green-600 hover:text-green-800"
                            >
                                👍 <span>Oui</span>
                            </button>
                            <button
                                class="flex items-center space-x-1 text-gray-600 hover:text-gray-800"
                            >
                                👎 <span>Non</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <ReviewForm :place-slug="currentPlace.slug" />
            <div class="container mx-auto px-4 py-6">
                <!-- Filtering Options -->
                <div class="flex flex-wrap items-center space-x-4 mb-6">
                    <!-- Sorting Dropdown -->
                    <div>
                        <button class="border rounded-full px-4 py-2 text-sm bg-green-100 text-green-600">
                            Plus récent
                        </button>
                    </div>
                    <!-- Comment Filter Dropdown -->
                    <div>
                        <button class="border rounded-full px-4 py-2 text-sm text-gray-600">
                            Avec commentaire uniquement
                        </button>
                    </div>
                    <!-- Language Filter Dropdown -->
                    <div>
                        <button class="border rounded-full px-4 py-2 text-sm text-gray-600">
                            En Français uniquement
                        </button>
                    </div>
                    <!-- Occasion Dropdown -->
                    <div>
                        <button class="border rounded-full px-4 py-2 text-sm text-gray-600">
                            Occasion
                        </button>
                    </div>
                </div>

                <!-- Review Tags -->
                <div class="flex flex-wrap items-center space-x-2 mb-6">
                    <button
                        v-for="tag in tags"
                        :key="tag.text"
                        class="px-4 py-1 rounded-full text-sm"
                        :class="tag.active
                    ? 'bg-green-600 text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        @click="toggleTag(tag)"
                    >
                        {{ tag.text }} <span v-if="tag.count" class="ml-1">({{ tag.count }})</span>
                    </button>
                </div>

                <!-- Reviews List -->
                <div v-for="review in currentPlace.reviews" :key="review.id" class="border-b pb-4 mb-6">
                    <div class="flex justify-between items-start">
                        <!-- Left: Reviewer Info -->
                        <div>
                            <p class="font-semibold">{{ review.user?.name }}</p>
                            <p class="text-sm text-gray-500">{{  }}</p>
                            <p class="text-gray-800 mt-2">{{ review.body }}</p>
                        </div>
                        <!-- Right: Rating -->
                        <div class="text-xl font-bold text-green-600">{{ review.rating }}/5</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import {ref, reactive, computed} from 'vue';
import ReviewForm from "@/Pages/Places/Partials/ReviewForm.vue";

const props = defineProps({
    place: Object,
});

const currentPlace = computed(() => {
    return {
        ...props.place,
        images:props.place.images?.map(image => {
            return {
               path: image.path,
                alt: `${props.place.name}`,
            };
        }),
        reviews:props.place?.reviews?.map(review => {
            return {
                id: review.id,
                body: review.body,
                rating: review.rating,
                date: new Date(review.date).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                }),
                user: {
                    name: review.user.name,
                   /* profile_photo_url: review.user.profile_photo_url*/
                },
                images: review.images?.map(image => {
                    return {
                        path: image.path,
                    }
                })

            };
        }),
    }
});
// Tabs for the sections
const tabs = ref([
    { id: 'about', name: 'À propos' },
    { id: 'menu', name: 'Menu' },
    { id: 'reviews', name: 'Avis' },
]);
const activeTab = ref('about');
const tags = reactive([
    { text: 'Tous', count: null, active: true },
    { text: 'repas savoureux', count: 14, active: false },
    { text: 'assiettes copieuses', count: 13, active: false },
    { text: 'accueil chaleureux', count: 12, active: false },
    { text: 'service sympathique', count: 12, active: false },
    { text: 'accueil de qualité', count: 7, active: false },
    { text: 'personnel professionnel', count: 5, active: false },
    { text: 'service impeccable', count: 5, active: false },
    { text: 'ambiance agréable', count: 4, active: false },
    { text: 'bon rapport qualité/prix', count: 3, active: false },
    { text: 'ambiance conviviale', count: 3, active: false },
]);

// Toggle tag state
const toggleTag = (tag) => {
    tags.forEach((t) => {
        t.active = t.text === tag.text;
    });
};

</script>

<style>
.container {
    max-width: 1200px;
}
</style>




