<template>

    <div class="registration">
        <div
            class="container d-flex flex-column align-items-center justify-content-center"
        >
            <h4 class="mt-5">Dodaj grupu</h4>
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
                    <textarea
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
                    Dodaj grupu
                </button>
                <button
                    type="button"
                    class="btn btn-secondary w-100 mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#memberModal"
                    data-bs-whatever="@getbootstrap"
                >
                    Dodaj clana grupe
                </button>
                <div
                    class="modal fade"
                    id="memberModal"
                    tabindex="-1"
                    aria-labelledby="exampleModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Dodaj clanove u grupu
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="dodajClana()" method="POST">
                                    <input type="hidden" v-model="this.POST" />
                                    <input
                                        type="hidden"
                                        name=""
                                        v-model="this.csrfToken"
                                    />
                                    <div class="mb-3">
                                        <label
                                            for="recipient-name"
                                            class="col-form-label"
                                            >Odaberi grupu:</label
                                        >
                                        <select
                                            class="form-select"
                                            aria-label="Default select example"
                                            v-model="clan.group_id"
                                        >
                                            <option selected>
                                                Odaberi grupu
                                            </option>
                                            <option
                                                v-for="grupa in grupe"
                                                :value="grupa.id"
                                                :key="grupa.id"
                                            >
                                                {{ grupa.ime }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="message-text"
                                            class="col-form-label"
                                            >Odaberi korisnika:</label
                                        >
                                        <select
                                            class="form-select"
                                            aria-label="Default select example"
                                            v-model="clan.user_id"
                                        >
                                            <option selected>
                                                Odaberi korisnika
                                            </option>
                                            <option
                                                v-for="user in users"
                                                :value="user.id"
                                                :key="user.id"
                                            >
                                                {{ user.ime }}
                                            </option>
                                        </select>
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Dodaj clana
                                    </button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary w-100"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                                <div v-if="postoji" class=" alert alert-danger w-100 text-center fw-bold" ><p>Korisnik je vec clan grupe!</p></div>
                                <div v-if="nePostoji" class=" alert alert-success w-100 text-center fw-bold" ><p>Clan dodan u grupu!</p></div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="container">
            <h4 class="mt-5 ms-4">Sve grupe</h4>
            <table
                class="table table-bordered border-secondary border mt-5 shadow-lg"
            >
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Korisnik</th>
                        <th scope="col">Ime</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Kreirana</th>
                        <th scope="col">Izbrisi</th>
                        <th scope="col">Uredi</th>
                        <th scope="col">Dodaj</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="grupa in grupe">
                        <th>{{ grupa.id }}</th>
                        <th>{{ grupa.user.ime }}</th>
                        <th>{{ grupa.ime }}</th>
                        <th>{{ grupa.opis }}</th>
                        <th>{{ grupa.created_at }}</th>
                        <th>
                            <button
                                class="btn btn-sm btn-danger"
                                @click="izbrisiGrupu(grupa.id)"
                            >
                                Izbrisi
                            </button>
                        </th>
                        <th>
                            <button
                                type="button"
                                class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                :data-bs-target="'#exampleModal' + grupa.id"
                                data-bs-whatever="@getbootstrap"
                                @click="updateGrupa(grupa)"
                            >
                                Uredi
                            </button>

                            <div
                                class="modal fade"
                                :id="'exampleModal' + grupa.id"
                                tabindex="-1"
                                :aria-labelledby="
                                    'exampleModalLabel' + grupa.id
                                "
                                aria-hidden="true"
                            >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5
                                                class="modal-title"
                                                :id="'#exampleModal' + grupa.id"
                                            >
                                                Uredi grupu
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            ></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                @submit.prevent="
                                                    urediGrupu(grupa.id)
                                                "
                                            >
                                                <input
                                                    type="hidden"
                                                    v-model="this.POST"
                                                />
                                                <input
                                                    type="hidden"
                                                    name=""
                                                    v-model="this.csrfToken"
                                                />
                                                <div class="mb-3">
                                                    <label
                                                        for="recipient-name"
                                                        class="col-form-label"
                                                        >Ime grupe:</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="recipient-name"
                                                        v-model="data.ime"
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        for="message-text"
                                                        class="col-form-label"
                                                        >Opis grupe:</label
                                                    >
                                                    <textarea
                                                        class="form-control"
                                                        id="message-text"
                                                        v-model="data.opis"
                                                    ></textarea>
                                                </div>
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary w-100"
                                                >
                                                    Uredi
                                                </button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button
                                                type="submit"
                                                class="btn btn-secondary w-100"
                                                data-bs-dismiss="modal"
                                            >
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th>
                            <button class="btn btn-sm btn-primary">
                                Dodaj
                            </button>
                        </th>
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
            groupId: null,
            clan: {
                user_id: "",
                group_id: "",
            },
            users: [],
            postoji:false,
            poruka:'',
            nePostoji:false,
        };
    },
    mounted() {
        this.fetchCsrfToken();
        this.getGroup();
        this.getUser();
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

        izbrisiGrupu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/izbrisiGrupu/${id}`)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.getGroup();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },

        updateGrupa(grupa) {
            this.groupId = grupa.id;
            this.data.ime = grupa.ime;
            this.data.opis = grupa.opis;
            $("#exampleModal" + grupa.id).modal("show");
        },

        urediGrupu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/urediGrupu/${id}`, {
                    ime: this.data.ime,
                    opis: this.data.opis,
                })
                .then((response) => {
                    this.poruka = response.data.poruka;

                    const grupa = response.data.grupa;
                    const index = this.grupe.findIndex(
                        (grupa) => grupa.id === this.groupId
                    );
                    if (index !== -1) {
                        this.grupe[index].ime = grupa.ime;
                        this.grupe[index].opis = grupa.opis;
                    }
                });
            $("#exampleModal" + this.groupId).modal("hide");
        },
        getUser() {
            axios
                .get("/getUser")
                .then((response) => {
                    this.users = response.data.map((user) => ({
                        ...user,
                        created_at: new Date(
                            user.created_at
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

        dodajClana() {
            const Podaci = {
                user_id: this.clan.user_id,
                group_id: this.clan.group_id,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajClana", Podaci)
                .then((response) => {
                    this.poruka = response.data.poruka
                    if(this.poruka == 'Korisnik je clan grupe'){
                        this.postoji = true
                    }else if(this.poruka == 'Uspjesno'){
                        this.postoji = false
                        this.nePostoji = true
                        setTimeout(() => {
                            $("#memberModal").modal("hide");
                            this.nePostoji = false
                        }, 2000);
                    }

                    this.clan = {
                        user_id: "",
                        group_id: "",
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
    },
};
</script>

<style scoped></style>
