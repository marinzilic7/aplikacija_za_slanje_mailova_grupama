<template>
    <div class="container d-flex justify-content-center">
        <div class="mt-5 col-lg-4">
            <select
                class="form-select shadow-lg"
                aria-label="Default select example"
                v-model="group_id"
                @change="selectGroup"
            >
                <option selected>Odaberi grupu</option>
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

    <div class="container mt-5">
        <div class="border p-4 shadow-lg">
            <div>
                <span class="fw-bold">Ime grupe:</span> {{ soloGroup.ime }}
            </div>
            <div class="mt-3">
                <span class="fw-bold">Opis:</span> {{ soloGroup.opis }}
            </div>
            <div class="mt-3">
                <p class="fw-bold">Clanovi grupe</p>
                <ul v-for="member in members" >
                    <li>
                        <p class="text-primary fw-bold">
                            {{ member.user.ime}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            grupe: [],
            group_id: null,
            soloGroup: [],
            members: [],
        };
    },
    created() {
        this.getGroup();

    },
    methods: {
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
                    this.soloGroup = response.data;
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
                    this.members = response.data
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
