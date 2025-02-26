<template>
    
    <v-layout>
        <v-flex md12>

            <VenteDetailFactureGroupe ref="VenteDetailFactureGroupe" />
            <VenteDetailPaieFactGroupe ref="VenteDetailPaieFactGroupe" />
            <FactureVente ref="FactureVente" />
            <ModelClient ref="ModelClient" />

            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>   

                <v-flex xs12 sm12 md4 lg4>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez l'Organisation" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="noms" item-value="id"
                      outlined dense v-model="svData.refOrganisation">
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs1 sm1 md1 lg1>
                      <div class="mr-1">
                          <v-tooltip bottom color="black">
                              <template v-slot:activator="{ on, attrs }">
                                  <span v-bind="attrs" v-on="on">
                                      <v-btn @click="fetchListClient" color="primary" :loading="loading"
                                          dark x-small fab depressed>
                                          <v-icon dark>refresh</v-icon>
                                      </v-btn>
                                  </span>
                              </template>
                              <span>Recharger la liste</span>
                          </v-tooltip>
  
                      </div>
                </v-flex>
                <v-flex xs1 sm1 md1 lg1>
                      <div class="mr-1">
                          <v-tooltip bottom color="black">
                              <template v-slot:activator="{ on, attrs }">
                                  <span v-bind="attrs" v-on="on">
                                      <v-btn @click="
                                          showClient()
                                          " fab x-small color="primary" dark>
                                          <v-icon>add</v-icon>
                                      </v-btn>
                                  </span>
                              </template>
                              <span>Ajouter une Organisation</span>
                          </v-tooltip>
                      </div>
                </v-flex>
  
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Facture" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateGroup">
                    </v-text-field>
                  </div>
                </v-flex> 

  
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                        <v-autocomplete label="Etat de la Facture" :items="[
                        { designation: 'Cash' },
                        { designation: 'Compte Maison' },
                        { designation: 'Chambre' },
                        { designation: 'Crédit' },
                        { designation: 'Location' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.etat_facture_group">
                    </v-autocomplete>
                  </div>
                </v-flex>   
                 
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field label="Libellé" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle_group">
                    </v-text-field>
                  </div>
                </v-flex> 

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>Reservation</th>
                        <th>Facture</th>
                        <th>Payé</th>
                        <th>Reste</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">

                        <td class="long-cell">
                            <v-autocomplete v-model="item.id_reservation" :items="chambreList"
                                label="Selectionnez la Reservation" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designationReservation" item-value="id" @change="updateChambre(index)"
                                ></v-autocomplete>                            
                        </td>
                        <td>{{ item.montantFacture }}$</td>
                        <td>{{ item.montantPaie }}$</td>
                        <td>{{ item.montantReste }}$</td>
                        <td>
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <div style="text-align: right; margin-top: 20px;"><strong>Total Facture : {{ svData.totalInvoice }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>Total Payé : {{ svData.totalPaie }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>Total Reste : {{ svData.totalReste }} $</strong></div>

            <table>
                <tr>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                        <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>
                    </td>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate2" color="success">Payer Cash</v-btn></div>  
                        <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>                     
                    </td>
                </tr>
            </table>

            

            <v-flex md12>
                <!-- <v-layout>
                    <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                        rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                    </v-flex>
                    <v-flex md5>


                    </v-flex>
                    <v-flex md1>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog = true" fab color="  blue" dark>
                            <v-icon>add</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Ajouter un Produit</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Action</th>
                            <th class="text-left">N°FAC</th>
                            <th class="text-left">dateGroup</th>
                            <!-- <th class="text-left">Service</th> -->
                            <th class="text-left">Client</th>
                            <th class="text-left">Téléphone</th>
                            <th class="text-left">Libellé</th>
                            <th class="text-left">Solde</th>
                            <th class="text-left">Etat</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Created_at</th>  
                            <th class="text-left">Facture</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                            <td>

                            <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense width="">                               

                                <v-list-item link @click="showDetailVente(item.id, item.noms)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Facture
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="payer_cash(item.id, item.dateGroup)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cards</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Payer Cash
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showVenteDetailPaieFactGroupe(item.id, item.noms,item.totalFacture,item.totalPaie,item.RestePaie)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Paiement Facture
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                                </v-list-item-title>
                                </v-list-item>                               


                            </v-list>
                            </v-menu>
                            </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.dateGroup | formatDate }}</td>
                            <!-- <td>{{ item.nom_service }}</td> -->
                            <td>{{ item.noms }}</td>
                            <td>{{ item.contact }}</td>
                            <td>{{ item.libelle_group }}</td>
                            <td>{{ item.RestePaie }}$</td>
                            <td>{{ item.etat_facture_group }}</td>
                            <td>{{ item.author }}</td>
                            <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                            </td>  
                            <td>
                                <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="printBill(item.id)" fab small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer Bon</span>
                                    </v-tooltip>
                            </td>                         
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                    <hr />

                    <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList"></v-pagination>
                    </v-card-text>
                </v-card>
                </v-flex>

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import FactureVente from '../Rapports/Finances/FactureVente.vue';
import VenteDetailFactureGroupe from './VenteDetailFactureGroupe.vue';
import VenteDetailPaieFactGroupe from './VenteDetailPaieFactGroupe.vue';
import ModelClient from './ModelClient.vue'

export default {
    components:{
    VenteDetailFactureGroupe,
    VenteDetailPaieFactGroupe,
    FactureVente,
    ModelClient
  },
    data() {
        return {

            title: "Liste des Requisitions",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refOrganisation: 0,
                dateGroup: "",
                libelle_group: "",
                etat_facture_group : "",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalPaie:0,
                totalReste:0,
                indexEncours:0,

                detailData: [{
                    refEnteteGroup: 0,
                    id_vente: 0,
                    id_reservation : 0,
                    active : '',  
                    nomClient: '',                  
                    montantFacture: 0,
                    montantPaie:0,
                    montantReste:0,                    
                }],                
            },
            fetchData: [],
            chambreList: [],
            clientList: [],
            CmdList: [],  
      

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListClient();
        this.fetchListChambre();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                refEnteteGroup: 0,
                id_vente: 0,
                id_reservation : 0,
                active : '',  
                nomClient: '',                  
                montantFacture: 0,
                montantPaie:0,
                montantReste:0
            });
            this.fetchListChambre();
        },
       refreshData()
        {
            this.fetchListClient();
        },
        printBill(id_facture) {            
            window.open(`${this.apiBaseURL}/fetch_rapport_facture_hebergement_by_numero?id_facture=` + id_facture + "&author=" + this.userData.name);
        },
        // printBill(id_facture) {            
        //     window.open(`${this.apiBaseURL}/fetch_rapport_facture_hebergement_by_numero?id_facture=` + id_facture + "&author=" + this.userData.name);
        // },
        async updateChambre(index)
            {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_reservation_chambre/${this.svData.detailData[index].id_reservation}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].montantFacture = donnees[0].totalFacture; // Update price per unit
                        this.svData.detailData[index].montantPaie = donnees[0].totalPaie; // Dummy price
                        this.svData.detailData[index].montantReste= donnees[0].RestePaie;                       
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        updatePT(index) {
            this.updateChambre(index);
            this.svData.detailData[index].montantFacture = this.svData.detailData[index].montantFacture; // Dummy price
            this.svData.detailData[index].montantPaie= this.svData.detailData[index].montantPaie;
            this.svData.detailData[index].montantReste= this.svData.detailData[index].montantReste;

            // this.updateTotal(index);
        },
        updateTotal() {          

            this.svData.totalInvoice = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.montantFacture;
            }, 0);

            this.svData.totalPaie = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.montantPaie;
            }, 0);

            this.svData.totalReste = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.montantReste;
            }, 0);           
        },
        removeItem(index) {
            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].montantFacture;
            this.svData.totalPaie = this.svData.totalPaie - this.svData.detailData[index].montantPaie;
            this.svData.totalReste = this.svData.totalReste - this.svData.detailData[index].montantReste;
            this.indexEncours = this.indexEncours - index;

            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                refEnteteGroup: 0,
                id_vente: 0,
                id_reservation : 0,
                active : '',  
                nomClient: '',                  
                montantFacture: 0,
                montantPaie:0,
                montantReste:0
            }];
            this.$refs.form.reset(); // Reset the form validation state            
            this.fetchListChambre();
        },
        validate() {


            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement
                if (this.$refs.form.validate()) {
                this.isLoading(true);
                this.svData.author = this.userData.name;
                    this.svData.refUser = this.userData.id;
                    this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_vente_globale_facture_groupe_hotel`,
                    JSON.stringify(this.svData)
                    )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.dialog = false;
                        this.resetObj(this.svData);
                        this.fetchDataList();
                        this.resetForm();
                        this.svData.libelle="Les Factures Groupées";
                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });
        
                }
                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }



        },
        validate2() {

            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement
                if (this.$refs.form.validate()) {
                    this.isLoading(true);
                    this.svData.author = this.userData.name;
                        this.svData.refUser = this.userData.id;
                        this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_vente_globale_facture_groupe_hotel_cash`,
                        JSON.stringify(this.svData)
                        )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                            this.resetForm();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
            
                }
                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }



        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_facture_group_encours?page=`);
        },
        fetchListClient() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.clientList = donnees;
                }
            );
        },
        fetchListChambre() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_hotel_reservation_search`).then(
            ({ data }) => {
                var donnees = data.data;
                    this.chambreList = donnees;
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_facture_group/${id}`).then(
            ({ data }) => {

            this.titleComponent = "modification des informations";

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
            }
        );
        },
        deleteData(id) {
        this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_facture_group/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailVente(refEnteteGroup, name) {

        if (refEnteteGroup != '') { 

            this.$refs.VenteDetailFactureGroupe.$data.etatModal = true;
            this.$refs.VenteDetailFactureGroupe.$data.refEnteteGroup = refEnteteGroup;
            this.$refs.VenteDetailFactureGroupe.$data.svData.refEnteteGroup = refEnteteGroup;
            this.$refs.VenteDetailFactureGroupe.fetchDataList();
            this.$refs.VenteDetailFactureGroupe.fetchListChambre();
            this.$refs.VenteDetailFactureGroupe.fetchListVente();
            this.fetchDataList();

            this.$refs.VenteDetailFactureGroupe.$data.titleComponent =
            "Detail Vente pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }
        // 

        },
        showFacture(refEnteteGroup, name,ServiceData) {

        if (refEnteteGroup != '') {

            this.$refs.FactureVente.$data.dialog2 = true;
            this.$refs.FactureVente.$data.refEnteteSortie = refEnteteGroup;
            this.$refs.FactureVente.$data.ServiceData = ServiceData;
            this.$refs.FactureVente.showModel(refEnteteGroup);
            this.fetchDataList();

            this.$refs.FactureVente.$data.titleComponent =
            "La Facture pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },
        showVenteDetailPaieFactGroupe(refEnteteVenteGroup, name,totalFacture,totalPaie,RestePaie) {

        if (refEnteteVenteGroup != '') {

            this.$refs.VenteDetailPaieFactGroupe.$data.etatModal = true;
            this.$refs.VenteDetailPaieFactGroupe.$data.refEnteteVenteGroup = refEnteteVenteGroup;
            this.$refs.VenteDetailPaieFactGroupe.$data.totalFacture = totalFacture;
            this.$refs.VenteDetailPaieFactGroupe.$data.totalPaie = totalPaie;
            this.$refs.VenteDetailPaieFactGroupe.$data.RestePaie = RestePaie;
            this.$refs.VenteDetailPaieFactGroupe.$data.svData.refEnteteVenteGroup = refEnteteVenteGroup;
            this.$refs.VenteDetailPaieFactGroupe.fetchDataList();
            this.$refs.VenteDetailPaieFactGroupe.get_mode_Paiement();
            this.$refs.VenteDetailPaieFactGroupe.getInfoFacture();
            this.fetchDataList();

            this.$refs.VenteDetailPaieFactGroupe.$data.titleComponent =
            "Detail Paiement pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },    
        payer_cash(code,dateGroup) 
        {
            this.isLoading(true);
            this.svData.id=code;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.dateGroup = dateGroup;
            this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_cash_facture_groupe_vente/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;                
                this.resetObj(this.svData);
                this.fetchDataList();
                })
                .catch((err) => {
                this.svErr(), this.isLoading(false);
                });
        },
        showClient() {
        this.$refs.ModelClient.$data.etatModal = true;
        this.$refs.ModelClient.testTitle();
        this.$refs.ModelClient.onPageChange();
        this.$refs.ModelClient.fetchListCompte();
        this.fetchListClient();

        this.$refs.ModelClient.$data.titleComponentss =
            "Un nouveau Client";

        },


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 150px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>