<template>
    <div class="registration">
        <div class="container d-flex flex-column align-items-center justify-content-center">
            <h4 class="mt-5">Dodaj predmet</h4>
            <form
                class="col-lg-5 border shadow-lg p-5  mt-5"
                @submit.prevent="dodajPredmet()"
                method="POST"
            >
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Ime predmeta</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        v-model="data.ime"
                    />
                </div>
                <p v-if="errors.ime" class="text-danger">
                    {{ errors.ime[0] }}
                </p>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"
                        >Studij</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputPassword1"
                        v-model="data.studij"
                    />
                </div>
                <p v-if="errors.studij" class="text-danger">
                    {{ errors.studij[0] }}
                </p>
                <button type="submit" class="btn btn-primary w-100">
                    Dodaj predmet
                </button>


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
                ime: "",
                studij: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},

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
        dodajPredmet(){
            const Data = {
                ime: this.data.ime,
                studij: this.data.studij,

            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajPredmet", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                    this.data = {
                        ime: "",
                        studij: "",

                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        }
    },
};
</script>

<style scoped>

</style>
