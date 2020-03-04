<template>
    <button :class="classObject"
            @click="follow"
            v-text="text">
    </button>
</template>

<script>
    export default {
        props: ['user'],
        name: "UserFollowButton",
        data() {
            return {
                followable: true,
                self: true,
            }
        },
        computed: {
            text() {
                return this.followable ? "关注" : "取关";
            },
            classObject() {
                if (this.self) {
                    return "d-none"
                }
                return this.followable ? "btn btn-sm btn-secondary" : "btn btn-sm btn-danger";
            },
        },
        mounted: function () {
            let currentObj = this;
            axios.post('/api/users/follow/stats', {'user': this.user})
                .then(function (response) {
                    currentObj.followable = response.data.followable;
                    currentObj.self = response.data.self;
                })
                .catch(function (e) {
                    console.log(e);
                });
        },
        methods: {
            follow() {
                let currentObj = this;
                axios.post('/api/users/follow', {'user': this.user})
                    .then(function (response) {
                            currentObj.followable = response.data.followable;
                            currentObj.self = response.data.self;
                        }
                    )
                    .catch(function (e) {
                        console.log(e);
                    });
            },
        }
    }
</script>

<style scoped>

</style>
