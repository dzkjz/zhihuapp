<template>
    <div>
        <button class="btn btn-sm btn-secondary ml-2"
                @click="showMessageForm">私信
        </button>

        <div class="modal fade" id="model-send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            编辑并发送私信
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <textarea class="form-control" rows="10" v-model="message" v-if="!success"></textarea>
                        <div class="alert alert-success" v-if="success">私信发送成功！</div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-success" @click="send" v-if="!success">发送</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        name: "SendMessage",
        data() {
            return {
                voteable: true,
                message: '',
                success: false,
            }
        },
        computed: {},
        mounted: function () {

        },
        methods: {
            send() {
                let currentObj = this;
                axios.post('/api/messages/send', {'user': this.user, 'message': this.message})
                    .then(function (response) {
                            currentObj.message = '';
                            currentObj.success = response.data.success;
                            //两秒钟后关闭弹窗
                            if (currentObj.success) {
                                setTimeout(function () {
                                    $('#model-send-message').modal('hide');
                                }, 2000);
                            }
                        }
                    )
                    .catch(function (e) {
                        console.log(e);
                    });
            },
            showMessageForm() {
                $('#model-send-message').modal('show');//显示发送编辑框
            }
        }
    }
</script>

<style scoped>

</style>
