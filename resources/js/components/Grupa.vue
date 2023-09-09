<template>
    <div class="registration">
        <div
            class="container d-flex flex-column align-items-center justify-content-center"
        >
            <h4 class="mt-5">Dodaj predmet</h4>
            <form
                class="col-lg-5 border shadow-lg p-5 mt-5"
                @submit.prevent="dodajGrupu()"
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
                        >Opis grupe</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputPassword1"
                        v-model="data.opis"
                    />
                </div>
                <p v-if="errors.opis" class="text-danger">
                    {{ errors.opis[0] }}
                </p>
                <button type="submit" class="btn btn-primary w-100">
                    Dodaj predmet
                </button>
            </form>
        </div>

        <div class="container">
            <h4 class="mt-5 ms-4">Sve grupe</h4>
            <table class="table table-bordered border-secondary border mt-5 shadow-lg">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Korisnik</th>
                        <th scope="col">Ime</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Kreirana</th>
                        <th scope="col">Izbrisi</th>
                        <th scope="col">Uredi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="grupa in grupe">
                        <th>{{ grupa.id }}</th>
                        <th>{{ grupa.user.ime }}</th>
                        <th>{{ grupa.ime }}</th>
                        <th>{{ grupa.opis }}</th>
                        <th>{{ grupa.created_at }}</th>
                        <th><button class="btn btn-sm btn-danger">Izbrisi</button></th>
                        <th><button class="btn btn-sm btn-warning">Uredi</button></th>
                    </tr>
                </tbody>
            </table>
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
                opis: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            grupe: [],
        };
    },
    mounted() {
        this.fetchCsrfToken();
        this.getGroup();
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
        dodajGrupu() {
            const Data = {
                ime: this.data.ime,
                opis: this.data.opis,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajGrupu", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                     this.getGroup();
                    this.data = {
                        ime: "",
                        opis: "",
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
        },
        getGroup() {
            axios
                .get("/getGroup")
                .then((response) => {
                    this.grupe = response.data.map((grupa) => ({
                        ...grupa,
                        created_at: new Date(
                            grupa.created_at
                        ).toLocaleDateString("hr-HR", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }),
                    }));
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped></style>
