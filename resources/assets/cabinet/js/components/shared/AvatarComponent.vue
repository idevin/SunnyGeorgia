<template>
    <div class="example-avatar">
        <div class="avatar-upload"  v-show="!edit">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="m-section__content text-center">
                        <img :src="avatar ? avatar : 'https://www.gravatar.com/avatar/default?s=200&r=pg&d=mm'"  class="rounded-circle" />
                    </div>
                </div>
                <div class="m-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" id="pick-avatar">Загрузить аватар</button>
                            <avatar-cropper
                                    @uploaded="handleUploaded"
                                    @completed="handleCompleted"
                                    @error="handleError"
                                    @uploading="handleUploading"
                                    trigger="#pick-avatar"
                                    :upload-url="uploadUrl"
                                    :upload-headers="{'X-CSRF-TOKEN': csrfToken}"
                                    :upload-form-data="{user_id: userId}"
                                    :labels="{ submit: 'Сохранить', cancel: 'Отменить'}"
                                    upload-form-name="avatar"
                                    :output-options="{width: 600, height: 600}"
                            ></avatar-cropper>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .example-avatar .avatar-upload .rounded-circle {
        width: 197px;
        height: 197px;
    }

    .example-avatar .text-center .btn {
        margin: 0 .5rem

    }
    .example-avatar .avatar-edit-image {
        max-width: 100%;
        max-height: 500px
    }


    .example-avatar .drop-active {
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        position: fixed;
        z-index: 9999;
        opacity: .6;
        text-align: center;
        background: #000;
    }

    .example-avatar .drop-active h3 {
        margin: -.5em 0 0;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 40px;
        color: #fff;
        padding: 0;
    }

    .avatar-cropper .avatar-cropper-overlay {
        background-color: #00000094;
    }
</style>
<script>
    const csrfToken = window.Laravel.csrfToken;
    import AvatarCropper from "vue-avatar-cropper"

    export default {
        components: {AvatarCropper},
        props: ['user-avatar', 'header-text', 'upload-url', 'user-id'],
        data() {
            return {
                file: [],
                edit: false,
                cropper: false,
                avatar: null,
                csrfToken: csrfToken,
            }
        },
        methods: {
            handleUploaded(response, form, xhr) {
                console.log('handleUploaded', response, form, xhr)
                this.avatar = response.relative_url;
                window.location.reload()
            },
            handleCompleted(response, form, xhr) {
                console.log('handleCompleted', response, form, xhr)
            },
            handleError(message, type, context) {
                console.log('handleError', message, type, context)
            },
            handleUploading(form, xhr) {
                console.log('handleUploading', form, xhr)
            }
        },
        mounted() {
            this.avatar = this.userAvatar
        }
    }
</script>

