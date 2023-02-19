<template>
    <div class="rtr-card-space d-flex justify-content-center">
        <div class="rtr-card-container">
            <div class="rtr-img d-flex justify-content-center align-items-center">
                
                <!-- Set restaurants photo -->
                <!-- <img
                    v-if="restaurantsPhoto"
                    :src="'data:image/jpeg;base64,' + restaurantsPhoto"
                />
                <div v-else class="no-image ">
                    <i class="bi bi-card-image"></i>
                </div> -->
                <!-- Use below for fast response -->
                <img :src="'https://maps.googleapis.com/maps/api/place/photo?maxwidth=300&photoreference='+restaurantsRef+'&key='+urlKey" alt="">
            </div>
            <div class="rtr-name mt-2">
                <p>{{ restaurantsName }}</p>
            </div>
            <div class="d-flex flex-row">
                <div  class="rating-star">
                    <!-- In :class Set color for star rating by use method -->
                    <span
                    class="fa fa-star"
                    :class="{ checked: getStarColor(index) }"
                    v-for="(star, index) in stars"
                    :key="index"
                ></span>
                </div>
                
                <p class="my-0">{{ restaurantsRate }}</p>
            </div>
            <p class="rtr-detail">{{ restaurantsPosition }}</p>
                <button class="btn-open " @click="openMap()"><i class="bi bi-geo-alt"></i></button>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        "restaurantsName",
        "restaurantsRef",
        "restaurantsPhoto",
        "restaurantsRate",
        "restaurantsPosition",
        "isLoading",
        "restaurantsLat",
        "restaurantsLng"
    ],
    data() {
        return {
            stars: [1, 2, 3, 4, 5],
            urlKey: process.env.GOOGLE_MAPS_API_KEY // Setting secure in google console
        }
    },
    methods:{
        // Calculate decimal of rating
        getStarColor(index) { 
            if (index < Math.floor(this.restaurantsRate)) {
                return true;
            } else if (index === Math.floor(this.restaurantsRate) && this.restaurantsRate % 1 >= 0.5) {
                return true;
            } else {
                return false;
            }
        },
        openMap(){
            const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(this.restaurantsName)}@${this.restaurantsLat},${this.restaurantsLng}`;
            window.open(mapsUrl, '_blank');
        }
    }
};
</script>
<style>
.rtr-card-container {
    width: 250px;
    height: 330px;
    background: #fff;
    border-radius: 18px;
    padding: 10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: relative;
}
.rtr-img {
    height: 150px;
}
.rtr-img img {
    width: 100%;
    height: 150px;
    border-radius: 5px;
    object-fit: cover;
}
.rtr-name {
    height: 50px;
    font-size: 18px;
    line-height: 1.3;
    font-weight: bold;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    max-height: calc(var(--lh) * 2);
    overflow: hidden;
    text-overflow: ellipsis;
}
.rtr-detail {
    font-size: 15px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    max-height: calc(var(--lh) * 3);
    overflow: hidden;
    text-overflow: ellipsis;
}
.rating-star {
    margin-right: 10px;
    color: #999;
}
.checked{
    color: #ed9c4a;
}
.no-image i{
    font-size: 100px;
    color: #999;
}
.btn-open{
    margin-bottom: 0;
    border: none;
    border-radius: 5px;
    width: 50px;
    height: 35px;
    background: #d77272;
    color: #fff;
    position: absolute;
    /* bottom: 18px; */
    top: 14px;
    right: 13px;
}
.btn-open:hover{
    background: #e14949;
}
</style>
