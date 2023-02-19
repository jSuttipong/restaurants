<template>
    <div>
        <div class="input-group search-container mb-3">
            <span class="search-bar input-group-text" id="basic-addon1"
                ><i class="bi bi-search"></i
            ></span>
            <!-- Receive input and return value  -->
            <input
                class="search-bar form-control"
                type="text"
                :value="searchInput"
                @input="$emit('update:searchInput', $event.target.value)"
                placeholder="Bang sue"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["searchInput"],
    emits: ["update:searchInput"],
};
</script>

<style lang="css">
.search-container {
    border-radius: 12px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}
.search-bar.form-control {
    border-radius: 12px;
    border: none;
}
.search-bar.input-group-text {
    border-radius: 12px;
    background-color: #fff;
    border: none;
}
</style>
