<template>
    <div>
        <v-layout row wrap>

            <v-flex xs12 sm6 md6 lg6 
            v-for="item in datas" :key="item.id"
            >
                <div class="mr-1 mb-2">

                    <!-- card item -->
                   
                    <v-card
                        class="mx-auto"
                        max-width="400"
                    >

                    <v-avatar
                        size="230px"
                        color="blue lighten-5"
                        width="100%"
                        tile
                    >
                        <img class="white--text align-end"
                           
                            :src="
                            item.logo == null
                                ? `${baseURL}/images/logo.png`
                                : `${baseURL}/images/` + item.logo
                            " 
                            alt="alt"
                        >
                    </v-avatar>
                       
                        <v-card-title>{{item.nomEntreprise}}</v-card-title>
                        

                        <v-card-subtitle class="pb-0">
                            Nombre d'employés: entre <b>{{item.nbremploye}}</b> employés <br />
                            Secteur d'activité:&nbsp;
                           
                            <v-badge center color="purple">
                                <span slot="badge">
                                    {{item.nomSecteur}}
                                </span> <!--slot can be any component-->
                                
                            </v-badge> 
                        </v-card-subtitle>

                        <v-card-text class="text--primary">
                        <div>Forme juridique: {{item.nomForme}}</div>
                        

                        <div class="my-4 text-subtitle-1">
                            <div><v-icon small class="mr-1">mail</v-icon> Email: <a class="text-subtitle-1 link_pro" :href="'mailto:'+item.emailEntreprise">{{item.emailEntreprise}}</a></div>
                            <div><v-icon small class="mr-1">call</v-icon> N° de téléphone:<a class="text-subtitle-1 link_pro" :href="'tel:'+item.telephoneEntreprise">{{item.telephoneEntreprise}}</a></div>
                            <div><v-icon small class="mr-1">push_pin</v-icon> Adresse domicile:{{item.adresseEntreprise}} </div>
                            <div>
                                <v-icon small class="mr-1">person</v-icon> PDG:{{item.name}}
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a class="text-subtitle-1 link_pro" :href="'tel:'+item.telephone"><v-icon small class="mr-1">call</v-icon>  </a>
                            </div>
                        </div>

                        
                        </v-card-text>

                        <v-card-actions>
                        <v-btn
                            color="orange"
                            text
                            link
                            :to="'/admin/canvas_entreprise_detail/' + item.slug"
                        >
                            Canvas
                        </v-btn>

                        <v-btn
                            color="orange"
                            text
                            link
                            :to="'/admin/swot_entreprise_detail/' + item.slug"
                        >
                            Swot
                        </v-btn>
                         <v-btn
                            color="orange"
                            text
                            link
                            :to="'/admin/entreprise_detail/' + item.slug"
                        >
                            Profil
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    <!-- fin card item -->

                 

                </div>
            </v-flex>
            <!-- fin -->

        </v-layout>
    </div>
</template>
<script>
export default {
    props:["datas"],
    components:{

    },
    data(){
        return{
            title: "liste d'entreprises"
        }
    },
    methods:{

    },
    created(){

    },
}
</script>

