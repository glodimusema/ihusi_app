<template>
    <div>
        <v-toolbar flat color="rgba(0,0,0,0)" dense class="mt-n1">
            <v-toolbar-title>#Personnages</v-toolbar-title>
            <v-spacer></v-spacer>
            <span class="grey--text">Voir Tous</span>
        </v-toolbar>
        <v-row class="mt-n5" v-for="(item, index) in listWeek" :key="index">
            
            <v-col cols="12" sm="4" xs="12">
           
                <v-card class="rounded-xl ml-4" color="grey lighten-3" flat>
                    <v-card-title>
                        <span class="text-h6 font-weight-light">Utilisateur normal</span>
                    </v-card-title>

                    <v-card-text class="">
                        Voici {{item.usersMember.original.NombreUsers > 0  ? 'les' : 'le'}} 
                        {{item.usersCeo.original.NombreUsers}}  <br> 
                        {{item.usersMember.original.NombreUsers > 0  ? 'Retenus' : 'Retenu'}} ayant accès au système
                    </v-card-text>

                    <v-card-actions class="mt-n7">
                        <v-list-item class="">
                            <div color="grey darken-3">

                                <v-avatar class="ml-n3" size="30"
                                 v-for="item2 in item.usersCeo.original.data"
                                 :key="item2.id"
                                 >
                                    <img 
                                    :src="
                                        item2.avatar == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item2.avatar
                                    "
                                     alt="John">
                                </v-avatar>
                                
                                <v-avatar class="ml-n3" color="black" size="30">
                                    <span class="caption white--text">
                                        {{item.usersCeo.original.NombreUsers}}
                                    </span>
                                </v-avatar>
                            </div>



                            <v-row align="center" justify="end">

                                <v-icon class="mr-1" small>
                                    wash
                                </v-icon>
                                <span class="caption"> {{item.usersCeo.original.NombreUsers}}</span>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>

            <v-col cols="12" sm="4" xs="12">
           
                <v-card class="rounded-xl ml-4" color="grey lighten-3" flat>
                    <v-card-title>
                        <span class="text-h6 font-weight-light">Membres</span>
                    </v-card-title>

                    <v-card-text class="">
                        Voici {{item.usersMember.original.NombreUsers > 0  ? 'les' : 'le'}} 
                        {{item.usersMember.original.NombreUsers}}  <br> 
                        {{item.usersMember.original.NombreUsers > 0  ? 'Membres' : 'Membre'}}  ayant accès  au système
                    </v-card-text>

                    <v-card-actions class="mt-n7">
                        <v-list-item class="">
                            <div color="grey darken-3">

                                <v-avatar class="ml-n3" size="30"
                                 v-for="item2 in item.usersMember.original.data"
                                 :key="item2.id"
                                 >
                                    <img 
                                    :src="
                                        item2.avatar == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item2.avatar
                                    "
                                     alt="John">
                                </v-avatar>
                                
                                <v-avatar class="ml-n3" color="black" size="30">
                                    <span class="caption white--text">
                                        {{item.usersMember.original.NombreUsers}}
                                    </span>
                                </v-avatar>
                            </div>



                            <v-row align="center" justify="end">

                                <v-icon class="mr-1" small>
                                    wash
                                </v-icon>
                                <span class="caption"> {{item.usersMember.original.NombreUsers}}</span>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>

            <v-col cols="12" sm="4" xs="12" >
           
                <v-card class="rounded-xl ml-4" color="grey lighten-3" flat>
                    <v-card-title>
                        <span class="text-h6 font-weight-light">Administrateur </span>
                    </v-card-title>

                    <v-card-text class="">
                        Voici {{item.usersAdmin.original.NombreUsers > 0  ? 'les' : 'le'}} {{item.usersAdmin.original.NombreUsers}}  <br> 
                        {{item.usersAdmin.original.NombreUsers > 0  ? 'Administrateurs' : 'Administrateur'}}  ayant accès au système
                    </v-card-text>

                    <v-card-actions class="mt-n7">
                        <v-list-item class="">
                            <div color="grey darken-3">

                                <v-avatar class="ml-n3" size="30"
                                 v-for="item2 in item.usersAdmin.original.data"
                                 :key="item2.id"
                                 >
                                    <img 
                                    :src="
                                        item2.avatar == null
                                        ? `${baseURL}/images/avatar.png`
                                        : `${baseURL}/images/` + item2.avatar
                                    "
                                     alt="John">
                                </v-avatar>
                                
                                <v-avatar class="ml-n3" color="black" size="30">
                                    <span class="caption white--text">
                                        {{item.usersAdmin.original.NombreUsers}}
                                    </span>
                                </v-avatar>
                            </div>



                            <v-row align="center" justify="end">

                                <v-icon class="mr-1" small>
                                    wash
                                </v-icon>
                                <span class="caption"> {{item.usersAdmin.original.NombreUsers}}</span>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
            
        </v-row>
    </div>
</template>
<script>
const gradients = [
    ['#222'],
    ['#42b3f4'],
    ['red', 'orange', 'yellow'],
    ['purple', 'violet'],
    ['#00c6ff', '#F0F', '#FF0'],
    ['#f72047', '#ffd200', '#1feaea'],
]
import { mapGetters, mapActions } from "vuex";
import ListeCeo from "./ListeCeo.vue";
export default {
    components:{
        ListeCeo,
    },
    data(){
        return{
            title: "Les documents",
            list: [],
            listWeek: [],
            dtext: 'weekly',
            width: 2,
            radius: 10,
            padding: 8,
            lineCap: 'round',
            value: [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0],
            fill: false,
            type: 'trend',
            autoLineWidth: false,
            

            svData: {
                NombreTotalUtilisateur: '',
                NombreTotalPersonne:'',
                NombreMembre:'',
                NombreAdmin:'',

                NombreAgentActif:'',
                NombreAgentInactif:'',
                NombreTotalEntreprise:'',
                NombreBlog:'',
                
            },

            sheet: false,

            drawer: null,
            gradient: gradients[5],
            gradientDirection: 'top',
            gradients,
            fill: false,
            type: 'trend',
            arrayEvents: null,
            date2: new Date().toISOString().substr(0, 10),

        }
    },
    computed: {
        ...mapGetters([
            "projectDetail",
            "isloading",
            "paysList",
            "provinceList",
            "user2List",
            "formeJuridiqueList",
            "secteurList",
            "ListeEdition",
            "ListeNBREmploye",

            
        ]),
    },
    methods:{
        ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),

        functionEvents (date) {
            const [,, day] = date.split('-')
            if ([12, 17, 28].includes(parseInt(day, 10))) return true
            if ([1, 19, 22].includes(parseInt(day, 10))) return ['red', '#00f']
            return false
        },

        getInfoDocumentTOdownload(){
            var slug = this.$route.params.slug;
            this.editOrFetch(`${this.apiBaseURL}/get_project_infos_document/${slug}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.list = donnees;
     
                }
            );
        },
        getInfoLatestWeek(){
           
            this.editOrFetch(`${this.apiBaseURL}/fetch_latest_users/`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.listWeek = donnees;
     
                }
            );
        },

        showPDGNavigation()
        {
            this.drawer = !this.drawer;
        },
        showCountNotification() {
            var id_user = this.userData.id;
            this.editOrFetch(
                `${this.apiBaseURL}/showCountDashbord`
            ).then(({ data }) => {
                var donnees = data.data;

                this.getSvData(this.svData, data.data[0]);

            });
        },


    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        this.getInfoDocumentTOdownload();
        this.getInfoLatestWeek();
        this.showCountNotification();
    },
}
</script>
