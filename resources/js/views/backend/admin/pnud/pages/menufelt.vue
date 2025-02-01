<template>
    <div >
       
       <v-card class=" rounded-xl pa-4" color="grey lighten-3" flat>
            <v-app-bar color="rgba(0,0,0,0)" tile>
                <v-btn tile fab small color="orange lighten-4" elevation="0">
                    <v-icon color="black">rss_feed</v-icon>
                </v-btn>
                <strong class="subtitle black--text ml-2">
                    Articles publiés <span class="caption"><br>{{svData.NombreBlog}}</span>
                </strong>
                <v-spacer></v-spacer>
                <v-icon color="grey" class="ml-2">fas fa-chevron-circle-right</v-icon>
            </v-app-bar>
            <v-app-bar color="rgba(0,0,0,0)" tile class="mt-3">
                <v-btn  tile fab small color="green lighten-4" elevation="0">
                    <v-icon color="black">file_download</v-icon>

                </v-btn>
                <strong class="subtitle black--text ml-2">
                    <a 
                    :href="
                        `${baseURL}/documents/default/winraredev.zip`
                    "
                    
                    class="text-black"
                    style="text-decoration: none; color: black;"
                    >
                        Télécharger Winrar
                        
                    </a>
                    <span class="caption"><br>pour compresser  les doccuments</span>
                </strong>
                <v-spacer></v-spacer>
                <v-icon color="grey" class="ml-2">fas fa-chevron-circle-right</v-icon>
            </v-app-bar>
            <!-- <v-app-bar color="rgba(0,0,0,0)" tile class=mt-3>
                <v-btn tile fab small color="blue lighten-4" elevation="0" @click.stop="showPDGNavigation()">
                    <v-icon color="black">groups</v-icon>
                </v-btn>
                <strong class="subtitle black--text ml-2">
                    Les chefs d'entreprises  <span class="caption"><br>{{svData.NombreTotalEntreprise}}</span>
                </strong>
                <v-spacer></v-spacer>
                <v-icon color="grey" class="ml-2">fas fa-chevron-circle-right</v-icon>
            </v-app-bar> -->
            <v-toolbar flat color="rgba(0,0,0,0)" dense class="mt-1">
                <v-toolbar-title>Date</v-toolbar-title>

                <v-spacer></v-spacer>
                <span class="grey--text">Voir le calendrier</span>
            </v-toolbar>
            <div class="px-7 mb-5 col-md-12">
                <v-row row wrap>
                    <!-- <div>
                        <v-date-picker v-model="date2"  class="" width="270"
                        :event-color="date => date[9] % 2 ? 'red' : 'yellow'"
                        :events="functionEvents">
                        </v-date-picker>
                    </div> -->

                    <v-flex xs12 sm12 md12 lg12>
                        <!-- <statBlog v-bind:typechart="stat.typechart3" />    -->
                        
                        <v-date-picker v-model="date2"  class="" width="100%"
                        :event-color="date => date[9] % 2 ? 'red' : 'yellow'"
                        :events="functionEvents">
                        </v-date-picker>
                    </v-flex>
                    
                </v-row>

            </div>
            <v-card  class="rounded-xl mx-4 pa-10" flat>
                <v-toolbar flat color="rgba(0,0,0,0)" dense>
                    <v-toolbar-title class="grey--text">Mot de la</v-toolbar-title>

                    <v-spacer></v-spacer>
                    <span class="grey--text">semaine</span>
                </v-toolbar>
                <v-divider></v-divider>
                
                <div class="my-1">
                    <div v-for="(item, index) in listWeek" :key="index">

                        <strong>{{item.message}} </strong>
                    </div>
                    
                    
                </div>
            </v-card>
        </v-card>

        <ListeCeo v-bind:drawer="drawer" />
        
        
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
import statBlog from './statBlog.vue' 
export default {
    components:{
        ListeCeo,
        statBlog,
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
            slides: [
                { src: 'https://cdn.vuetifyjs.com/images/lists/1.jpg' },
                { src: 'https://cdn.vuetifyjs.com/images/lists/2.jpg' },
                { src: 'https://cdn.vuetifyjs.com/images/lists/3.jpg' },
                { src: 'https://cdn.vuetifyjs.com/images/lists/4.jpg' },
                { src: 'https://cdn.vuetifyjs.com/images/lists/5.jpg' },



            ],
            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },
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
           
            this.editOrFetch(`${this.apiBaseURL}/fetch_latest_week/`).then(
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

<style scoped>



</style>

