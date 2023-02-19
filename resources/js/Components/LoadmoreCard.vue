<template>
    <div
        class="load-more-container mouse-hover-pointer d-flex justify-content-center align-items-center"
    >
        <i
            class="bi bi-plus-circle"
        ></i>
    </div>
</template>
<style>
.load-more-container {
    max-width: 250px;
    width: 100%;
    height: 330px;
    background: #fff;
    border-radius: 18px;
    padding: 10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: relative;
}
.mouse-hover-pointer:hover {
    cursor: pointer;
}
.load-more-container i {
    font-size: 45px;
    color: #999;
}
</style>
