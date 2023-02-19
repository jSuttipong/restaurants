<template>
    <div class="container pt-3">
        <div class="my-3 my-sm-5">
            <h1>Find your restaurants.</h1>
            <h2>Location : {{ currentPlace }}</h2>
        </div>
        <SearchBar
            v-model:searchInput="searchInput"
            v-on:keyup.enter="findLocation"
        />
        <ButtonNav />
        <div v-if="apiError">
            <WrongCard />
        </div>
        <div v-if="isLoading" class="row">
            <LoadingCard class="col-6 col-md-4 col-lg-3 col-xl-2 my-2" />
            <LoadingCard class="col-6 col-md-4 col-lg-3 col-xl-2 my-2" />
            <LoadingCard class="col-6 col-md-4 col-lg-3 col-xl-2 my-2" />
        </div>
        <div v-else class="row">
            <RtrCard
                v-for="place in placeBySearch"
                :restaurantsName="place.name"
                :restaurantsRef="place.photoRef"
                :restaurantsPhoto="place.placeData"
                :restaurantsRate="place.rating"
                :restaurantsPosition="place.vicinity"
                :restaurantsLat="place.lat"
                :restaurantsLng="place.lng"
                :isLoading="isLoading"
                class="col-6 col-md-4 col-lg-3 col-xl-2 my-2"
            />
            <div
                v-if="nextPageToken && !isLoadingNextPage"
                class="col-6 col-md-4 col-lg-3 col-xl-2 my-2"
            >
                <LoadmoreCard @click="callNextPage()" />
            </div>
            <div
                v-else-if="isLoadingNextPage && nextPageToken"
                class="col-6 col-md-4 col-lg-3 col-xl-2 my-2"
            >
                <LoadingCard />
            </div>
        </div>
    </div>
</template>

<script>
import SearchBar from "../Components/SearchBar.vue";
import ButtonNav from "../Components/ButtonNav.vue";
import RtrCard from "../Components/RtrCard.vue";
import LoadingCard from "../Components/LoadingCard.vue";
import WrongCard from "../Components/WrongCard.vue";
import LoadmoreCard from "../Components/LoadmoreCard.vue";

import axios from "axios";
export default {
    components: {
        SearchBar,
        ButtonNav,
        RtrCard,
        LoadingCard,
        WrongCard,
        LoadmoreCard,
    },
    data() {
        return {
            searchInput: "",
            apiUrl: process.env.APP_URL,
            placeBySearch: [],
            isLoading: true,
            nextPageToken: "",
            havePlace: false,
            currentPlace: "Bang sue",
            apiError: false,
            currentlatAndLng: {
                lat: "",
                lng: "",
            },
            isLoadingNextPage: false,
        };
    },
    mounted() {
        // Set default search.
        this.findLocation();
    },
    methods: {
        findLocation() {
            let vm = this;
            this.isLoading = true;
            this.placeBySearch = [];
            this.currentPlace = this.searchInput
                ? this.searchInput
                : "Bang sue";
            // const encodedInput = encodeURIComponent(this.currentPlace);
            this.getSearchPlace(this.currentPlace).then((searchRes) => {
                vm.getNearby(searchRes.lat, searchRes.lng).then(
                    (NearbyData) => {
                        vm.placeBySearch = NearbyData;
                        for (let i = 0; i < vm.placeBySearch.length; i++) {
                            // vm.getPhotoPlace(vm.placeBySearch[i].photoRef).then(
                            //     (photoPlaceData) => {
                            //         vm.placeBySearch[i].placeData = photoPlaceData;
                            //     }
                            // );
                            vm.placeBySearch[i].placeData = "";
                        }
                        vm.isLoading = false;
                    }
                );
            });
        },
        async getSearchPlace(place) {
            try {
                let response = await axios.get(
                    this.apiUrl + "/api/map/getsearchplace",
                    {
                        params: {
                            location: place,
                        },
                    }
                );
                return response.data;
            } catch (error) {
                this.isLoading = false;
                this.apiError = true;
                console.log(error);
            }
        },
        async getNearby(lat, lng, pageToken) {
            this.currentlatAndLng.lat = lat;
            this.currentlatAndLng.lng = lng;
            try {
                const response = await axios.get(
                    this.apiUrl + "/api/map/getnearby",
                    {
                        params: {
                            lat: lat,
                            lng: lng,
                            pageToken: pageToken ? pageToken : " ",
                        },
                    }
                );

                let rawData = response.data.results;
                let transfromData = [];
                this.nextPageToken = response.data.next_page_token;
                for (let i = 0; i < rawData.length; i++) {
                    transfromData.push({
                        name: rawData[i].name ? rawData[i].name : "",
                        rating: rawData[i].rating ? rawData[i].rating : "0",
                        userRate: rawData[i].user_ratings_total
                            ? rawData[i].user_ratings_total
                            : "0",
                        vicinity: rawData[i].vicinity
                            ? rawData[i].vicinity
                            : "",
                        photoRef: rawData[i].photos
                            ? rawData[i].photos[0].photo_reference
                            : "",
                        lat: rawData[i].geometry.location.lat
                            ? rawData[i].geometry.location.lat
                            : "",
                        lng: rawData[i].geometry.location.lng
                            ? rawData[i].geometry.location.lng
                            : "",
                    });
                }
                return transfromData;
            } catch (error) {
                this.isLoading = false;
                this.apiError = true;
                console.log(error);
            }
        },
        // No use this because it too slow.
        async getPhotoPlace(reference) {
            // Get photo with google api base64.
            try {
                const response = await axios.get(
                    this.apiUrl + "/api/map/getphotoplace",
                    {
                        params: {
                            reference: reference,
                        },
                    }
                );
                return response.data.photo_data;
            } catch (error) {
                this.isLoading = false;
                this.apiError = true;
                console.log(error);
            }
        },
        async getNextPage(nextPageToken) {
            try {
                const response = await axios.get(
                    this.apiUrl + "/api/map/getnextpage",
                    {
                        params: {
                            pagetoken: nextPageToken,
                        },
                    }
                );
                let rawData = response.data.results;
                let transfromData = [];
                this.nextPageToken = response.data.next_page_token;
                for (let i = 0; i < rawData.length; i++) {
                    transfromData.push({
                        name: rawData[i].name ? rawData[i].name : "",
                        rating: rawData[i].rating ? rawData[i].rating : "0",
                        userRate: rawData[i].user_ratings_total
                            ? rawData[i].user_ratings_total
                            : "0",
                        vicinity: rawData[i].vicinity
                            ? rawData[i].vicinity
                            : "",
                        photoRef: rawData[i].photos
                            ? rawData[i].photos[0].photo_reference
                            : "",
                        lat: rawData[i].geometry.location.lat
                            ? rawData[i].geometry.location.lat
                            : "",
                        lng: rawData[i].geometry.location.lng
                            ? rawData[i].geometry.location.lng
                            : "",
                    });
                }
                return transfromData;
            } catch (error) {
                this.isLoading = false;
                this.apiError = true;
                console.log(error);
            }
        },
        callNextPage() {
            this.isLoadingNextPage = true;
            this.getNextPage(this.nextPageToken)
                .then((response) => {
                    for (let i = 0; i < response.length; i++) {
                        this.placeBySearch.push(response[i]);
                    }
                    this.isLoadingNextPage = false;
                })
                .catch((err) => {
                    this.isLoadingNextPage = false;
                    console.log(err);
                });
        },
    },
};
</script>
<style></style>
