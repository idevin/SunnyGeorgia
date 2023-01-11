<auth-modal v-if="modalTab"
            login-route="{{ route('login', [], false) }}"
            register-route="{{ route('register.soft', [], false) }}"
            terms-route="{{ route('terms', [], false) }}"
            forgot-password-route="{{ route('password.email', [], false) }}"
></auth-modal>
