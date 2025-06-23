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
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            
                            <br>  

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowDepenseByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES DEPENSES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> 
                            
                            <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowPaiementFactureByDate" block color="blue" dark>
                                                <v-icon>print</v-icon> PAIEMENTS DES FACTURES CLIENTS
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>

                                <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowPaiementCommandeFactureByDate" block color="blue" dark>
                                            <v-icon>print</v-icon> PAIEMENTS DES FACTURES FOURNISSEURS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <div class="mr-1">
                                <v-select label="Etat de Facture" :items="[
                                    { designation: 'Cash' },
                                    { designation: 'Crédit' },
                                    { designation: 'Compte Maison' },
                                    // { designation: 'Chambre' },                           
                                    // { designation: 'Location' }
                                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                    item-text="designation" item-value="designation" v-model="svData.etat_facture">
                                </v-select>
                            </div>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowPaiementEtatFactureByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES PAIEMENT/CREDIT/CASH
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez les rubriques des Depenses" prepend-inner-icon="mdi-map" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="rubSortieList" item-text="designation" item-value="id"
                                    outlined v-model="svData.refRubSortie">
                                </v-autocomplete >
                            </div> 

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowDepenseRubriqueByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES DEPENSES/RUBRIQUE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez les rubriques des Recettes" prepend-inner-icon="mdi-map" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="rubEntreeList" item-text="designation" item-value="id"
                                    outlined v-model="svData.refRubEntree">
                                </v-autocomplete >
                            </div>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowRecetteRubriqueByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT DES RECETTES/RUBRIQUE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>



                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation" item-value="designation"
                                dense outlined v-model="svData.nom_mode" chips clearable @change="get_Banque(svData.nom_mode)">
                                </v-autocomplete>
                            </div>
                            </v-flex>
                            
                            <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque" item-value="id"
                                dense outlined v-model="svData.refCompte" chips clearable>
                                </v-autocomplete>
                            </div>
                            </v-flex>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowDepenseBanqueByDate" block color="  blue" dark>
                                                <v-icon>print</v-icon> RAPPORT DES DEPENSES/BANQUE
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>
                            <br>
                            
                            <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowRessourceBanqueByDate" block color="  blue" dark>
                                                <v-icon>print</v-icon> RAPPORT DES RECETTES/BANQUE
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>                                                        

                                <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowPaiementFactureByDateandBanque" block color="  blue" dark>
                                                <v-icon>print</v-icon> PAIEMENTS DES FACTURES/BANQUE/CAISSE
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>
                                <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowPaiementFactureCommandeByDateandBanque" block color="  blue" dark>
                                                <v-icon>print</v-icon> PAIE FACTURES FOURNISSEURS/BANQUE/CAISSE
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
                            <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="BanqueList"
                                item-text="nom_banque" item-value="id" dense outlined v-model="svData.refCompte"
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
                            <span>Ajouter une opération</span>
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
                idEntreprise: "",
                id_tarif: "",
                id_agent:[],
                remise: 0,
                ceo: "",
                selectionAgent:[],
                refCompte: "", 
                refTrajectoire:0,
                refTypetarification:0,
                refBanque:0,
                nom_mode:"",

                refRubEntree: 0,
                refRubSortie: 0,
                etat_facture : "",
                
            },
            stataData: {
                entrepriseList: [],
                agentList: [],
                

            },
            fetchData: null,
            BanqueList: [],
            ModeList: [],
            titreModal: "",
            typetarifList: [],    
            trajectoireList: [],
            compteList: [],
            rubSortieList:[],
            rubEntreeList:[],
            filterValue:'',
            dates:[],
            showDate:true,
            
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
            this.svData.id_agent=[];
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
            if (this.dates.length >= 1) {
                this.showCardByDate();
            } else {
                this.fetch_data(`${this.apiBaseURL}/fetch_abonnement_carte?page=`);                
            }
           
        },
  
        fetchListTypeTarif() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_typetarif`).then(
            ({ data }) => {
                var donnees = data.data;
                this.typetarifList = donnees;
            }
            );
        },
        
        fetchListTrajectoire() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_trajectoire`).then(
            ({ data }) => {
                var donnees = data.data;
                this.trajectoireList = donnees;
            }
            );
        },  
        fetchListCompte() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
            ({ data }) => {
                var donnees = data.data;
                this.compteList = donnees;
            }
            );
        },  
        fetchListRubriqueSortie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte_sortie`).then(
            ({ data }) => {
                var donnees = data.data;
                this.rubSortieList = donnees;

            }
            );
        },  
        fetchListRubriqueEntree() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_compte_entree`).then(
            ({ data }) => {
                var donnees = data.data;
                this.rubEntreeList = donnees;

            }
            );
        },
        PrintshowRecetteRubriqueByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_sortie_compte_date_rubrique?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refRubEntree);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                } 
        },
        PrintshowDepenseRubriqueByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_sortie_compte_date_rubrique?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refRubSortie);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowPaiementEtatFactureByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_date_etat_facture?date1=` + date1 + "&date2=" + date2+"&etat_facture="+this.svData.etat_facture);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowDepenseBanqueByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_sortie_banque_date?date1=` + date1 + "&date2=" + date2+"&refBanque="+this.svData.refCompte);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowRessourceBanqueByDate() {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_banque_date?date1=` + date1 + "&date2=" + date2+"&refBanque="+this.svData.refCompte);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowDepenseByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {
                    window.open(`${this.apiBaseURL}/fetch_rapport_sortie_compte_date?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refCompte);
                    //window.open(`${this.apiBaseURL}/fetch_rapport_depense_date?date1=` + date1+"&date2="+date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
            // } else {
            //     this.showError("Cette action est reservée uniquement aux administrateurs du système!!!");
            // }          
           //fetch_rapport_paie_date
        },
        PrintshowRecetteByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_entree_compte_date?date1=` + date1 + "&date2=" + date2+"&refCompte="+this.svData.refCompte);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowPaiementFactureByDateandBanque() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_date_banque?date1=` + date1 + "&date2=" + date2+"&refBanque="+this.svData.refCompte);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowPaiementFactureByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_date?date1=` + date1 + "&date2=" + date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowPaiementFactureCommandeByDate() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_commande_date?date1=` + date1 + "&date2=" + date2);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },
        PrintshowPaiementFactureCommandeByDateandBanque() {

            // if (this.userData.id_role == 1 || this.userData.id_role == 2) {
                var date1 = this.dates[0];
                var date2 = this.dates[1];
                if (date1 <= date2) {                             
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_commande_date_banque?date1=` + date1 + "&date2=" + date2+"&refBanque="+this.svData.refCompte);
                } else {
                    this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }
        },

       
        showDetailModalLot(codeR) {
        
            if (codeR !=null) {
                
            } else {
                this.showError("Aucune action  n'a été faite!!! prière de selectionner un lot de commande");
            }
    
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },
      async get_mode_Paiement() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.ModeList = chart;
              } else {
                  this.ModeList = [];
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
      async get_Banque(nom_mode) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.BanqueList = chart;
              } else {
                  this.BanqueList = [];
              }
              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      },

       


    },
    created() {
        this.fetchListTrajectoire();
        this.fetchListTypeTarif();
        this.fetchListCompte();  
        this.get_mode_Paiement();    
        this.fetchListRubriqueSortie();
        this.fetchListRubriqueEntree();  
    },
};
</script>