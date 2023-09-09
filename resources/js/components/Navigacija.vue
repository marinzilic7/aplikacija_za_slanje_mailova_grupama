<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <nav
        class="navbar navbar-expand-lg bg-primary col-sm-12 col-md-12 shadow-lg"
    >
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">App</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link text-light text-decoration-none"
                            to="/"
                            >Pocetna</RouterLink
                        >
                    </li>
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link text-light text-decoration-none"
                            to="/predmeti"
                            >Predmeti</RouterLink
                        >
                    </li>
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link text-light text-decoration-none"
                            to="/korisnici"
                            >Korisnici</RouterLink
                        >
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <div class="row">
                        <li
                            v-if="!isLoggedIn"
                            class="nav-item class col-12 d-flex flex-column col-sm-12 flex-sm-column justify-content-sm-center d-md-flex col-md-12 flex-md-row logItems"
                        >
                            <RouterLink
                                class="text-light pe-3 text-decoration-none"
                                to="/prijava"
                                >Prijava</RouterLink
                            >
                            <RouterLink
                                class="text-light text-decoration-none"
                                to="/registracija"
                                >Registracija</RouterLink
                            >
                        </li>
                        <li v-else>
                            <div class="btn-group dropstart">
                                <button
                                    class="btn dropdown-toggle text-light nav-link"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ loggedInUser.ime }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button
                                            @click="logOut()"
                                            class="dropdown-item p-0 text-center"
                                            type="button"
                                        >
                                            Logout
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <RouterView />
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isLoggedIn: false,
        };
    },
    computed: {
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        this.checkLoginStatus();
    },
    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    this.loggedInUser = response.data;

                    this.isLoggedIn = true;
                    console.log(this.isLoggedIn);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logOut() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.loggedInUser = null;
                    this.$store.dispatch("logout");
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped></style>
