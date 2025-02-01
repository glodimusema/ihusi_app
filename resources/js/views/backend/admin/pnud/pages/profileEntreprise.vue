<template>
    <div>

        <v-card>

            <br /><br />
            <v-toolbar flat>
            <v-progress-circular v-if="loading" indeterminate></v-progress-circular>
            <v-layout row wrap v-else>
                <v-flex  sm12 md6 lg6>
                    <userImage :width="80" :height="80" :image="projectDetail.avatar" />
                    <br />
                    <v-icon small>person</v-icon> Ceo : {{ projectDetail.name }}<br />

                   
    
                </v-flex>
                <v-flex xs12 sm12 lg6>
                    <v-spacer></v-spacer>
                    <v-icon small>mail</v-icon> Email: <a :href="'mailto:' + projectDetail.email">{{ projectDetail.email }}</a>
                    <br><v-icon small>man</v-icon>Sexe: {{ projectDetail.sexe }}<br />
                    <v-icon small>call</v-icon> Appel <a :href="'tel:' + projectDetail.telephone"> {{ projectDetail.telephone }}</a>
                </v-flex>

            </v-layout>
            
            </v-toolbar>

            <v-tabs orizontal loading color="blue accent-3" class="my-6">
            
                <v-tab>
                    <v-icon left>badge </v-icon>
                    Profil complet
                </v-tab>

                <v-tab>
                    <v-icon left>image </v-icon>
                    Les images 
                </v-tab>
                <v-tab>
                    <v-icon left>video_camera_front </v-icon>
                    Les vidéos 
                </v-tab>

                <!-- <v-tab @click.prevent="showCanvasModal(projectDetail.id)">
                    <v-icon left>candlestick_chart </v-icon>
                    Canavas de l'entreprise
                </v-tab> -->

                <v-tab>
                    <v-icon left>candlestick_chart </v-icon>
                    Canavas de l'entreprise
                </v-tab>

                <v-tab>
                    <v-icon left>meeting_room </v-icon>
                    Swot de l'entreprise
                </v-tab>


                <!-- item 1 -->
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <infoEntreprise  /> 
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- fin -->

                <!-- item 1 -->
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <listeImage />
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- fin -->

                <!-- item 1 -->
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                    <listeVideo />
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- fin -->

                <!-- item 1 -->
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <ListeCanvas v-on:initialisateur_data="initialisateur_data" />
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- fin -->

                <!-- item 1 -->
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <Listswot v-on:initialisateur_data="initialisateur_data" />
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <!-- fin -->

                


            </v-tabs>
        </v-card>

         <v-layout row wrap>
            <v-flex xs12 sm12 lg12 md12>
                 <Canvas v-on:initialisateur_data="initialisateur_data"  ref="Canvas" /> 
            </v-flex>
        </v-layout>

    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import infoEntreprise from "./infoEntreprise.vue";
import listeImage from "./listeImage.vue";
import listeVideo from "./listeVideo.vue";
import userImage from "../../../../component/userImage.vue";
import ListeCanvas from "./listeCanvas.vue";
import Listswot from "./Listswot.vue";

import Canvas from "./canvas.vue";
export default {
    components:{
        infoEntreprise,
        listeImage,
        listeVideo,
        userImage,
        Canvas,
        ListeCanvas,
        Listswot,
    },
    data(){
        return{
            title:"Profile de l'entreprise",
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

        initialisateur_data(){
            this.$store.dispatch("getProjectInfos", this.$route.params.slug);
        },
        showCanvasModal(id) {
            this.$refs.Canvas.$data.dialog = true;
            this.$refs.Canvas.$data.svData.ceo = id;
            
        },

        

    },

}
</script>
<style scoped>
.link_pro{
    text-decoration: none;
}
</style>
