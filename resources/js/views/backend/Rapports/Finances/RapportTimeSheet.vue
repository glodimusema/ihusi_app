<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
                <!-- fin modal -->

                <!-- bande -->
                <v-layout>
                    <v-flex md1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn :loading="loading" fab @click="onPageChange">
                                        <v-icon>autorenew</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Initialiser</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range  color="  blue"
                            ></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                          
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                    <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="mdi-map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                        item-value="id" dense outlined v-model="svData.affectation_id" chips clearable>
                                    </v-autocomplete>
                                    </div>
                                </v-flex>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="TimeSheetByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> IMPRIMER TIME SHEET
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>


                            <br>

                           </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <!-- <v-flex md3>
                       
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Organisation'" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="organisationList"
                                item-text="nom_org" item-value="nom_org" dense outlined v-model="svData.organisationAbonne"
                                chips clearable >
                            </v-autocomplete>
                        </div>
                    </v-flex> -->

                    <v-flex md1>
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="showDate = !showDate" fab color="  blue" dark>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Voir les Rapports</span>
                        </v-tooltip>
                    </v-flex>
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",                
                affectation_id:0                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            agentList: [],
            filterValue:'',
            dates:[],
            showDate:false, 
        };
    },
    computed: {
        
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        
        onPageChange() {           
           
        },      
      fetchListAgent() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_affectation_agent`).then(
          ({ data }) => {
            var donnees = data.data;
            this.agentList = donnees;
          }
        );
      },
        TimeSheetByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.affectation_id!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_time_sheet_date?date1=` + date1+"&date2="+date2+"&affectation_id="+this.svData.affectation_id);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {        
        this.fetchListAgent();
        this.showDate=true;
    },
};
</script>