<template>
    <div>
       <v-container grid-list-xs>
           <v-layout row wrap>
                <v-flex xs12 sm12 md4 lg4 >
                    <v-layout row wrap>

                       

                        <v-flex xs12 md12 lg12 sm12>
                                <div class="mr-1">
                                     <sidePanelVue />
                                </div>
                           
                        </v-flex>


                        <v-flex xs12 md12 lg12 sm12>

                            <v-layout row wrap>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <Addpitch v-on:initialisateur="initialisateur"  ref="Addpitch" /> 
                                        <add_busness_plan v-on:initialisateur="initialisateur"  ref="add_busness_plan" /> 
                                        <AddPhoto_entreprise v-on:initialisateur="initialisateur"  
                                        ref="AddPhoto_entreprise" />
                                        <AddVideosEntreprise v-on:initialisateur="initialisateur"  
                                        ref="AddVideosEntreprise" />
                                    </div>
                                </v-flex>
                            </v-layout>
                            <v-fab-transition 
                            v-if="userData.id_role == 1 || projectDetail.ceo == this.userData.id ? true : false">

                                <v-btn
                                    
                                    color="primary"
                                    dark
                                    absolute
                                    bottom
                                    right
                                    fab
                                >
                                   

                                    <v-menu
                                        bottom
                                        rounded
                                        offset-y
                                        transition="scale-transition"
                                    >
                                        <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                            <v-icon>more_vert</v-icon>
                                        </v-btn>
                                        </template>

                                        <v-list dense width="">
                                            <v-list-item
                                                link
                                                @click="showPhotoModal(projectDetail.id)"
                                            >
                                                <v-list-item-icon>
                                                <v-icon>upcoming</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: -20px"
                                                >Pich du projet</v-list-item-title
                                                >
                                            </v-list-item>


                                            <v-list-item
                                                
                                                link
                                                @click="showBusnessPlanModal(projectDetail.id)"
                                                
                                            >
                                                <v-list-item-icon>
                                                    <v-icon>create_new_folder</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: -20px"
                                                >Document complet</v-list-item-title
                                                >
                                            </v-list-item>

                                            <v-list-item
                                                
                                                link
                                                @click="showPhotoEntrepriseModal(projectDetail.id)"
                                                
                                            >
                                                <v-list-item-icon>
                                                    <v-icon>image</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: -20px"
                                                >Images de l'entreprise</v-list-item-title
                                                >
                                            </v-list-item>

                                            <v-list-item
                                                
                                                link
                                                @click="showVideoEntrepriseModal(projectDetail.id)"
                                                
                                            >
                                                <v-list-item-icon>
                                                    <v-icon>videocam</v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-title style="margin-left: -20px"
                                                >Vidéos de l'entreprise</v-list-item-title
                                                >
                                            </v-list-item>

                                        
                                        </v-list>
                                    </v-menu>



                                </v-btn> 
                            </v-fab-transition>
                        </v-flex>
                        
                    </v-layout>
                    
                </v-flex>
                <v-flex xs12 sm12 md8 lg8 >
                    <v-layout row wrap>
                        <v-flex xs12 md12 lg12 sm12>
                            <div class="mr-1">
                                <profileEntreprise />
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
                
            </v-layout>
       </v-container>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import sidePanelVue from "./pages/sidePanel.vue";
import Addpitch from "./pages/Addpitch.vue";
import add_busness_plan from "./pages/Addbusnessplan.vue";
import AddPhoto_entreprise from "./pages/AddPhoto.vue";
import AddVideosEntreprise from "./pages/AddVideosEntreprise.vue";
import profileEntreprise from "./pages/profileEntreprise.vue";
export default {
    components:{
        sidePanelVue,
        Addpitch,
        add_busness_plan,
        AddPhoto_entreprise,
        AddVideosEntreprise,
        profileEntreprise,
    },
    data(){
        return{
            title:"Detail de l'entreprise",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            selection: 1,
        }

    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        this.test();

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

        test(){
            console.log("id_entreprise: "+this.projectDetail.id);
        },

        reserve () {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },

        showPhotoModal(id) {
            this.$refs.Addpitch.$data.dialog = true;
            this.$refs.Addpitch.$data.svData.agentId = id;
            
        },
        showBusnessPlanModal(id) {
            this.$refs.add_busness_plan.$data.dialog = true;
            this.$refs.add_busness_plan.$data.svData.agentId = id;
            
        },
        showPhotoEntrepriseModal(id) {
            this.$refs.AddPhoto_entreprise.$data.dialog = true;
            this.$refs.AddPhoto_entreprise.$data.svData.agentId = id;
            
        },
        showVideoEntrepriseModal(id) {
            this.$refs.AddVideosEntreprise.$data.dialog = true;
            this.$refs.AddVideosEntreprise.$data.svData.ceo = id;
            
        },

        

        

        initialisateur(){
            this.$store.dispatch("getProjectInfos", this.$route.params.slug);
            // alert("boom!");
        },

        detailEntreprise(){
            var slug = this.$route.params.slug;
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_entreprise/${slug}`).then(
                ({ data }) => {
                var donnees = data.data;

                this.initialisation();

                donnees.map((item) => {
                    this.titleComponent = "modification de " + item.nomEntreprise;
                });

                this.getSvData(this.svData, data.data[0]);
                this.edit = true;
                this.dialog = true;
                }
            );

        }

    },

}
</script>
<style scoped>
</style>

