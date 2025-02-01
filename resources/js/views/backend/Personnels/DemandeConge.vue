<template>
  <v-row justify="center">


    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- DetailAffectationRubrique -->

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
                        Affectation Agent <v-spacer></v-spacer>
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
                              <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                                item-text="nom_categorie" item-value="id" outlined v-model="svData.categorie_id"
                                @change="get_circonstance_for_Categorie(svData.categorie_id)">
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Type de Circonstance" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="circonstanceList"
                                item-text="nom_circontstance" item-value="id" dense outlined
                                v-model="svData.typecircintance_id" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Description du congé" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.description_conge">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date demande" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_demande">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date depart" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_depart">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Nombre de jour Sollicité" prepend-inner-icon="event"
                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.nbr_joursollicite">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Reprise" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_reprise">
                              </v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Superviseur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="noms_agent" dense outlined v-model="svData.superviseur_conge" chips
                                clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'Interimaire" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="noms_agent" dense outlined v-model="svData.interimaire_conge" chips
                                clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Resumé des taches" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.resumetache_conge">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList" item-text="name_annee"
                                item-value="id" dense outlined v-model="svData.annee_id" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date d'engagement" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.date_debut_accord">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Nombre de jour accordsé" prepend-inner-icon="event"
                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.nbr_jouraccord">
                              </v-text-field>
                            </div>
                          </v-flex>






                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'Administrateur de Finance"
                                prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                                :items="agentList" item-text="noms_agent" item-value="noms_agent" dense outlined
                                v-model="svData.admin_fin_conge" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le RH" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="noms_agent" dense outlined v-model="svData.rh_conge" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Coordonateur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="noms_agent" dense outlined v-model="svData.coordinateur_conge" chips
                                clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Directeur" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="noms_agent" dense outlined v-model="svData.directeur_conge" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="En Congé" :items="[
                                { designation: 'OUI' },
                                { designation: 'NON' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                dense item-text="designation" item-value="designation"
                                v-model="svData.congess"></v-autocomplete>
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
                      <v-flex md1>
                        <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                  <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab @click="fetchDataList">
                                            <v-icon>autorenew</v-icon>
                                            </v-btn>
                                        </span>
                              </template>
                              <span>Initialiser</span>
                        </v-tooltip>
                      </v-flex>
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
                                <th class="text-left">Circonstance</th>
                                <th class="text-left">DateDemande</th>
                                <th class="text-left">DateDepart</th>
                                <th class="text-left">NbrJourSol</th>
                                <th class="text-left">DateReprise</th>
                                <th class="text-left">Superviseur</th>
                                <th class="text-left">Interimaire</th>
                                <th class="text-left">Coordonateur</th>
                                <th class="text-left">Directeur</th>
                                <th class="text-left">EnCongé</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.nom_circontstance }}</td>
                                <td>{{ item.date_demande }}</td>
                                <td>{{ item.date_depart }}</td>
                                <td>{{ item.nbr_joursollicite }}</td>
                                <td>{{ item.date_reprise }}</td>
                                <td>{{ item.superviseur_conge }}</td>
                                <td>{{ item.interimaire_conge }}</td>
                                <td>{{ item.coordinateur_conge }}</td>
                                <td>{{ item.directeur_conge }}</td>
                                <td>{{ item.congess }}</td>
                                <td>

                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <!-- <v-list-item link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item> -->

                                      <v-list-item link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  red">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="printBill(item.id)">
                                        <v-list-item-icon>
                                          <v-icon>print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Fiche de Congé
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

                        <v-pagination color="blue" v-model="pagination.current" :length="pagination.total"
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
  components: {

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
      affectation_id: 0,
      //  'id','affectation_id','typecircintance_id','description_conge','date_demande','date_depart',
      //'nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge','resumetache_conge',
      //'rh_conge', 'coordinateur_conge','directeur_conge','congess','author'

      ////admin_fin_conge,annee_id,'date_debut_accord','date_fin_accord','nbr_jouraccord',
      //'cumul_conge_annee','solde_conge_datedu','solde_conge_reprise'

      svData: {
        id: '',
        affectation_id: 0,
        typecircintance_id: 0,
        description_conge: '',
        date_demande: '',
        date_depart: '',
        nbr_joursollicite: 0,
        date_reprise: '',
        superviseur_conge: '',
        interimaire_conge: '',
        resumetache_conge: '',
        admin_fin_conge: '',
        rh_conge: '',
        coordinateur_conge: '',
        directeur_conge: '',
        congess: '',
        annee_id: 0,
        date_debut_accord: '',
        nbr_jouraccord: 0,
        author: "Admin",
      },
      fetchData: [],
      circonstanceList: [],
      agentList: [],
      anneeList: [],
      categorieList: [],

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
    // this.fetchListAgent();
    // this.fetchListAnnee();
    // this.fetchListCategorieCirconstance();
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
          this.svData.affectation_id = this.affectation_id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_demandeconge/${this.svData.id}`,
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
          this.svData.affectation_id = this.affectation_id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_demandeconge`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;

        }
      );

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_demandeconge/${id}`).then(
        ({ data }) => {
          // var donnees = data.data;
          // // donnees.map((item) => {
          this.titleComponent = "modification des informations";
          // // });

          this.getSvData(this.svData, data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_demandeconge/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_fiche_conge_agent?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_demandeconge/${this.affectation_id}?page=`);
    },

    fetchListCirconstance() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_typecirconstance_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.circonstanceList = donnees;
        }
      );
    },
    fetchListAnnee() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_annee2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.anneeList = donnees;
        }
      );
    },

    fetchListCategorieCirconstance() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_circonstance2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.categorieList = donnees;

        }
      );
    },
    async get_circonstance_for_Categorie(categorie_id) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_single_circonstance_categorie/${categorie_id}`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.circonstanceList = chart;
          }
          else {
            this.circonstanceList = [];
          }
          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    }

    //fetchListCategorie
  },
  filters: {

  }
}
</script>