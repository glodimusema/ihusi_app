<template>
    <div>
       <v-container grid-list-xs>
           <v-layout row wrap>
                <v-flex xs12 sm12 md12 lg12 >
                    
                    <v-btn color="blue" text link 
                    :to="
                    userData.id_role==1 || userData.id_role==3 ? 
                    '/admin/entreprise_detail/'+ projectDetail.slug: '/user/entreprise_detail/' + projectDetail.slug"><v-icon>arrow_back</v-icon> 
                    Retourner  </v-btn>
                    <br>
                    
                    <ListeCanvas v-on:initialisateur_data="initialisateur_data" />
                    
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
import ListeCanvas from "./pages/listeCanvas.vue";
export default {
    components:{
        sidePanelVue,
        Addpitch,
        add_busness_plan,
        AddPhoto_entreprise,
        AddVideosEntreprise,
        profileEntreprise,
        ListeCanvas,
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
        initialisateur_data(){
            this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        },
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

