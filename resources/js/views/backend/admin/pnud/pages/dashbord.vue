<template>
    <v-container>


        <v-row>
            <v-col cols="12" sm="8">
                <v-card class="mx-4 rounded-xl pa-4" color="grey lighten-3" flat>
                    <v-container>
                        <v-flex>
                            <v-card class="ma-5 text-center mt-12" shaped elevation="10">
                                <v-avatar class="mt-n7" size="60" elevation="10">
                                    <img 
                                        :src="
                                            svData.avatar == null
                                            ? `${baseURL}/images/avatar.png`
                                            : `${baseURL}/images/` + svData.avatar
                                        " 
                                    />
                                </v-avatar>
                                <v-card-title class="layout justify-center">{{svData.name}}</v-card-title>
                                <v-card-subtitle class="layout justify-center">{{svData.adresse}} </v-card-subtitle>
                                <v-list>
                                    <v-list-item>
                                        <v-list-item-title class="cyan--text text--darken-1">Email</v-list-item-title>
                                        <v-list-item-title class="cyan--text text--darken-1">Téléphone</v-list-item-title>
                                        <v-list-item-title class="cyan--text text--darken-1">Sexe</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item class="mt-n5">
                                        <v-list-item-subtitle>{{svData.email}}</v-list-item-subtitle>
                                        <v-list-item-subtitle>{{svData.telephone}}</v-list-item-subtitle>
                                        <v-list-item-subtitle>{{svData.sexe}}</v-list-item-subtitle>
                                    </v-list-item>
                                </v-list>
                            </v-card>
                        </v-flex>
                      
                    </v-container>

                </v-card>
               <tugUser />
                <v-card class="mx-4 rounded-xl pa-6 mt-2" color="grey lighten-3" flat>
                    <v-toolbar flat color="rgba(0,0,0,0)" dense class="mt-n5">
                        <v-toolbar-title>Toutes les Editions</v-toolbar-title>
                        <v-spacer></v-spacer>

                        <v-btn-toggle v-model="text" small dense background-color="primary" dark>
                            <v-btn value="weekly">
                                Semaine
                            </v-btn>

                            <v-btn value="monthly">
                                Mois
                            </v-btn>

                        </v-btn-toggle>
                    </v-toolbar>

                    <statBlog v-bind:typechart="stat.typechart2" />

                   <!-- <statMontantEntrantYeba /> -->
                </v-card>
            </v-col>
            <v-col cols="12" sm="4">
                <Menuleft />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

import Menuleft from './menufelt.vue'
import tugUser from './tugUser.vue';
import statMontantEntrantYeba from '../statMontantEntrantYeba.vue';
import statBlog from './statBlog.vue' 
export default {
    components:{
        Menuleft,
        tugUser,
        statMontantEntrantYeba,
        statBlog
    },
    name: 'Home',
    data: () => ({
        
        text: 'weekly',
        width: 2,
        radius: 10,
        padding: 8,
        lineCap: 'round',
        value: [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0],
        fill: false,
        type: 'trend',
        autoLineWidth: false,
        svData: {
            id: "",
            name: "",
            email: "",
            password: "",
            // photo: "",
            sexe: "",
            telephone: "",
            adresse: "",
            avatar: "",
        },

        stat: {
            options: null,
            series: null,
            typechart1: "line",
            typechart2: "area",
            typechart3: "bar",
            typechart4: "donut",
        },
        
        
        
    }),
    computed: {
        theme() {
            return this.$vuetify.theme.dark ? "dark" : "light";
        }
    },
    mounted () {
      this.arrayEvents = [...Array(6)].map(() => {
        const day = Math.floor(Math.random() * 30)
        const d = new Date()
        d.setDate(day)
        return d.toISOString().substr(0, 10)
      })
    },
    created(){
        this.showUserConnected();
    },
    methods:{
        showUserConnected(){
            var id = this.userData.id;
            this.editOrFetch(`${this.apiBaseURL}/showUser/${id}`).then(({ data }) => {
                
                this.getSvData(this.svData, data.data[0]);
            });
        }
       

    },
   

}
</script>

<style scoped>
</style>