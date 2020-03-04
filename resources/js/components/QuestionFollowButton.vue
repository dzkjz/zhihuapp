<template>
    <button :class="classObject"
            @click="follow"
            v-text="text">
    </button>
</template>

<script>
    export default {
        props: ['question'],
        name: "QuestionFollowButton",
        data() {
            return {
                followable: true,
            }
        },
        computed: {
            text() {
                return this.followable ? "关注问题" : "取消关注";
            },
            classObject() {
                return this.followable ? "btn btn-block btn-primary" : "btn btn-block btn-danger";
            },
        },
        mounted: function () {
            let currentObj = this;
            axios.post('/api/questions/follow/stats', {'question': this.question})
                .then(function (response) {
                    currentObj.followable = response.data.followable;
                })
                .catch(function (e) {
                    console.log(e);
                });
        },
        methods: {
            follow() {
                let currentObj = this;
                axios.post('/api/questions/follow', {'question': this.question})
                    .then(function (response) {
                            currentObj.followable = response.data.followable;
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
