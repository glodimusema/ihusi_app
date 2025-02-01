<template>
    <v-layout>
      <!--  FactureVente -->
      <v-flex md12>
        <SalonDetailVente ref="SalonDetailVente" />
        <SalonPaiement ref="SalonPaiement" />
        <FactureVente ref="FactureVente" />
  
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Les Ventes <v-spacer></v-spacer>
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
  
                <v-select label="Selectionnez le Client" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="noms" item-value="id"
                  outlined dense v-model="svData.refClient">
                </v-select>
  
                <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateVente">
                </v-text-field>
  
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
                        <th class="text-left">DateVente</th>
                        <th class="text-left">Client</th>
                        <th class="text-left">Téléphone</th>
                        <th class="text-left">Libellé</th>
                        <th class="text-left">Solde</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateVente | formatDate }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.contact }}</td>
                        <td>{{ item.libelle }}</td>
                        <td>{{ item.RestePaie }}$</td>
                        <td>{{ item.author }}</td>
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
                                <v-list-item-title style="margin-left: -20px">Detail Vente
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="showSalonPaiement(item.id, item.noms,item.totalFacture,item.totalPaie,item.RestePaie)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Paiement Facture
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="showFacture(item.id,item.noms,'Salon')">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item   link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="red">delete</v-icon>
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
      <!--   -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import FactureVente from '../Rapports/Finances/FactureVente.vue';
  import SalonDetailVente from './SalonDetailVente.vue';
  import SalonPaiement from './SalonPaiement.vue';
  
  
  export default {
    components:{
      SalonDetailVente,
      SalonPaiement,
      FactureVente
    },
    data() {
      return {
  
        title: "Liste des Ventes",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  
        //'id','refClient','dateVente','libelle','author'
  
        svData: {
          id: '',
          refClient: 0,
          dateVente: "",
          libelle: "",
          author: ""
        },
        fetchData: [],
        clientList: [],
        query: ""
  
      }
    },
    created() {
       
      this.fetchDataList();
      this.fetchListSelection();
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
            this.svData.libelle= "Vente des Prosuits";
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_entete_vente_salon/${this.svData.id}`,
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
            this.svData.libelle= "Vente des Prosuits";
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_entete_vente_salon`,
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
  
      // searchMember: _.debounce(function () {
      //   this.fetchDataList();
      // }, 300),
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_vente_salon/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.refClient = item.refClient;
              this.svData.dateVente = item.dateVente;
              this.svData.libelle = item.libelle;
              this.svData.author = item.author;
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_vente_salon/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_vente_salon?page=`);
      },
  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.clientList = donnees;
  
          }
        );
      },
      showDetailVente(refEnteteVente, name) {
  
        if (refEnteteVente != '') {
  
          this.$refs.SalonDetailVente.$data.etatModal = true;
          this.$refs.SalonDetailVente.$data.refEnteteVente = refEnteteVente;
          this.$refs.SalonDetailVente.$data.svData.refEnteteVente = refEnteteVente;
          this.$refs.SalonDetailVente.fetchDataList();
          this.$refs.SalonDetailVente.fetchListSelection();
          this.fetchDataList();
  
          this.$refs.SalonDetailVente.$data.titleComponent =
            "Detail Vente pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
    showFacture(refEnteteVente, name,ServiceData) {

      if (refEnteteVente != '') {

        this.$refs.FactureVente.$data.dialog2 = true;
        this.$refs.FactureVente.$data.refEnteteSortie = refEnteteVente;
        this.$refs.FactureVente.$data.ServiceData = ServiceData;
        this.$refs.FactureVente.showModel(refEnteteVente);
        this.fetchDataList();

        this.$refs.FactureVente.$data.titleComponent =
          "La Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
      showSalonPaiement(refEnteteVente, name,totalFacture,totalPaie,RestePaie) {
  
        if (refEnteteVente != '') {
  
          this.$refs.SalonPaiement.$data.etatModal = true;
          this.$refs.SalonPaiement.$data.refEnteteVente = refEnteteVente;
          this.$refs.SalonPaiement.$data.totalFacture = totalFacture;
          this.$refs.SalonPaiement.$data.totalPaie = totalPaie;
          this.$refs.SalonPaiement.$data.RestePaie = RestePaie;
          this.$refs.SalonPaiement.$data.svData.refEnteteVente = refEnteteVente;
          this.$refs.SalonPaiement.fetchDataList();
          this.$refs.SalonPaiement.get_mode_Paiement();
          this.$refs.SalonPaiement.getInfoFacture();
          this.fetchDataList();
  
          this.$refs.SalonPaiement.$data.titleComponent =
            "Detail Vente pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tsalon_entete_vente';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une vente de service pour le client : "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    }
  
    },
    filters: {
  
    }
  }
  </script>
  
    
    