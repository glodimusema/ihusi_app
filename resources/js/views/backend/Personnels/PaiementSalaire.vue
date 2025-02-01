<template>
    <v-row justify="center">
  
      
  
      <v-dialog v-model="etatModal" persistent max-width="1600px">
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
                  <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Paiement des Agents <v-spacer></v-spacer>
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

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList"
                                  item-text="noms_agent" item-value="id" dense outlined v-model="svData.refAffectation"
                                  chips clearable>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Salaire Base" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.salaire_base_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Allocation Familliale" prepend-inner-icon="event" dense
                                   outlined v-model="svData.fammiliale_paie">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Indemnité de logement" prepend-inner-icon="event" dense
                                   outlined v-model="svData.logement_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Transport" prepend-inner-icon="event" dense
                                   outlined v-model="svData.transport_paie">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Salaire Brut" prepend-inner-icon="event" dense
                                   outlined v-model="svData.sal_brut_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Salaire Brut Imposable" prepend-inner-icon="event" dense
                                   outlined v-model="svData.sal_brut_imposable_paie">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="INSS(QPO)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.inss_qpo_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="INSS(QPP)" prepend-inner-icon="event" dense
                                   outlined v-model="svData.inss_qpp_paie">
                                </v-text-field>
                              </div>
                            </v-flex>


                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="CNSS" prepend-inner-icon="event" dense
                                   outlined v-model="svData.cnss_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="INPP" prepend-inner-icon="event" dense
                                   outlined v-model="svData.inpp_paie">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="CNSS" prepend-inner-icon="event" dense
                                   outlined v-model="svData.onem_paie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="INPP" prepend-inner-icon="event" dense
                                   outlined v-model="svData.ipr_paie">
                                </v-text-field>
                              </div>
                            </v-flex>

                            
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="number" label="Net a Payer" prepend-inner-icon="event" dense
                                   outlined v-model="svData.netPaie">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Charge Prévue" prepend-inner-icon="event" dense
                                   outlined v-model="svData.salaire_prevu">
                                </v-text-field>
                              </div>
                            </v-flex>

                            <!-- cnss_paie,inpp_paie,onem_paie,ipr_paie -->
  
  
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
                                <tr>
                                  <th class="text-left">Agent</th>
                                  <th class="text-left">DatePaie</th>
                                  <th class="text-left">Mois</th>
                                  <th class="text-left">Année</th>
                                  <th class="text-left">SBase</th>
                                  <th class="text-left">Famille</th>
                                  <th class="text-left">Logement</th>
                                  <th class="text-left">Transport</th>
                                  <th class="text-left">QPO</th>
                                  <th class="text-left">IPR</th>
                                  <th class="text-left">NET</th>
                                  <th class="text-left">ChargePrévue</th>
                                  <th class="text-left">NETCash</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody> 
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.noms_agent }}</td>
                                  <td>{{ item.dateFiche | formatDate }}</td>
                                  <td>{{ item.name_mois }}</td>
                                  <td>{{ item.name_annee }}</td>
                                  <td>{{ item.salaire_base_paie }}$</td>
                                  <td>{{ item.fammiliale_paie }}$</td>
                                  <td>{{ item.logement_paie }}$</td>
                                  <td>{{ item.transport_paie }}$</td>
                                  <td>{{ item.inss_qpo_paie }}$</td>
                                  <td>{{ item.ipr_paie }}$</td>
                                  <td>{{ item.netPaie }}$</td>
                                  <td>{{ item.netPaieCash }}$</td>
                                  <td>                                  
                                    {{ item.salaire_prevu <= 0 ? item.netPaie : item.salaire_prevu }}$ 
                                  </td>                                  
                                  <td>{{ item.author }}</td>
                                  <td>
  
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>
  
                                    <v-list dense width="">  
 
                                      <v-list-item link @click="printBill(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bulletin de Paie
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
                                        <v-list-item-title style="margin-left: -20px">Supprimer
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
  
  
  export default {
    components:{
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
        refFichePaie: 0,
  
        // id,refFichePaie,refAffectation,salaire_base_paie,fammiliale_paie,logement_paie,
        // transport_paie,sal_brut_paie,sal_brut_imposable_paie,inss_qpo_paie,inss_qpp_paie,cnss_paie,inpp_paie,onem_paie,ipr_paie,author
  
        svData: {
          id: '',
          refFichePaie: 0,
          refAffectation: 0,
          salaire_base_paie: 0,
          fammiliale_paie: 0,
          logement_paie: 0,
          transport_paie: 0,
          sal_brut_paie: 0,
          sal_brut_imposable_paie: 0,
          inss_qpo_paie: 0,
          inss_qpp_paie: 0,
          cnss_paie: 0,
          inpp_paie: 0,
          onem_paie: 0,
          ipr_paie: 0,
          netPaie: 0,
          author: '',
        },
        fetchData: [],
        agentList: [],
        don: [],
        query: "",
          
          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:''
  
      }
    },
    created() {
       
      // this.fetchDataList();
      // this.fetchListAgent();
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
            this.svData.refFichePaie = this.refFichePaie;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_paie_salaire`,
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
            this.svData.refFichePaie = this.refFichePaie;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_paie_salaire`,
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
      fetchListAgent() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_affectation_agent`).then(
          ({ data }) => {
            var donnees = data.data;
            this.agentList = donnees;
  
          }
        );
  
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_paie_salaire/${id}`).then(
          ({ data }) => {
            this.getSvData(this.svData, data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_paie_salaire/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
  
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bulletin_paie_salire_agent?id=` + id);
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_paiement_salaire_fiche/${this.refFichePaie}?page=`);
      },
      desactiverData(valeurs,user_created,date_entree,noms) {
  //
        var tables='tperso_entete_paiement';
        var user_name=this.userData.name;
        var user_id=this.userData.id;
        var detail_information="Suppression de la fiche d'entete Paiement de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;
  
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
    
    