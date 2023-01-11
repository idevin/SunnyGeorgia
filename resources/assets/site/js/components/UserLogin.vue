<template>
    <form v-on:submit.prevent="onSubmit">
        <div class="form-group">
            <label for="login-email" class="col-form-label">Email:</label>
            <input type="email"
                   name="email"
                   v-model="email"
                   class="form-control"
                   :class="{'is-valid': emailValid, 'is-invalid': !emailValid}"
                   @change = "changeEmail()"
                   id="login-email" required>
            <small v-if="emailMsg" class="form-text alert alert-danger">{{emailMsg}}</small>
        </div>
        <div class="form-group">
            <label for="login-password"
                   class="col-form-label">{{localization['Password']}}:</label>

            <input type="password" name="password"
                   v-model="password"
                   class="form-control"
                   id="login-password"
                   required>
        </div>

        <div class="form-group ">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       name="remember"
                       v-model="remember"
                       id="login-remember">
                <label class="custom-control-label"
                       for="login-remember">{{localization['Remember me']}}</label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-primary"
                    type="submit">{{localization['Login']}}</button>
            <a href="#remind" data-toggle="modal" data-dismiss="modal"
               class="modal-link pull-right">{{localization['Forgot password?']}}</a>
        </div>

    </form>
</template>
<script>
    export default {
        props: ['localization', 'postLogin'],
        data() {
            return {
                email: "",
                password: "",
                remember: true,
                emailMsg: null,
                emailValid: true
            }
        },
        methods: {
            changeEmail() {
                this.emailMsg = null;
                this.emailValid = true;
            },

            onSubmit() {

                axios.post(this.postLogin, {
                    email: this.email,
                    password: this.password,
                    remember: this.remember

                }).then((response) => {

                    if (response.data.success) {
                        this.$toasted.show(response.data.msg, {
                            type: 'success'
                        });
                        this.$emit('soft-registration:success', {email: response.data.user.email, mobile: response.data.user.mobile_number});
                    }

                }).catch(error => {
                    if (error.response.data.errors) {
                        if (error.response.data.errors.email) {
                            this.emailMsg = error.response.data.errors.email[0];
                            this.emailValid = false;
                        }
                    }
                }).finally(function () {

                });
                return true;
            }

        }
    }
</script>