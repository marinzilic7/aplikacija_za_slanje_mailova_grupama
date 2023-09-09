<template>
    <div class="registration">
        <div class="container d-flex justify-content-center">
            <form
                class="col-lg-5 border shadow-lg p-5 bg-light mt-5"
                @submit.prevent="logUser()"
                method="POST"
            >
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Email adresa</label
                    >
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        v-model="data.email"
                    />
                </div>
                <p v-if="errors.email" class="text-danger">
                    {{ errors.email[0] }}
                </p>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"
                        >Lozinka</label
                    >
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        v-model="data.password"
                    />
                </div>
                <p v-if="errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </p>
                <button type="submit" class="btn btn-primary w-100">
                    Prijava
                </button>

                <div class="mt-3 alert alert-danger" v-if="falseReg">
                    Pogresan email/lozinka ili korisnik nije registriran.
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            data: {
                email: "",
                password: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            successRegg: false,
            falseReg: false,
        };
    },
    mounted() {
        this.fetchCsrfToken();
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        logUser() {
            const Data = {
                email: this.data.email,
                password: this.data.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/logUser", Data)
                .then((response) => {
                    this.logMessage = response.data.poruka;

                    this.successRegg = true;
                    if (this.logMessage == "Uspješna prijava") {
                        this.$store.dispatch(
                            "setLoginMessage",
                            this.logMessage
                        );
                        this.$store.commit(
                            "setLoggedInUser",
                            response.data.user
                        );
                        this.successRegg = true;
                        this.falseReg = false;
                        this.$router.push("/");
                    } else {
                        this.falseReg = true;
                        this.successRegg = false;
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
};
</script>

<style scoped>
.registration {
    background-image: url(../images/cover.png);
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 93.8vh;
    overflow: hidden !important;
}
</style>
