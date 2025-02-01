<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- container -->

        <v-card-title class="info">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etatModal = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout -->

          <div>

            <v-layout>
              <!--   -->
              <v-flex md12>
                <v-dialog v-model="dialog" max-width="1200px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Rapport Medical <v-spacer></v-spacer>
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
                              <v-textarea label="Plaintes Principales" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.plainte_med">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Historique" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.historique_med">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Antécédents (Medicaux, Chirurgiecaux, etc.)"
                                prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.antecedent_med">
                              </v-textarea>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Examen Physique" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.examenphysique_med">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Diagnostic" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.diagnostic_med"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Examens Paracliniques" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.examenparaclinique_med"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Traitement" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.traitement_med"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Evolution" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.evolution_med"></v-textarea>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Hospitalisation" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_med">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Conclusion" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle_med">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Nom du medecin" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medecin_med">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Specialité Medecin " prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_med">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="CNOM Medecin " prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cnom_med">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Nom de la Structure Sanitaire" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Hopital">
                              </v-text-field>
                            </div>
                          </v-flex>


                        </v-layout>


                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                        <v-btn color="blue" dark :loading="loading" @click="validate">
                          {{ edit ? "Modifier" : "Ajouter" }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <br /><br />
                <v-layout>

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
                              <v-btn @click="dialog = true" fab color="blue" dark>
                                <v-icon>add</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Ajouter Resumé</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card>
                      <!-- ,'ValeurNormale2','observation2' -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Nom</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">GroupeS.</th>
                                <th class="text-left">DateHospi</th>
                                <th class="text-left">Medecin</th>
                                <th class="text-left">Specialité</th>
                                <th class="text-left">CNOM</th>
                                <th class="text-left">Hopital</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_profil }}</td>
                                <td>{{ item.sexe_profil }}</td>
                                <td>{{ item.age_profil }}</td>
                                <td>{{ item.groupesanguin }}</td>
                                <td>{{ item.date_med }}</td>
                                <td>{{ item.medecin_med }}</td>
                                <td>{{ item.specialite_med }}</td>
                                <td>{{ item.cnom_med }}</td>
                                <td>{{ item.Hopital }}</td>
                                <td>
                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <!-- <v-list-item link @click="printBill(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="blue">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Voir le Rapport
                                          Medical</v-list-item-title>
                                      </v-list-item> -->

                                      <v-list-item  link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="red">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
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
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refPatient: "",
      svData: {
        id: '',
        refPatient: "",
        plainte_med: "",
        historique_med: "",
        antecedent_med: "",
        examenphysique_med: "",
        diagnostic_med: "",
        examenparaclinique_med: "",
        traitement_med: "",
        evolution_med: "",
        libelle_med: "",
        date_med: "",
        medecin_med: "",
        specialite_med: "",
        cnom_med: "",
        author: "",
        Hopital: ""
      },
      fetchData: [],
      medecinList: [],
      don: [],
      query: "",
      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: '',


    }
  },
  created() {
    // this.fetchDataList();

  },
  computed: {
    ...mapGetters(["basicList", "paysList",
      "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
  },
  methods: {

    ...mapActions(["getBasic", "getEntrepriseList", "getMyEntrepriseList"]),

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.refPatient = this.refPatient;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_rapportmedical`,
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
          this.svData.refPatient = this.refPatient;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_rapportmedical`,
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_rapportmedical_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_rapportmedical/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refPatient = item.refPatient;
            this.svData.plainte_med = item.plainte_med;
            this.svData.historique_med = item.historique_med;
            this.svData.antecedent_med = item.antecedent_med;
            this.svData.examenphysique_med = item.examenphysique_med;
            this.svData.diagnostic_med = item.diagnostic_med;
            this.svData.examenparaclinique_med = item.examenparaclinique_med;
            this.svData.traitement_med = item.traitement_med;
            this.svData.evolution_med = item.evolution_med;
            this.svData.libelle_med = item.libelle_med;
            this.svData.date_med = item.date_med;
            this.svData.medecin_med = item.medecin_med;
            this.svData.specialite_med = item.specialite_med;
            this.svData.cnom_med = item.cnom_med;
            this.svData.Hopital = item.Hopital;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_rapportmedical/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      // this.fetch_data(`${this.apiBaseURL}/fetch_rapportmedical_malade?page=`);
      this.fetch_data(`${this.apiBaseURL}/fetch_rapportmedical_cons/${this.refPatient}?page=`);
      //fetch_rapportmedical_malade
    }


  },
  filters: {

  }
}
</script>
  
  