<template>
    <v-row justify="center">
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- container -->
  
          <v-card-title class="primary">
            {{ titleComponent }} <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="etatModal = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <!-- layout -->
  
            <div>
  
              <v-layout>
  
                <v-flex md12>
                  <FactureVente ref="FactureVente" />
                  <VenteDetailPaieFactGroupe ref="VenteDetailPaieFactGroupe" />
  
                  <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Entrée <v-spacer></v-spacer>
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

                            <v-autocomplete label="Selectionnez la Resérvation de la Chambre" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="chambreList" item-text="designationReservation"
                                item-value="id" dense outlined v-model="svData.id_reservation" chips clearable>
                            </v-autocomplete>

                            <v-autocomplete label="Selectionnez la Vente de la Chambre" prepend-inner-icon="mdi-map"
                                :items="venteList" item-text="designationVente"
                                item-value="id" dense outlined v-model="svData.id_vente" chips clearable>
                            </v-autocomplete>  
  
                          <v-autocomplete label="Active" :items="[
                            { designation: 'OUI' }, 
                            { designation: 'NON' },                                       
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.active">
                          </v-autocomplete>
  

  
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
  
                  <br /><br />
                  <v-layout>
                    <!--   -->
                    <v-flex md12>
                      <v-layout>
                        <v-flex md6>
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                            solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                            clearable></v-text-field>
                        </v-flex>
                        <v-flex md5>
                          <div>
                            <!-- {{ this.don }} -->
                          </div>
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
                            <span>Ajouter le Detail</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                      <br />
                      <v-card>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <!-- uniteVente -->
                                <tr>
                                  <th class="text-left">Organisation</th>
                                  <th class="text-left">Client</th>
                                  <th class="text-left">DateFacture</th>
                                  <th class="text-left">N° B.F</th>
                                  <th class="text-left">Total($)</th>
                                  <th class="text-left">Solde($)</th>
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.nomsClient }}</td>
                                  <td>{{ item.dateGroup }}</td>
                                  <td>{{ item.refEnteteGroup }}</td>
                                  <td>{{ item.totalFacture }}$</td>
                                  <td>{{ item.RestePaie }}$</td>
                                  <td>{{ item.taux }}</td>
                                  <td>
  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>
  
                                      <v-list dense width="">
  
                                        <v-list-item link
                                          @click="showVenteDetailPaieFactGroupe(item.refEnteteGroup, item.noms, item.totalFacture, item.totalPaie, item.RestePaie)">
                                          <v-list-item-icon>
                                            <v-icon>mdi-cart-outline</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Paiement Facture
                                          </v-list-item-title>
                                        </v-list-item>  

                                        <v-list-item link @click="printBill(item.refEnteteGroup)">
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
  
                                        <v-list-item link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="  red">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Suppression
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
  
              </v-layout>
  
            </div>
  
  
            <!-- fin -->
          </v-card-text>
  
          <!-- container -->
        </v-card>
      </v-dialog>
    </v-row>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import FactureVente from '../Rapports/Finances/FactureVente.vue';
  import VenteDetailPaieFactGroupe from './VenteDetailPaieFactGroupe.vue';
  export default {
    components: {
      FactureVente,
      VenteDetailPaieFactGroupe
    },
    data() {
      return {  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        refEnteteGroup: 0,
        svData: {
          id: '',
          refEnteteGroup: 0,
          id_vente: 0,
          id_reservation : 0,
          active : '',    
          author: "",
          refUser: 0
        },
        fetchData: [],
        produitList: [],
        uniteList: [],
        deviseList: [],
        venteList: [],
        chambreList: [],
        don: [],
        query: "",
  
        inserer: '',
        modifier: '',
        supprimer: '',
        chargement: ''
  
      }
    },
    created() {
  
      // this.fetchDataList();
      // this.fetchListChambre();
      // this.fetchListVente();
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          // if(this.svData.qteVente <= this.svData.qteDisponible)
          // {
  
          if (this.edit) {
            this.svData.refEnteteGroup = this.refEnteteGroup;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_detail_facture_groupe/${this.svData.id}`,
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
  
            this.svData.refEnteteGroup = this.refEnteteGroup;
                this.svData.author = this.userData.name;
                this.svData.refUser = this.userData.id;
  
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_detail_facture_groupe`,
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
        printBill(id_facture) {            
            window.open(`${this.apiBaseURL}/fetch_rapport_facture_hebergement_by_numero?id_facture=` + id_facture + "&author=" + this.userData.name);
        },
        fetchListChambre() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_hotel_reservation_search`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.chambreList = donnees;
                }
            );
        },
        fetchListVente() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_data_entete_vente_search`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.venteList = donnees;
                }
            );
        },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_detail_facture_groupe/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_vente_detail_facture_groupe/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_detail_facture_groupe/${this.refEnteteGroup}?page=`);
      },
      showVenteDetailPaieFactGroupe(refEnteteGroup, name, totalFacture, totalPaie, RestePaie) {
  
        if (refEnteteGroup != '') {
  
          this.$refs.VenteDetailPaieFactGroupe.$data.etatModal = true;
          this.$refs.VenteDetailPaieFactGroupe.$data.refEnteteGroup = refEnteteGroup;
          this.$refs.VenteDetailPaieFactGroupe.$data.totalFacture = totalFacture;
          this.$refs.VenteDetailPaieFactGroupe.$data.totalPaie = totalPaie;
          this.$refs.VenteDetailPaieFactGroupe.$data.RestePaie = RestePaie;
          this.$refs.VenteDetailPaieFactGroupe.$data.svData.refEnteteGroup = refEnteteGroup;
          this.$refs.VenteDetailPaieFactGroupe.fetchDataList();
          this.$refs.VenteDetailPaieFactGroupe.get_mode_Paiement();
          this.$refs.VenteDetailPaieFactGroupe.getInfoFacture();
          this.fetchDataList();
  
          this.$refs.VenteDetailPaieFactGroupe.$data.titleComponent =
            "Detail Vente pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      }
  
  
    },
    filters: {
  
    }
  }
  </script>
    
    