<template>
    <div>
        <a class="btn btn-success" @click="toggleShow">设置头像</a>
        <my-upload field="img"
                   @crop-success="cropSuccess"
                   @crop-upload-success="cropUploadSuccess"
                   @crop-upload-fail="cropUploadFail"
                   v-model="show"
                   :width="300"
                   :height="300"
                   url="/avatar/upload"
                   :params="params"
                   :headers="headers"
                   img-format="png"></my-upload>
        <img :src="imgDataUrl" style="width:50px">
    </div>
</template>

<script>
    import 'babel-polyfill'; // es6 shim
    import myUpload from 'vue-image-crop-upload';

    export default {
        props: ['avatar'],
        name: "Avatar",
        data: function () {
            return {
                show: false,
                params: {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    name: 'avatar'
                },
                headers: {
                    smail: '*_~',
                },
                imgDataUrl: this.avatar // the datebase64 url of created image
            }
        },
        components: {
            'my-upload': myUpload
        },
        methods: {
            toggleShow() {
                this.show = !this.show;
            },
            /**
             * crop success
             *
             * [param] imgDataUrl
             * [param] field
             */
            cropSuccess(imgDataUrl, field) {
                console.log('-------- 剪截成功 --------');
                this.imgDataUrl = imgDataUrl;
            },
            /**
             * upload success
             *
             * [param] jsonData  server api return data, already json encode
             * [param] field
             */
            cropUploadSuccess(jsonData, field) {
                console.log('-------- 上传成功 --------');
                // console.log(jsonData);
                // console.log('field: ' + field);
                this.toggleShow();
            },
            /**
             * upload fail
             *
             * [param] status    server api return error status, like 500
             * [param] field
             */
            cropUploadFail(status, field) {
                console.log('-------- 上传失败 --------');
                console.log(status);
                console.log('field: ' + field);
            }
        }

    }
</script>

<style scoped>

</style>
