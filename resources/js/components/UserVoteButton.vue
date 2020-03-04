<template>
    <button :class="classObject"
            @click="up"
            v-text="text">
    </button>
</template>

<script>
    export default {
        props: ['answer', 'vote_count'],
        name: "UserVoteButton",
        data() {
            return {
                voteable: true,
                text: this.vote_count,
            }
        },
        computed: {
            classObject() {
                return this.voteable ? "btn btn-sm btn-secondary" : "btn btn-sm btn-danger";
            },

        },
        mounted: function () {
            let currentObj = this;
            axios.post('/api/answers/vote/stats', {'answer': this.answer})
                .then(function (response) {
                    currentObj.voteable = response.data.voteable;
                    currentObj.text = response.data.vote_count;
                })
                .catch(function (e) {
                    console.log(e);
                });
        },
        methods: {
            up() {
                let currentObj = this;
                axios.post('/api/answers/vote/up', {'answer': this.answer})
                    .then(function (response) {
                            currentObj.voteable = response.data.voteable;
                            currentObj.text = response.data.vote_count;
                        }
                    )
                    .catch(function (e) {
                        console.log(e);
                    });
            },
            //暂时不写踩的
            down() {
                let currentObj = this;
                axios.post('/api/answers/vote/down', {'answer': this.answer})
                    .then(function (response) {
                            currentObj.voteable = response.data.voteable;
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
