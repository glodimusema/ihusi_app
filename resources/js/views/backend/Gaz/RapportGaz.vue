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
                            <v-date-picker v-model="dates" range color="  blue"></v-date-picker>
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
                                        <v-btn @click="showDetailDetailVenteByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailProductionByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PRODUCTIONS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementFactureGazByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PAIEMENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> 

                           
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Kit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="lotList"
                                        item-text="nom_lot" item-value="id" dense outlined v-model="svData.refLot" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>

                            <!-- <br> -->

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_Produit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie Produit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieLotList"
                                        item-text="nom_categorie_lot" item-value="id" dense outlined v-model="svData.idCategorie" clearable
                                        chips>
                                        <!-- serviceList -->
                                        </v-autocomplete>
                                    </div>
                                </v-flex>   
                            
                            <br>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez service" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                        item-text="nom_service" item-value="id" dense outlined v-model="svData.idService" clearable
                                        chips>
                                        <!-- showDetailVenteByDate_Service --> 
                                        </v-autocomplete>
                                    </div>
                                </v-flex>  
                                <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelDetailVenteService" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_ServiceByProduit" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- showMouvementProduitByDate_ServiceByProduit -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showMouvementProduitByDate_ServiceByProduit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RELEVE MOUVEMENT/SERVICE/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>                                
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailTransfertByDate_Service_Source" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES TRANSFERTS/SERVICE SOURCE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>                                
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailTransfertByDate_Service_Destination" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES TRANSFERTS/SERVICE RECEPTEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>                          
                            <br>
                            <v-autocomplete label="Etat de la Facture" :items="[
                                { designation: 'Cash' },
                                { designation: 'Compte Maison' },
                                { designation: 'Chambre' },
                                { designation: 'Crédit' },
                                { designation: 'Location' }
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.etat_facture">
                            </v-autocomplete>
                            <!-- <br>showDetailVenteByDate_EtatFactureService -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_EtatFacture" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS VENTES/ETAT FACT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_EtatFactureService" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS VENTES/ETAT FACT/SERVICE.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockService" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/EXCEL.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>                 

                
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import axios from 'axios';
import * as XLSX from 'xlsx';
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Rapport component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",                
                refLot: "", 
                refCategorie:0,
                idCategorie:0,
                idService:0,
                statut : '',
                etat_facture : '',
                type_sortie : ''               
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            categorieList: [],
            fournisseurList: [],
            categorieLotList: [],
            serviceList: [],
            lotList: [],
            organisationList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        //
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
    fetchListFournisseur() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
        ({ data }) => {
          var donnees = data.data;
          this.fournisseurList = donnees;

        }
      );
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
      fetchListCategorieClient() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_categorie_client_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieList = donnees;

          }
        );
      },      
      fetchListCategorieLot() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_gaz_categorie_lot_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieLotList = donnees;
          }
        );
      },      
      fetchListServiceVente() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.serviceList = donnees;
          }
        );
      }
      ,
     
      async GetLot() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_gaz_lot_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.lotList = donnees;
          }
        );

        },
        showDetailProductionByDate_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refLot!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detail_production_date_produit?date1=` + date1+"&date2="+date2+"&refLot="+this.svData.refLot);
                }else
                {
                    this.showError("Veillez selectionner le Produit svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },        
        showDetailProductionByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refLot!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detail_production_date_service_byproduit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idProduit="+this.svData.refLot);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },        
        showDetailVenteByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailvente_dette_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailVenteDetteByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_gaz_detailvente_dette_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailVenteByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_gaz_detailvente_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_EtatFacture() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_date_etat_facture?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_EtatFactureService() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture!="" && this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailvente_date_etat_facture_service?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_gaz_fiche_stock_vente_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },        
        showMouvementProduitByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refLot!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_gaz_fiche_mouvement_produit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&refLot="+this.svData.refLot);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refLot!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailvente_date_produit?date1=` + date1+"&date2="+date2+"&refLot="+this.svData.refLot);
                }else
                {
                    this.showError("Veillez selectionner le Produit svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPaiementFactureGazByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_paiementfacture_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailProductionByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detail_production_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        }, 
        rechargement()
        {
            this.onPageChange();
            
        },
        showDetailTransfertByDate_Service_Source() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailtransfert_date_service_source?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailTransfertByDate_Service_Destination() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailtransfert_date_service_destination?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },

        // =================== PARTIE EXCEL ==========================================================================================

        async exportToExcelFicheStockServiceCategorie() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!=""  && this.svData.idCategorie!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_gaz_fiche_stock_vente_service_bycategorie_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelFicheStockService() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_gaz_fiche_stock_vente_service_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelDetailVenteService() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_pdf_detail_vente_service_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let detail_vente_service = response.data; // Changez const en let

                        console.log('Réponse de API:', detail_vente_service); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(detail_vente_service)) {
                            // C'est déjà un tableau
                        } else if (detail_vente_service.data && Array.isArray(detail_vente_service.data)) {
                            detail_vente_service = detail_vente_service.data; // Accéder au tableau
                        } else if (detail_vente_service.products && Array.isArray(detail_vente_service.products)) {
                            detail_vente_service = detail_vente_service.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(detail_vente_service);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'detail_vente_service');

                        XLSX.writeFile(workbook, 'RapportDetailVenteService.xlsx');                               

                    }
                    else
                    {
                        this.showError("Veillez selectionner le service svp");
                    } 

                        
                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        showDetailVenteByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refLot!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailvente_date_service_byproduit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idProduit="+this.svData.refLot);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_gaz_rapport_detailvente_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        }

       


    },
    created() {
        this.GetLot();
        this.fetchListCategorieClient();
        this.fetchListCategorieLot();
        this.fetchListServiceVente();
        this.fetchListFournisseur();
        
        this.showDate=true;
    },
};
</script>