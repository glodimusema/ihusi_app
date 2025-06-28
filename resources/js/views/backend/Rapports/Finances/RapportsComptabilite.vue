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
                                range color="  blue"
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

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_livre_caisse" block color="  blue" dark>
                                            <v-icon>print</v-icon> LIVRE DE CAISSE/JOUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_livre_banque" block color="  blue" dark>
                                            <v-icon>print</v-icon> LIVRE DES BANQUES/JOUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_rapport_bilan" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT BILAN
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_rapport_journal_caisse" block color="  blue" dark>
                                            <v-icon>print</v-icon> JOURNAL DES OPERATIONS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <br> -->

                            <!-- <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList"
                                item-text="nom_compte" item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                                @change="get_souscompte_for_compte(svData.refCompte)">
                                </v-autocomplete>
                            </div>
                            </v-flex>
                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Sous-Compte" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                                item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte" clearable
                                chips>
                                </v-autocomplete>
                            </div>
                            </v-flex> -->

                            <!-- <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_rapport_detailfacture_date_compte_cash" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES CASH
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="show_fetch_rapport_detailfacture_date_compte_credit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES CREDITS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->
                            <br>
                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <v-flex md3>
                       
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="banqueList"
                                item-text="nom_banque" item-value="id" dense outlined v-model="svData.refTresorerie"
                                chips clearable >
                            </v-autocomplete>
                        </div>
                    </v-flex>

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
                refUniteProduction: "", 
                refDepartement:0,
                refMedecin:0,
                author:"",

                refCompte: "",
                refSousCompte: "",
                refSscompte: "",
                refBanque:0,
                dateOperation:''                
            },
            stataData: {
                CompteList: [],
                SousCompteList: [],
                SSousCompteList: []
            },
            fetchData: null,            
            titreModal: "",
            banqueList: [],
            caissierList: [],
            departementList: [],
            uniteproductionList: [],
            medecinList: [],
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
        show_fetch_rapport_detailfacture_date_compte_cash() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refSousCompte !="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_date_compte_cash?date1=` + date1+"&date2="+date2+"&refSousCompte="+this.svData.refSousCompte);
                }
                else
                {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }                          
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_detailfacture_date_compte_credit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refSousCompte !="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_date_compte_credit?date1=` + date1+"&date2="+date2+"&refSousCompte="+this.svData.refSousCompte);
                }
                else
                {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }                          
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_journal_caisse() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refTresorerie !="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_journal_caisse?date1=` + date1+"&date2="+date2+"&refTresorerie="+this.svData.refTresorerie);
                }
                else
                {
                    this.showError("Veillez selectionner le compte de tresorerie svp");
                }                          
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_rapport_bilan() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_bilan?date1=` + date1+"&date2="+date2);                         
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        show_fetch_livre_caisse() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/pdf_livre_caisse_par_banque_caisse?date1=` + date1+"&date2="+date2+"&refBanque="+this.svData.refTresorerie);                         
               
            } else {
               this.showError("Veillez sélectionner la date");
            }
        },
        show_fetch_livre_banque() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/pdf_livre_caisse_par_banque_caisse?date1=` + date1+"&date2="+date2+"&refBanque="+this.svData.refTresorerie);                         
               
            } else {
               this.showError("Veillez sélectionner la date");
            }
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },
        fetchListCompte() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
            ({ data }) => {
            var donnees = data.data;
            this.stataData.CompteList = donnees;

            }
        );
        },
    //fultrage de donnees
        async get_souscompte_for_compte(refCompte) {
        this.isLoading(true);
        await axios
            .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
            .then((res) => {
            var chart = res.data.data;

            if (chart) {
                this.stataData.SousCompteList = chart;
            } else {
                this.stataData.SousCompteList = [];
            }

            this.isLoading(false);

            //   console.log(this.stataData.car_optionList);
            })
            .catch((err) => {
            this.errMsg();
            this.makeFalse();
            reject(err);
            });
        },

        //fultrage de donnees
        async get_sscompte_for_souscompte(refSousCompte) {
        this.isLoading(true);
        await axios
            .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
            .then((res) => {
            var chart = res.data.data;

            if (chart) {
                this.stataData.SSousCompteList = chart;
            } else {
                this.stataData.SSousCompteList = [];
            }

            this.isLoading(false);

            //   console.log(this.stataData.car_optionList);
            })
            .catch((err) => {
            this.errMsg();
            this.makeFalse();
            reject(err);
            });
        },      
      fetchListBanque() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tconf_banque_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.banqueList = donnees;

          }
        );
      },

       


    },
    created() { 
        this.fetchListCompte();
        this.fetchListBanque();
        this.showDate=true;
    },
};
</script>