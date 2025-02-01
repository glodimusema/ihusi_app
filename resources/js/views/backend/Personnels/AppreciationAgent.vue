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
                <v-dialog v-model="dialog" max-width="700px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Appreciation Agent <v-spacer></v-spacer>
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
                                  <v-text-field label="Periode" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.periodeDu">
                            </v-text-field>
                            </div>
                          </v-flex>

                          
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              II. APPRECIATION
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              1. EXECUTION DU TRAVAIL
                            </v-input>
                          </div>
                        </v-flex>

                          
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="a) Connaissance théoriques et techniques /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.connaissanceTheorique">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="b) Appplication de déonthologie /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.appliDeontologie">
                              </v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="c) Manipulation /Exécution /Traitement de taches /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.manipulation">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="d) Prend en considération les remarques des autres /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prendConsideration">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              2. QUALITES PERSONNELLES
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="a) Ponctualité de présence sur le lieu du travail /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ponctualite">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="b) Ordre et propreté dans l'exécution /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ordre">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="c) Fiabilité, confiance et esprit de sacrifique /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.fiabilite">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="d) Esprit d'équipe /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.espritEquipe">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="e) Courtoisie et respect des autres /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.courtoisie">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="f) Sens de responsabilité /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.sensResponsabilite">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="g) Sens d'écoute /05" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.sensEcoute">
                              </v-text-field>
                            </div>
                          </v-flex>



                          
                          <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              3. QUALITES INTELLECTUELLES
                            </v-input>
                          </div>
                        </v-flex>

                                                
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="a) Préparation avant exécution du travail /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.preparationExecution">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="number" label="b) Organise son travail de façon rigoureuse et gère son temps convenablement /10" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.organiseTravail">
                              </v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-textarea type="number" label="4. Quels axes d'amelioration pouvez-vous proposer au Collaborateur/Collaboratrice ?" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Propositions">
                              </v-textarea>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.agent"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Suiveur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.suiveur"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Chef HIERARCHIQUE" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.hierarchie"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                           <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Division RH" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.rh"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                         
                          
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateAppreciation">
                              </v-text-field>
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
                                <th class="text-left">Service</th>
                                <th class="text-left">PeriodeDu</th>
                                <th class="text-left">TotalPoints</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">Mension</th>
                                <th class="text-left">Suiveur</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.name_serv_perso }}</td>
                                <td>{{ item.periodeDu }}</td>
                                <td>{{ item.TotalPoints }}</td>
                                <td>{{ item.dateAppreciation }}</td>
                                <td>{{ item.Mension }}</td>
                                <td>{{ item.suiveur }}</td>
                                <td>
                                  <v-tooltip top    color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="editData(item.id)" fab small>
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-btn>
                                      </span>
                                    </template>
                                    <span>Modifier</span>
                                  </v-tooltip>

                                  <v-tooltip top   color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="deleteData(item.id)" fab small>
                                          <v-icon color="  red">delete</v-icon>
                                        </v-btn>
                                      </span>
                                    </template>
                                    <span>Suppression</span>
                                  </v-tooltip>

                                  <!-- <v-tooltip top  color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="printBill(item.id)" fab small><v-icon
                                            color="blue">print</v-icon></v-btn>
                                      </span>
                                    </template>
                                    <span>Imprimer Bon</span>
                                  </v-tooltip> -->

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
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refAffectation: 0,

    //id,refAffectation,periodeDu,connaissanceTheorique,appliDeontologie,manipulation,prendConsideration,ponctualite,
    //ordre,fiabilite,espritEquipe,courtoisie,sensResponsabilite,sensEcoute,preparationExecution,organiseTravail,Propositions,
    //dateAppreciation,agent,suiveur,hierarchie,rh,author

      svData: {
        id: '',
        refAffectation: 0,
        periodeDu: '',
        connaissanceTheorique: 0,
        appliDeontologie: 0,
        manipulation:0,
        prendConsideration:0,
        ponctualite:0,
        ordre:0,
        fiabilite:0,
        espritEquipe:0,
        courtoisie:0,
        sensResponsabilite:0,
        sensEcoute:0,
        preparationExecution:0,
        organiseTravail:0,
        Propositions:'',
        dateAppreciation:'',
        agent: '',
        suiveur:'',
        hierarchie:'',
        rh: '',
        AG: '',
        dateDemande: '',
        author: '',
      },
      fetchData: [],
      medecinList: [],
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
    // this.fetchListSelection();
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
          this.svData.refAffectation = this.refAffectation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_appreciation_agent/${this.svData.id}`,
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
          this.svData.refAffectation = this.refAffectation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_appreciation_agentt`,
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
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

        }
      );

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_appreciation_agent/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAffectation = item.refAffectation;
            this.svData.periodeDu = item.periodeDu;
            this.svData.connaissanceTheorique = item.connaissanceTheorique;
            this.svData.appliDeontologie = item.appliDeontologie;
            this.svData.agent = item.agent;
            this.svData.rh = item.rh;
            this.svData.AG = item.AG;
            this.svData.dateDemande = item.dateDemande;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_appreciation_agent/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_fiche_appreciation_agent?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_appreciation_agent/${this.refAffectation}?page=`);
    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tperso_appreciation_agent';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression de la fiche d'appreciation de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  