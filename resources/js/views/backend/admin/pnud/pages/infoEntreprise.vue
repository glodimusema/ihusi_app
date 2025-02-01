<template>
    
    <div>

        <v-card>
            <v-card-text>
                <div class="my-1">
                    <div><b>Solution de l'entreprise</b></div>
                    <div class="text-grey font-weight-regular" >{{projectDetail.solutionEntreprise}}</div>
                </div>

                <div class="my-1">
                    <div><b>Forme juridique</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.nomForme}}</div>
                </div>
                <div class="my-1">
                    <div><b>Secteur</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.nomSecteur}}</div>
                </div>
                <div class="my-1" v-show="projectDetail.rccm !=null ? true : false">
                    <div><b>RCCM</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.rccm}}</div>
                </div>
                
                 <div class="my-1">
                    <div><b>Pays</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.nomPays}}</div>
                </div>
                 <div class="my-1">
                    <div><b>Province</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.nomProvince}}</div>
                </div>
                <div class="my-1">
                    <div><b>Adresse domicile</b></div>
                    <div class="text-grey font-weight-regular">{{projectDetail.adresse}}</div>
                </div>

                <div class="my-1">
                    <div class="text-center"><b>Investissements</b></div>
                    <div class="text-grey font-weight-regular">
                        <div class="text-grey font-weight-regular">
                            <v-divider></v-divider>
                            
                             <p class="mt-1">

                                 <b class="mr-2">Invsetissement Personnel: </b> <v-badge  color="primary">
                                    <span slot="badge"> {{projectDetail.invPersonnel}} $</span> 
                                   
                                </v-badge>
                            </p>
                            <v-divider></v-divider>
                        </div>
                        <div class="text-grey font-weight-regular">
                            <p class="mt-1">
                                <b>Invsetissement </b> 
                                 <b class="mr-2">Invsetissement Recherché: </b> <v-badge  color="primary">
                                    <span slot="badge"> {{projectDetail.invHub}} $</span> 
                                   
                                </v-badge>
                            </p>
                            <v-divider></v-divider>
                        </div>
                         <div class="text-grey font-weight-regular">
                            <p class="mt-1">
                                
                                <b class="mr-2">Invsetissement Recherché: </b> <v-badge  color="success">
                                    <span slot="badge"> {{projectDetail.invRecherche}} $</span> 
                                   
                                </v-badge>
                            </p>
                            <v-divider></v-divider>
                        </div>
                         <div class="text-grey font-weight-regular">
                            <p class="mt-1">
                                
                                <b class="mr-2">Chrifre d'affaire annuel: </b> <v-badge  color="warning">
                                    <span slot="badge"> {{projectDetail.chiffreAffaire}} $</span> 
                                   
                                </v-badge>
                            </p>
                            <v-divider></v-divider>
                        </div>
                        <div class="my-1">
                            <div><b>Nombre d'employé:</b></div>
                            <div class="text-grey font-weight-regular">{{projectDetail.nbremploye}} Personnes</div>
                        </div>
                    </div>
                </div>
            </v-card-text>
        </v-card>
       
        
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    components:{
    },
    data(){
        return{
            title:"Detail de l'entreprise",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            selection: 0,
        }

    },
    created(){
        this.$store.dispatch("getProjectInfos", this.$route.params.slug);

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
        reserve () {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },

       
        

    },

}
</script>
<style scoped>
.link_pro{
    text-decoration: none;
}
</style>

