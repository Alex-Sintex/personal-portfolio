import { Ref, ref } from "vue";
import { inject } from "vue";
import { VueCookies } from 'vue-cookies';

class AuthService {
  private jwt: Ref<string>;
  private error: Ref<string>;
  private $cookies: VueCookies;

  constructor() {
    this.jwt = ref("");
    this.error = ref("");
    this.$cookies = inject('$cookies') as VueCookies;
  }

  getJwt(): Ref<string> {
    return this.jwt;
  }

  getError(): Ref<string> {
    return this.error;
  }

  async login(email: string, password: string): Promise<boolean> {
    try {
      const res = await fetch("https://v2.api.directus.cloud/auth/login", {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          email: email,
          password: password,
        }),
      });

      const response = await res.json();

      if ("errors" in response) {
        this.error.value = "Login failed";
        return false;
      }

      this.jwt.value = response.data.access_token;
      this.$cookies.set("auth", response.data.access.token)
      //$session.start()
      //$session.set('auth', response.data.access_token)
      return true;
    } catch (error) {
      this.error.value = "Login failed";
      return false;
    }
  }
}

export default AuthService