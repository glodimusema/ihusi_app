<template>
    <div>

       <v-layout row wrap>
           <v-flex xs12 sm12 md12 lg12>

                <v-card
                    class="mt-4 mx-auto"
                    max-width="400" max-height="600" >
                    <v-sheet
                    class="v-sheet--offset mx-auto"
                    color="cyan"
                    elevation="12"
                    max-width="calc(100% - 32px)"
                    >
                    <br/> 
                    <v-sparkline
                        :labels="linechat.labels"
                        :value="linechat.values"
                        color="white"
                        line-width="2"
                        padding="16"
                    ></v-sparkline>
                    </v-sheet>

                    <v-card-text class="pt-0">
                    <div class="text-h6 font-weight-light mb-2">
                        {{svData.NombreTotalEntreprise > 1 ? svData.NombreTotalEntreprise+' entreprises' : svData.NombreTotalEntreprise+' entreprise'}} !
                    </div>
                    <div class="subheading font-weight-light grey--text">
                        Total d'entreprise dans le système
                    </div>
                    <v-divider class="my-2"></v-divider>
                    <v-icon
                        class="mr-2"
                        small
                    >
                        mdi-clock
                    </v-icon>
                    <span class="text-caption grey--text font-weight-light">{{linechat.picker | formatDate}} Statistique actuelle</span>
                    </v-card-text>
                </v-card>
               
           </v-flex>
       </v-layout>

    </div>
</template>
<script>
export default {
    components:{

    },
    data(){
        return{

            svData: {
                NombreTotalUtilisateur: '',
                NombreTotalPersonne:'',
                NombreMembre:'',
                NombreAdmin:'',

                NombreAgentActif:'',
                NombreAgentInactif:'',
                NombreTotalEntreprise:'',

            },
            linechat:{
                labels: [
                    '12am',
                    '3am',
                    '6am',
                    
                ],
                values: [
                    200,
                    675,
                    410,
                    
                ],
                picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                    .toISOString()
                    .substr(0, 10),
            },
    
        }
    },
    created(){
        this.showLineChartAssuranceAuto();
        this.showCountNotification();
    },
    methods:{
        showLineChartAssuranceAuto() {
            var id_user = this.userData.id;
            this.editOrFetch(
                `${this.apiBaseURL}/pnudShowLineChartAssuranceAuto`
            ).then(({ data }) => {
                var donnees = data.data;

                this.getSvData(this.linechat, data.data[0]);

            });
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
    

}
</script>
