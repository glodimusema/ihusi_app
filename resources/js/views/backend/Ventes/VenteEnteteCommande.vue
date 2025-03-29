<template>
    <v-layout>
      <!--   -->
      <v-flex md12>
        <VenteDetailCommande ref="VenteDetailCommande" />
        <BonCommande ref="BonCommande" />
        <AnnexeCommande ref="AnnexeCommande" />
        <VentePaieOneCommende ref="VentePaieOneCommende" />
        <CreateApproCmd ref="CreateApproCmd" />
        <ModelFournisseur ref="ModelFournisseur" />


        <v-dialog v-model="dialog2" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Validation d'une Commande <v-spacer></v-spacer>
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
                                  
                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
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
  
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Requisiitions <v-spacer></v-spacer>
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
                      <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms"
                            item-value="id" outlined dense v-model="svData.refFournisseur">
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


                <!-- <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="[fournisseurList,{ designation: 'Ajouter un Fournisseur' }]" item-text="noms" item-value="id"
                        outlined dense v-model="svData.refFournisseur">
                      </v-autocomplete>
                    </div>
                </v-flex> -->

                <!-- <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Module" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="moduleList" item-text="nom_module"
                      item-value="id" dense outlined v-model="svData.module_id" chips clearable >
                    </v-autocomplete>
                    </div>
                </v-flex> -->

                

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">

                      <!-- <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="servicedestList" item-text="nom_service"
                            item-value="refService" dense outlined v-model="svData.refService" chips clearable >
                        </v-autocomplete>  -->
                      <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                        item-value="id" dense outlined v-model="svData.refService" chips clearable >
                      </v-autocomplete>
                    </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date Requisition" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateCmd">
                      </v-text-field>
                    </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Libellé" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                      </v-text-field> 
                    </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-select label="Activé(e)" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.active">
                      </v-select> 
                    </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-select label="Cloturé(e)" :items="[
                          { designation: 'OUI' },
                          { designation: 'NON' }
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                          item-text="designation" item-value="designation" v-model="svData.cloture">
                        </v-select>
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
              <router-link :to="'#'">Recquisitions</router-link>
            </div>
          </v-flex>
        </v-layout>
  
        <br /><br />
        <v-layout>
          <!--   -->
          <v-flex md12>
            <v-layout>
              <v-flex md12>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                  rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
              </v-flex>

              <hr />      
            <hr />
            <hr />
            <hr />                    
              <v-flex md6>
                <v-text-field type="date" label="Du" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date1">
                  </v-text-field>
              </v-flex>
              <hr />
              <hr />
              <hr />
              <v-flex md6>
                <v-text-field type="date" label="Au" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date2">
                  </v-text-field>
              </v-flex> 
              <hr />
              <hr />
              <hr />

              <v-flex md6>
                <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms"
                            item-value="id" outlined dense v-model="svData.refFournisseur">
                        </v-autocomplete>
              </v-flex> 
             
              <hr />
              <hr />
              <hr />
              <v-flex md4>
                <v-btn color="blue" dark :loading="loading" @click="fetchDataListFilterFss">
                    {{ "Filtrer" }}
                  </v-btn>
              </v-flex> 
              <hr />
              <v-flex md4>
                <v-btn color="blue" dark :loading="loading" @click="fetchDataList">
                    {{ "Refresh" }}
                  </v-btn>
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
                        <th class="text-left">Action</th>
                        <th class="text-left">Observ.</th>
                        <th class="text-left">N°BE</th>
                        <th class="text-left">DateCmd</th>
                        <th class="text-left">Fournisseur</th>
                        <th class="text-left">Module</th>
                        <th class="text-left">Services</th>
                        <th class="text-left">Téléphone</th>
                        <th class="text-left">Libellé</th>
                        <th class="text-left">Montant</th>
                        <th class="text-left">Payé</th>
                        <th class="text-left">Reste</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Activé</th>
                        <th class="text-left">Cloturé</th>
                        <th class="text-left">Created_at</th>  

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
                              <!-- showAnnexeCommande -->
                              <v-list-item link @click="showDetailCommande(item.id, item.noms, item.refService)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Etat de Besoin
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item v-if="item.active == 'OUI'" link @click="editDataTransfert(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Créer l'approvisionnement pour cette commande
                                </v-list-item-title>
                                </v-list-item>

                              <!-- <v-list-item link @click="showCreateApproCmd(item.id, item.noms, item.refFournisseur)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Créer l'approvisionnement de cette commande
                                </v-list-item-title>
                              </v-list-item> -->

                              <v-list-item link @click="showAnnexeCommande(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Quelques Annexes
                                </v-list-item-title>
                              </v-list-item>
  
                              <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon de Commande
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showVentePaieOneCommende(item.id, item.noms,item.montant,item.paie,item.Reste)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Paiement Facture
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
                        <td>
                            
                            <v-btn
                                      elevation="2"
                                      x-small
                                      class="white--text"
                                      :color="item.active =='OUI' ? '#3DA60C' : '#F13D17'"
                                      depressed                            
                                    >
                                    {{ item.active =='OUI' ?  'Encours' : 'Déjà Stocké' }}
                            </v-btn>                         
                                
                         </td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateCmd | formatDate }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.nom_module }}</td>
                        <td>{{ item.nom_service }}</td>
                        <td>{{ item.contact }}</td>
                        <td>{{ item.libelle }}</td>
                        <td>{{ item.montant }}$</td>
                        <td>{{ item.paie }}$</td>
                        <td>{{ item.Reste }}$</td>
                        <td>{{ item.author }}</td>
                        <td>{{ item.active }}</td>
                        <td>{{ item.cloture }}</td>
                        <td>
                            {{ item.created_at | formatDate }}
                            {{ item.created_at | formatHour }}
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
  import BonCommande from '../Rapports/Finances/BonCommande.vue';
  import AnnexeCommande from './AnnexeCommande.vue';
  import VenteDetailCommande from './VenteDetailCommande.vue';
  import VentePaieOneCommende from "./VentePaieOneCommende.vue";
  import CreateApproCmd from "./CreateApproCmd.vue";
  import ModelFournisseur from "./ModelFournisseur.vue";
  
  
  
  
  export default {
    components:{
      VenteDetailCommande,
      BonCommande,
      AnnexeCommande,
      VentePaieOneCommende,
      CreateApproCmd,
      ModelFournisseur
    },
    data() {
      return {
  
        title: "Liste des Requisitions",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        dialog2 : false,

    // 'id','refFournisseur','module_id','refService','dateCmd','libelle',
    // 'niveau1','niveaumax','active','montant','paie','author','refUser'


        svData: {
          id: '',
          refFournisseur: 0,
          module_id : 0,
          refService : 0,
          dateCmd: "",
          libelle: "",
          cloture:"",                    
          active : "",          
          author: "",
          refUser : 0,

          refCcommande : 0,
          refDestination : 0,

          date1:'',
          date2:''
        },
        fetchData: [],
        fournisseurList: [],
        moduleList: [],
        serviceList: [],
        servicedestList: [],
        query: ""
  
      }
    },
    created() {       
      this.fetchDataList();
      // this.fetchDataListFilter();
      this.fetchListFournisseur();
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
            this.svData.module_id=1;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vente_entete_requisition/${this.svData.id}`,
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
            this.svData.module_id=1;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vente_entete_requisition`,
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
        fetchListModule() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.moduleList = donnees;
            }
          );
        },    
        fetchListService() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.serviceList = donnees;
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_requisition/${id}`).then(
          ({ data }) => {
            // var donnees = data.data;
              // donnees.map((item) => {
              //   this.titleComponent = "modification de " + item.designation;
              // });

              this.titleComponent = "Modification des information ";

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
          this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_requisition/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        }); 
      },
      fetchDataListFilterFss() {
        if(this.svData.refFournisseur != '')
        {
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_requisition_filter_fss?date1=` + this.svData.date1 + "&date2=" + this.svData.date2 + "&refFournisseur=" + this.svData.refFournisseur + "&page=");
        }
        else
        {
          this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_requisition_filter?date1=` + this.svData.date1 + "&date2=" + this.svData.date2 + "&page=");
        }
        
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_requisition?page=`);
      },
      showDetailCommande(refEnteteCmd, name, refService) {
  
        if (refEnteteCmd != '') {
  
          this.$refs.VenteDetailCommande.$data.etatModal = true;
          this.$refs.VenteDetailCommande.$data.refEnteteCmd = refEnteteCmd;
          this.$refs.VenteDetailCommande.$data.svData.refEnteteCmd = refEnteteCmd;
          this.$refs.VenteDetailCommande.fetchDataList();
          this.$refs.VenteDetailCommande.get_produit_for_service(refService);
          this.$refs.VenteDetailCommande.fetchListTVA();
          this.fetchDataList();
          //VentePaieOneCommende
          this.$refs.VenteDetailCommande.$data.titleComponent =
            "Detail Requisition pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showCreateApproCmd(refEnteteCmd, name, refFournisseur) {
  
        if (refEnteteCmd != '') {
  
          this.$refs.CreateApproCmd.$data.etatModal = true;
          this.$refs.CreateApproCmd.$data.refEnteteCmd = refEnteteCmd;
          this.$refs.CreateApproCmd.$data.refFournisseur = refFournisseur;
          this.$refs.CreateApproCmd.$data.svData.refEnteteCmd = refEnteteCmd;
          // this.$refs.CreateApproCmd.fetchListFournisseur();
          this.$refs.CreateApproCmd.fetchListModule();
          this.$refs.CreateApproCmd.fetchListService();
          this.$refs.CreateApproCmd.fetchListProduit();
          this.$refs.CreateApproCmd.fetchListDevise();
          this.$refs.CreateApproCmd.fetchListTVA();
          // this.$refs.CreateApproCmd.fetchDataList();
          // this.$refs.CreateApproCmd.fetchListServiceDest();
          // this.$refs.CreateApproCmd.fetchDataList();
          this.$refs.CreateApproCmd.fetchListDataCommande(refEnteteCmd);
          this.$refs.CreateApproCmd.$data.titleComponent =
            "Approvisionnement pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      showVentePaieOneCommende(refCommande, name,totalFacture,totalPaie,RestePaie) {

            if (refCommande != '') {

              this.$refs.VentePaieOneCommende.$data.etatModal = true;
              this.$refs.VentePaieOneCommende.$data.refCommande = refCommande;
              this.$refs.VentePaieOneCommende.$data.totalFacture = totalFacture;
              this.$refs.VentePaieOneCommende.$data.totalPaie = totalPaie;
              this.$refs.VentePaieOneCommende.$data.RestePaie = RestePaie;
              this.$refs.VentePaieOneCommende.$data.svData.montant_paie = RestePaie;
              this.$refs.VentePaieOneCommende.$data.svData.refCommande = refCommande;
              this.$refs.VentePaieOneCommende.fetchDataList();
              this.$refs.VentePaieOneCommende.get_mode_Paiement();
              this.$refs.VentePaieOneCommende.getInfoFacture();
              this.fetchDataList();

              this.$refs.VentePaieOneCommende.$data.titleComponent =
                "Detail Paiement pour " + name;

            } else {
              this.showError("Personne n'a fait cette action");
            }
  
      },
      showAnnexeCommande(refEnteteCmd, name) {
  
        if (refEnteteCmd != '') {
  
          this.$refs.AnnexeCommande.$data.etatModal = true;
          this.$refs.AnnexeCommande.$data.refEnteteCmd = refEnteteCmd;
          this.$refs.AnnexeCommande.$data.svData.refEnteteCmd = refEnteteCmd;
          this.$refs.AnnexeCommande.fetchDataList();
          this.fetchDataList();
  
          this.$refs.AnnexeCommande.$data.titleComponent =
            "Annexe de la commande pour " + name;
  
        } else {
          this.showError("Personne n'a fait cette action");
        }
  
      },
      desactiverData(valeurs,user_created,date_entree,noms) {

      var tables='tvente_entete_requisition';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression de la commande aupres du Fournisseur "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
      },
      showFacture(refEnteteCmd, name,ServiceData) {

      if (refEnteteCmd != '') {

        this.$refs.BonCommande.$data.dialog2 = true;
        this.$refs.BonCommande.$data.refEnteteCmd = refEnteteCmd;
        this.$refs.BonCommande.$data.ServiceData = ServiceData;
        this.$refs.BonCommande.showModel(refEnteteCmd);
        this.fetchDataList();

        this.$refs.BonCommande.$data.titleComponent =
          "Bon de Commande pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

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
    editDataTransfert(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_requisition/${id}`).then(
            ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {                     
                    this.svData.refCcommande = item.id;         
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
                `${this.apiBaseURL}/insert_vente_global_valider_commande`,
                JSON.stringify(this.svData)
                )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog2 = false;
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
    }
  
    },
    filters: {
  
    }
  }
  </script>
    
    