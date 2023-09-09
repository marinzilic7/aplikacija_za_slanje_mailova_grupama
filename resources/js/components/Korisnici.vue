<template>
    <div class="container">
        <table class="table border mt-5 shadow-lg">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ime</th>
                    <th scope="col">Prezime</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nalog napravljen</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <th>{{ user.id  }}</th>
                    <th>{{ user.ime }}</th>
                    <th>{{ user.prezime  }}</th>
                    <th>{{ user.email  }}</th>
                    <th>{{ user.created_at  }}</th>

                </tr>

            </tbody>
        </table>
    </div>
</template>

<script>

export default{
    data(){
        return{
            users:[]
        }
    },
    created(){
        this.getUser();
    },
    methods:{
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
    }
}

</script>

<style lang="scss" scoped></style>
