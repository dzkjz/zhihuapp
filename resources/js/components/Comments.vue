<template>
    <div>
        <button class="btn btn-sm btn-secondary ml-2"
                @click="showCommentsForm" v-text="showCommentText">
        </button>

        <div class="modal fade" :id="id" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            评论
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div v-if="comments.length>0">
                            <div class="card" v-for="comment in comments">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img :src="comment.user.avatar" class="img img-rounded img-fluid"
                                                 :alt="comment.user.name">
                                            <p class="text-secondary text-center"> {{
                                                comment.created_at }}</p>
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                <a class="float-left" href="#">
                                                    <strong>{{ comment.user.name}}</strong></a>
                                            </p>
                                            <div class="clearfix"></div>
                                            <p> {{ comment.content }}</p>
                                            <p>
                                                <a class="float-right btn btn-outline-primary ml-2"> <i
                                                    class="fa fa-reply"></i> 回复</a>
                                                <a class="float-right btn text-white btn-danger"> <i
                                                    class="fa fa-heart"></i> 点赞</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--                                  <div class="card card-inner">-->
                                <!--                                       <div class="card-body">-->
                                <!--                                           <div class="row">-->
                                <!--                                               <div class="col-md-2">-->
                                <!--                                                   <img src="https://image.ibb.co/jw55Ex/def_face.jpg"-->
                                <!--                                                        class="img img-rounded img-fluid"/>-->
                                <!--                                                   <p class="text-secondary text-center">15 Minutes Ago</p>-->
                                <!--                                               </div>-->
                                <!--                                               <div class="col-md-10">-->
                                <!--                                                   <p><a-->
                                <!--                                                       href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>Maniruzzaman-->
                                <!--                                                       Akash</strong></a></p>-->
                                <!--                                                   <p>Lorem Ipsum is simply dummy text of the pr make but also the leap-->
                                <!--                                                       into electronic typesetting, remaining essentially unchanged. It was-->
                                <!--                                                       popularised in the 1960s with the release of Letraset sheets-->
                                <!--                                                       containing Lorem Ipsum passages, and more recently with desktop-->
                                <!--                                                       publishing software like Aldus PageMaker including versions of Lorem-->
                                <!--                                                       Ipsum.</p>-->
                                <!--                                                   <p>-->
                                <!--                                                       <a class="float-right btn btn-outline-primary ml-2"> <i-->
                                <!--                                                           class="fa fa-reply"></i> Reply</a>-->
                                <!--                                                       <a class="float-right btn text-white btn-danger"> <i-->
                                <!--                                                           class="fa fa-heart"></i> Like</a>-->
                                <!--                                                   </p>-->
                                <!--                                               </div>-->
                                <!--                                           </div>-->
                                <!--                                       </div>-->
                                <!--                                   </div>-->
                            </div>
                        </div>
                        <input class="form-control" v-model="postComment" v-if="!success"></input>
                        <button type="button" class="btn btn-success" @click="store" v-if="!success">发送</button>
                        <div class="alert alert-success" v-if="success">评论发送成功！</div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['type', 'commentable_id'],
        name: "Comments.vue",
        data: function () {
            return {
                comments: [],
                postComment: null,
                success: false,
            }
        },
        computed: {
            id() {
                return 'model-comment' + '-' + this.type + '-' + this.commentable_id;
            },
            showCommentText() {
                return this.comments.length + "条评论";
            },
        },
        mounted() {
            this.getComments();
        },
        methods: {
            showCommentsForm() {
                this.getComments();
                $('#' + this.id).modal('show');//显示评论框
            },
            getComments() {
                let currentObject = this;
                axios.get('/api/' + this.type + '/' + this.commentable_id + '/comments').then(function (response) {
                    currentObject.comments = response.data.comments;
                }).catch(function (e) {
                    console.log(e);
                }).finally(function () {

                });
            },
            store() {
                let currentObject = this;
                axios.post('/api/comments', {
                    'type': this.type,
                    'commentable_id': this.commentable_id,
                    'postComment': this.postComment
                }).then(function (response) {
                    currentObject.comments.push(response.data.comment[0]);
                }).catch(function (e) {
                    console.log(e);
                }).finally(function () {

                });
            }
        }
    }
</script>

<style scoped>

</style>
