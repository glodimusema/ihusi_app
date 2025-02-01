<template>
  <v-layout>
    <!--   -->
    <v-flex md12>
      <VenteDetailEntrees ref="VenteDetailEntrees" />
      <ModelFournisseur ref="ModelFournisseur" />
      <BonEntree ref="BonEntree" />

      <v-dialog v-model="dialog2" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Transferer le Stock <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog2 = false" text fab depressed>
                                <v-icon>close</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Fermer</span>
                        </v-tooltip>
                      </v-card-title>
                      <v-card-text>
                                  
                        <v-autocomplete label="Selectionnez le Service de destination" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="servicedestList" item-text="nom_service"
                            item-value="refService" dense outlined v-model="svData.refDestination" chips clearable >
                        </v-autocomplete> 
 

                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                        <v-btn color="blue" dark :loading="loading" @click="validateTransfert">
                          {{ "Transferer" }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
        </v-dialog>

      <v-dialog v-model="dialog" max-width="700px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Approvisionnements <v-spacer></v-spacer>
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

              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-autocomplete label="Selectionnez la Commande" prepend-inner-icon="home"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.CmdList"
                    item-text="designationCommande" item-value="id" dense outlined v-model="svData.refRecquisition"
                    chips clearable >
                  </v-autocomplete>
                </div>
              </v-flex>
              <v-flex xs12 sm12 md4 lg4>
                <div class="mr-1">
                  <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms" item-value="id"
                    outlined dense v-model="svData.refFournisseur">
                  </v-autocomplete>
                </div>
              </v-flex>
              <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="fetchListFournisseur" color="primary" :loading="loading"
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
                                        showFournisseur()
                                        " fab x-small color="primary" dark>
                                        <v-icon>add</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une Fournisseur</span>
                        </v-tooltip>
                    </div>
              </v-flex>  


              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-autocomplete label="Selectionnez le Module" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="moduleList" item-text="nom_module"
                  item-value="id" dense outlined v-model="svData.module_id" chips clearable >
                </v-autocomplete>
                </div>
              </v-flex>
              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                  item-value="refService" dense outlined v-model="svData.refService" chips clearable >
                </v-autocomplete>
                </div>
              </v-flex>


              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-text-field type="date" label="Date Entrée" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEntree">
                  </v-text-field>                  
                </div>
              </v-flex>
              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-text-field label="Libellé" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                  </v-text-field>                  
                </div>
              </v-flex>



              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-text-field label="Transporteur" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.transporteur">
                  </v-text-field>                   
                </div>
              </v-flex>
              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-select label="Activé(e)" :items="[
                  { designation: 'OUI' },
                  { designation: 'NON' }
                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                  item-text="designation" item-value="designation" v-model="svData.active"></v-select>                   
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
            <router-link :to="'#'">Approvisionnements</router-link>
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
                      <!-- montant -->
                      <th class="text-left">N°BE</th>
                      <th class="text-left">DateEntrée</th>
                      <th class="text-left">Fournisseur</th>
                      <th class="text-left">Module</th>
                      <th class="text-left">Service</th>
                      <th class="text-left">Téléphone</th>
                      <th class="text-left">Libellé</th>
                      <th class="text-left">Montant</th>
                      <th class="text-left">Author</th>
                      <th class="text-left">Created_at</th>
                      <!-- <th class="text-left">Observ.</th> -->
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.dateEntree | formatDate }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.nom_module }}</td>
                      <td>{{ item.nom_service }}</td>
                      <td>{{ item.contact }}</td>
                      <td>{{ item.libelle }}</td>
                      <td>{{ item.montant }}$</td>
                      <td>{{ item.author }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                     </td>
                     <!-- <td>
                            
                        <v-btn
                                  elevation="2"
                                  x-small
                                  class="white--text"
                                  :color="item.active =='OUI' ? '#3DA60C' : '#F13D17'"
                                  depressed                            
                                >
                                  {{ item.active =='OUI' ?  'à Tranférer' : 'Déjà Tranféré' }}
                        </v-btn>                         
                            
                     </td> -->
                     <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="showDetailEntree(item.id, item.noms,item.refService)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Entrée
                                </v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.active == 'OUI'" link @click="editDataTransfert(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Tranferer le Stock
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon d'Entree
                                </v-list-item-title>
                              </v-list-item>

                            <v-list-item    link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="  blue">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item   link @click="deleteData(item.id)">
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
    <!--   -->
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import VenteDetailEntrees from './VenteDetailEntrees.vue';
import ModelFournisseur from "./ModelFournisseur.vue";
import BonEntree from "../Rapports/Finances/BonEntree.vue";


export default {
  components:{
    VenteDetailEntrees,
    ModelFournisseur,
    BonEntree
  },
  data() {
    return {

      title: "Liste des Approvisionnements",
      dialog: false,
      dialog2 : false,
      edit: false,
      loading: false,
      disabled: false,
      svData: {
        id: '',
        refFournisseur: 0,
        refRecquisition: 0,
        module_id: 0,
        refService: 0,
        dateEntree: "",
        libelle: "",
        transporteur : "",
        niveau1 : 0,
        niveaumax : 0,
        active : "",
        author: "",
        refUser:0
      },
      fetchData: [],
      fournisseurList: [],
      CmdList: [],
      moduleList: [],
      serviceList: [],
      servicedestList : [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {     
    this.fetchDataList();
    this.fetchListFournisseur();
    this.fetchListCommande();
    this.fetchListModule();
    this.fetchListService();
    this.fetchListServiceDest();
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
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_vente_entete_entree/${this.svData.id}`,
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
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_vente_entete_entree`,
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
        fetchListCommande() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_liste_commande_search`).then(
            ({ data }) => {
              var donnees = data.data;
              this.CmdList = donnees;
            }
          );
        },    
        fetchListModule() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.moduleList = donnees;
            }
          );
        },    
        fetchListService() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_service_stockmasison_user_by_user/${this.userData.id}`).then(
        //this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.serviceList = donnees;
              //fetch_vente_services_2
            }
          );
        },
    fetchListFournisseur() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
        ({ data }) => {
          var donnees = data.data;
          this.fournisseurList = donnees;

        }
      );
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_entree/${id}`).then(
        ({ data }) => {
          // var donnees = data.data;

          this.titleComponent = "modification des informations";

          // donnees.map((item) => {
          //   this.titleComponent = "modification de " + item.nom_unite;
          // });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_entree/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_entree?page=`);
    },
        showDetailEntree(refEnteteEntree, name,refService) {

        if (refEnteteEntree != '') {

            this.$refs.VenteDetailEntrees.$data.etatModal = true;
            this.$refs.VenteDetailEntrees.$data.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.$data.svData.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.fetchDataList();
            this.$refs.VenteDetailEntrees.get_produit_for_service(refService);
            this.$refs.VenteDetailEntrees.fetchListTVA();
            this.fetchDataList();

            this.$refs.VenteDetailEntrees.$data.titleComponent =
            "Detail Entree pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },
    desactiverData(valeurs,user_created,date_entree,noms) {
      var tables='tvente_entete_entree';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une approvisionnment du fournisseur "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    editDataTransfert(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_entree/${id}`).then(
            ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {                     
                    this.svData.refAppro = item.id;         
                });
                this.dialog2 = true;
            }
        );
    },  
    validateTransfert() {
            if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
            }
            else {
                this.svData.author = this.userData.name;
                this.svData.refUser = this.userData.id;
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_vente_data_transfert`,
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
    fetchListServiceDest() {
      //this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
      this.editOrFetch(`${this.apiBaseURL}/fetch_service_magasin_user_by_user/${this.userData.id}`).then(
            ({ data }) => {
              var donnees = data.data;
              this.servicedestList = donnees;
            }
          );
    },
    showFournisseur() {
      this.$refs.ModelFournisseur.$data.etatModal = true;
      this.$refs.ModelFournisseur.testTitle();
      this.$refs.ModelFournisseur.onPageChange();
      this.$refs.ModelFournisseur.fetchListCompte();
      this.fetchListFournisseur();

      this.$refs.ModelFournisseur.$data.titleComponentss =
        "Un nouveau Fournisseur";
    },
      showFacture(refEnteteEntree, name,ServiceData) {

      if (refEnteteEntree != '') {

        this.$refs.BonEntree.$data.dialog2 = true;
        this.$refs.BonEntree.$data.refEnteteEntree = refEnteteEntree;
        this.$refs.BonEntree.$data.ServiceData = ServiceData;
        this.$refs.BonEntree.showModel(refEnteteEntree);
        this.fetchDataList();

        this.$refs.BonEntree.$data.titleComponent =
          "Bon d'Entree pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

      }

  },
  filters: {

  }
}
</script>
  
  