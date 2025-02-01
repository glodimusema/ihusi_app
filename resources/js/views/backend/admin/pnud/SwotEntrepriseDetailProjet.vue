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
                    
                    <Listswot v-on:initialisateur_data="initialisateur_data" />
                    
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
import Listswot from "./pages/Listswot.vue";
export default {
    components:{
        sidePanelVue,
        Addpitch,
        add_busness_plan,
        AddPhoto_entreprise,
        AddVideosEntreprise,
        profileEntreprise,
        ListeCanvas,
        Listswot,
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
       

    },

}
</script>
<style scoped>
</style>

