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

                <PaiementSalle ref="PaiementSalle" />
    
              <v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="700px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Reservation Salle <v-spacer></v-spacer>
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
                                        <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="chambreList" item-text="designation"
                                            item-value="id" dense outlined v-model="svData.refSalle" chips clearable @change="getPrice(svData.refSalle)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" readonly label="Prix Salle($)" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_unitaire">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Cérémonie " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_ceremonie">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Résérvation " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_reservation">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="Time" label="Heure Début " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_debut">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="Time" label="Heure Fin " prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_sortie">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Reduction" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.reduction">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Device" :items="[
                                            { designation: 'USD' },
                                            { designation: 'FC' },
                                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.devise">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Observations" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observation">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                            </v-layout>   
      
    
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                          <v-btn color="  primary" dark :loading="loading" @click="validate">
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
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                            outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                                <v-btn @click="dialog = true" fab color="  primary" dark>
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
                                <tr>
                                  <th class="text-left">Client</th>
                                  <th class="text-left">Salle</th>
                                  <th class="text-left">DateCeremonie</th>
                                  <th class="text-left">HeureDebut</th>
                                  <th class="text-left">HeureFin</th>
                                  <th class="text-left">Prix($)</th>
                                  <th class="text-left">Reduction($)</th>
                                  <th class="text-left">Montant($)</th>
                                  <th class="text-left">Taux</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Mise à jour</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.nom_salle }}</td>
                                  <td>{{ item.date_ceremonie }}</td>
                                  <td>{{ item.heure_debut }}</td>
                                  <td>{{ item.heure_sortie }}</td>
                                  <td>{{ item.prix_salle }}</td>
                                  <td>{{ item.reduction }}</td>
                                  <td>{{ item.prix_unitaireReduit }}</td>
                                  <td>{{ item.taux }}</td>
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

                            <v-list-item link @click="showPaiementSalle(item.id, item.noms,item.totalFacture,item.totalPaie,item.RestePaie)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Paiement Facture
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="primary">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item    link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="primary">edit</v-icon>
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
    
                          <v-pagination color="  primary" v-model="pagination.current" :length="pagination.total"
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
    import PaiementSalle from './PaiementSalle.vue';
    

    export default {
      components:{
        PaiementSalle
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
          refClient: 0,
    
    //       'id','refClient','refSalle','date_ceremonie','heure_debut','heure_sortie',
    // 'date_reservation','prix_unitaire','devise','taux','reduction','observation','author'
          svData: {
            id: '',
            refClient: 0,
            refSalle: 0,
            date_ceremonie:"",            
            heure_debut:"",
            heure_sortie:"",
            date_reservation:"",
            prix_unitaire: 0,            
            devise:"",
            reduction:0,
            observation:"",           
            author: "",
            refUser : 0        
          },
          fetchData: [],
          chambreList: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
        // this.fetchListSalle();
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
              this.svData.refClient = this.refClient;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.libelle="Reservation Salle";
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_hotel_reservation_salle/${this.svData.id}`,
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
              this.svData.refClient = this.refClient;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.libelle="Reservation Salle";
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_hotel_reservation_salle`,
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
    
        // s'id','refClient','refSalle','prix_unitaire','qteVente','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_reservation_salle/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
            donnees.map((item) => {
                this.titleComponent = "modification de " + item.noms;
            });
            this.getSvData(this.svData, data.data[0]);
    
              this.edit = true;
              this.dialog = true;
    
              // console.log(donnees);
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_hotel_reservation_salle/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_facture_salle?id=` + id);
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_hotel_reservation_salle/${this.refClient}?page=`);
        },
    
        fetchListSalle() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_thotel_salle_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.chambreList = donnees;
            }
          );
        },
    showPaiementSalle(refReservation, name,totalFacture,totalPaie,RestePaie) {

      if (refReservation != '') {

        this.$refs.PaiementSalle.$data.etatModal = true;
        this.$refs.PaiementSalle.$data.refReservation = refReservation;
        this.$refs.PaiementSalle.$data.totalFacture = totalFacture;
        this.$refs.PaiementSalle.$data.totalPaie = totalPaie;
        this.$refs.PaiementSalle.$data.RestePaie = RestePaie;
        this.$refs.PaiementSalle.fetchDataList();
        this.$refs.PaiementSalle.get_mode_Paiement();
        this.$refs.PaiementSalle.getInfoFacture();
        this.fetchDataList();

        this.$refs.PaiementSalle.$data.titleComponent =
          "Paiement Reservation Pour pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
//
    },
    getPrice(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_salle/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.prix_unitaire = item.prix_salle;       
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
      var tables='thotel_reservation_salle';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'une facture de reservation de la salle du client "+noms+" par l'utilisateur "+user_name+"" ;

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
      
      