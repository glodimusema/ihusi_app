<template>
    <v-layout>
      <!--  ModelClient  --> 
      <v-flex md12>
        <VenteDetailFactureGroupe ref="VenteDetailFactureGroupe" />
        <VenteDetailPaieFactGroupe ref="VenteDetailPaieFactGroupe" />
        <FactureVente ref="FactureVente" />
        <ModelClient ref="ModelClient" />
  
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Les Factures Groupées <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip>
              </v-card-title>
              <v-card-text>
  
                <v-layout row wrap>
  
                  <v-flex xs12 sm12 md10 lg10>
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
  
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateGroup">
                    </v-text-field>
                  </div>
                </v-flex> 

  
                <v-flex xs12 sm12 md12 lg12>
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
  
                </v-layout>  
  
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="  blue" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
  
  

        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'#'">Les Ventes</router-link>
            </div>
          </v-flex>
        </v-layout>
  
        <br /><br />
        <v-layout>
          <!--   -->
          <v-flex md12>
            <v-layout>
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
            </v-layout>
            <br />
            <v-card>
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">N°FAC</th>
                        <th class="text-left">DateFacture</th>
                        <th class="text-left">Organisation</th>
                        <th class="text-left">Téléphone</th>
                        <th class="text-left">Libellé</th>
                        <th class="text-left">Solde</th>
                        <th class="text-left">Etat</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Created_at</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateGroup | formatDate }}</td>
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
                                  <v-icon>mdi-cards</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Paiement Facture
                                </v-list-item-title>
                              </v-list-item>
  

                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                                </v-list-item-title>
                                </v-list-item>                            
  
                              <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item   
                              link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler la Facture
                                </v-list-item-title>
                              </v-list-item>
  
                            </v-list>
                          </v-menu>
  
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
           
        </v-layout>
      </v-flex>
      <!--   -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import FactureVente from '../Rapports/Finances/FactureVente.vue';
  import ModelClient from './ModelClient.vue';
  import VenteDetailFactureGroupe from './VenteDetailFactureGroupe.vue';
  import VenteDetailPaieFactGroupe from './VenteDetailPaieFactGroupe.vue';
  
  
  export default {
    components:{
      VenteDetailFactureGroupe,
      VenteDetailPaieFactGroupe,
      FactureVente,
      ModelClient
    },
    data() {
      return {
  
        title: "Liste des Ventes",
        dialog: false,
        dialog2: false,
        edit: false,
        loading: false,
        disabled: false,
        svData: {
          id: '',
          refOrganisation: 0,
          dateGroup: "",
          libelle_group: "",
          etat_facture_group : "",
          author: "",
          refUser:0
          
        },
        fetchData: [],
        clientList: [],
        query: ""
  
      }
    },
    created() {     
      this.fetchDataList();
      this.fetchListClient();
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.libelle_group= "Factures groupées";
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_entete_facture_group/${this.svData.id}`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
  
          }
          else {
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.libelle_group= "Factures groupées";
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_entete_facture_group`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
          }
  
        }
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
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_facture_group?page=`);
      },
  
      fetchListClient() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.clientList = donnees;
  
          }
        );
      },    
          payer_cash(code,datavente) {
          // if (this.$refs.form.validate()) {
              this.isLoading(true);
              this.svData.id=code;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.svData.dateGroup = datavente;
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
        printBill(id_facture) {            
            window.open(`${this.apiBaseURL}/fetch_rapport_facture_hebergement_by_numero?id_facture=` + id_facture + "&author=" + this.userData.name);
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
      desactiverData(valeurs,user_created,date_entree,noms) {
        var tables='tvente_entete_vente';
        var user_name=this.userData.name;
        var user_id=this.userData.id;
        var detail_information="Suppression d'une facture du client "+noms+" par l'utilisateur "+user_name+"" ;
  
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.onPageChange();
            }
          );
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
  
      }
  
    },
    filters: {
  
    }
  }
  </script>
  
    
    