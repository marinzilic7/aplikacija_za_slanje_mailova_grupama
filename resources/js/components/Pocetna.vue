<template>
    <div class="container d-flex justify-content-center">
        <div class="mt-5 col-lg-4">
            <h4>Odaberi grupu</h4>
            <select
                class="form-select shadow-lg"
                aria-label="Default select example"
                v-model="group_id"
                @change="selectGroup"
            >
                <option
                    v-for="grupa in grupe"
                    :value="grupa.id"
                    :key="grupa.id"
                >
                    {{ grupa.ime }}
                </option>
            </select>
        </div>
    </div>
    <br />
    <br />

    <div class="container mt-5" v-if="prikazi">
        <div class="border p-4 shadow-lg">
            <div>
                <span class="fw-bold">Ime grupe:</span> {{ soloGroup.ime }}
            </div>
            <div class="mt-3">
                <span class="fw-bold">Opis:</span> {{ soloGroup.opis }}
            </div>
            <div class="mt-3">
                <p class="fw-bold">Clanovi grupe</p>
                <ul v-for="member in members">
                    <li>
                        <p class="text-primary fw-bold">
                            {{ member.user.ime }}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="mt-3">
                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    data-bs-whatever="@getbootstrap"
                >
                    Objavi
                </button>
                <div
                    class="modal fade"
                    id="exampleModal"
                    tabindex="-1"
                    aria-labelledby="exampleModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Objavi post
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="addPost()">
                                    <input type="hidden" v-model="this.POST" />
                                    <input
                                        type="hidden"
                                        name=""
                                        v-model="this.csrfToken"
                                    />
                                    <div class="mb-3">
                                        <label for="">Grupa</label>
                                    </div>
                                    <select
                                        disabled
                                        name=""
                                        id=""
                                        v-model="soloGroup.id"
                                    >
                                        <option :value="soloGroup.id">
                                            {{ soloGroup.ime }}
                                        </option>
                                    </select>
                                    <div>
                                        <label
                                            for="recipient-name"
                                            class="col-form-label"
                                            >Tema objave:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="recipient-name"
                                            v-model="post.tema"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="message-text"
                                            class="col-form-label"
                                            >Sadrzaj objave:</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="message-text"
                                            v-model="post.sadrzaj"
                                        ></textarea>
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Objavi
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4>Objave</h4>
        </div>
        <div
            v-for="objava in objave"
            :key="objava.id"
            class="border p-4 shadow-lg mt-4"
        >
            <p class="fw-bold">Tema - {{ objava.tema }}</p>
            <div class="d-flex justify-content-between">
                <p>
                    <span class="fw-bold">Napisao/la</span> -
                    {{ objava.user.ime }}
                </p>
                <p>{{ formattedDate(objava.created_at) }}</p>
            </div>
            <p>
                <span class="fw-bold">Sadrzaj:</span> <br />
                {{ objava.sadrzaj }}
            </p>
        </div>
    </div>
</template>

<script>
import { format } from "date-fns";
import { hr } from "date-fns/locale";

export default {
    data() {
        return {
            grupe: [],
            group_id: null,
            soloGroup: [],
            members: [],
            prikazi: false,
            post: {
                tema: "",
                sadrzaj: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            objave: [],
        };
    },
    created() {
        this.getGroup();
        this.fetchCsrfToken();
        this.getPost();
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

        formattedDate(created_at) {
            // Funkcija za formatiranje datuma
            return format(new Date(created_at), "d. MMMM yyyy. HH:mm", {
                locale: hr,
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
        selectGroup() {
            axios
                .get(`/getGroup/${this.group_id}`)
                .then((response) => {
                    this.getMember();
                    this.getPost();
                    this.soloGroup = response.data;
                    this.prikazi = true;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getMember() {
            axios
                .get(`/getMember/${this.group_id}`)
                .then((response) => {
                    this.members = response.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        addPost() {
            const Data = {
                group_id: this.soloGroup.id,
                tema: this.post.tema,
                sadrzaj: this.post.sadrzaj,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/addPost", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.getPost();
                    this.post = {
                        group_id: "",
                        tema: "",
                        sadrzaj: "",
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
        getPost() {
            axios
                .get(`/getPost/${this.group_id}`)
                .then((response) => {
                    this.objave = response.data;

                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
