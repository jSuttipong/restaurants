<template>
    <div class="rtr-card-space d-flex justify-content-center">
        <div class="loading-container">
            <div
                class="rtr-img"
            >
                <div class=" placeholder-glow">
                    <span class="placeholder col-12 image-loading"></span>
                </div>
            </div>
            <div class="rtr-name mt-2">
                <h5 class="card-title placeholder-glow">
                    <span class="placeholder col-6"></span>
                </h5>
            </div>
            <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
            </p>
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style>
.image-loading{
    height: 150px;
    border-radius: 5px;
}
.loading-container {
    max-width: 250px;
    width: 100%;
    height: 330px;
    background: #fff;
    border-radius: 18px;
    padding: 10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: relative;
}
</style>
