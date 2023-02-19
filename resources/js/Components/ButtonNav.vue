<template>
  <div class="button-container">
    <div class="button-item d-flex justify-content-center align-items-center">
      <div>
        <div
          class="button-icon d-flex justify-content-center align-items-center"
        >
          <div class="">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
        </div>
        <h5 class="button-text text-center">All</h5>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
    };
  },
};
</script>
<style>
.button-container {
  width: 100px;
  height: 100px;
}
.button-item {
  width: 100px;
  height: 100px;
  position: absolute;
  align-items: center;
}
.button-icon {
  width: 50px;
  height: 50px;
  border-radius: 50px;
  background-color: #fff;
  position: relative;
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}
</style>
