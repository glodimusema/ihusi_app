<template>
  <div>

    <v-layout>

      <v-flex md12>

        <EntetePaiementSalaire ref="EntetePaiementSalaire" />
        <PaiementSalaire ref="PaiementSalaire" />

        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Fiche de Paie <v-spacer></v-spacer>
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
                      <v-autocomplete label="Selectionnez le Mois" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="moisList" item-text="name_mois"
                        item-value="id" dense outlined v-model="svData.refMois" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="mdi-map" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList" item-text="name_annee"
                        item-value="id" outlined v-model="svData.refAnne">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                        <v-select label="Specification" :items="[
                                { designation: 'TOUS' },
                                { designation: 'PAR COORDINATION' },
                                { designation: 'PAR SERVICE' }
                              ]" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.check"></v-select>
                        </div>
                </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map" dense
                       :items="CategorieServList"
                        item-text="name_categorie_service" item-value="id" outlined v-model="svData.refCatService" 
                        @change="fetchListServiceForCategorie(svData.refCatService)">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                        :items="ServiceList" item-text="name_serv_perso"
                        item-value="id" dense outlined v-model="svData.refServicePerso" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation"
                      item-value="designation" dense outlined v-model="svData.modepaie" chips
                       clearable @change="get_Banque(svData.modepaie)">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque" item-value="id"
                      dense outlined v-model="svData.refBanque" chips clearable>
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
        <br /><br />
        <v-layout>

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
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                  outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                  <span>Ajouter</span>
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
                        <th class="text-left">DatePaie</th>
                        <th class="text-left">Mois</th>
                        <th class="text-left">Année</th>
                        <th class="text-left">ModePaie</th>
                        <th class="text-left">Compte</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.dateFiche }}</td>
                        <td>{{ item.name_mois }}</td>
                        <td>{{ item.name_annee }}</td>
                        <td>{{ item.nom_mode }}</td>
                        <td>{{ item.nom_banque }}</td>
                        <td>{{ item.author }}</td>
                        <td>

                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <!-- <v-list-item link @click="showEntetePaiementSalaire(item.id, item.noms_agent)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Paiement Agent
                                </v-list-item-title>
                              </v-list-item> -->

                              <v-list-item link @click="showPaiementSalaire(item.id, item.name_mois)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Paiement Agent
                                      </v-list-item-title>
                                    </v-list-item>

                              <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item   link @click="desactiverData(item.id, item.author, item.created_at, item.dateFiche)">
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import EntetePaiementSalaire from './EntetePaiementSalaire.vue';
import PaiementSalaire from "./PaiementSalaire.vue";

export default {
  components: {
    EntetePaiementSalaire,
    PaiementSalaire
  },
  data() {
    return {

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refMois,refAnne,author
      svData: {
        id: '',
        refMois: 0,
        refAnne: 0,
        author: "",
        refCatService: 0,
        refServicePerso: 0,
        check: '',
        modepaie: "",
        refBanque:0,
      },
      fetchData: [],
      anneeList: [],
      moisList: [],
      CategorieServList: [],
      ServiceList: [],
      ModeList: [],
      BanqueList: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListSelection();
    this.fetchListCategorie();
    this.fetchListMois();
    this.get_mode_Paiement();
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
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_FichePaie/${this.svData.id}`,
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
          //insert_Global_Paie_Salaire
          if(this.svData.check == 'TOUS')
          {
            this.svData.author = this.userData.name;
              this.insertOrUpdate(
                // `${this.apiBaseURL}/insert_Global_FichePaie`,
                `${this.apiBaseURL}/insert_Global_Paie_Salaire`,
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
          if(this.svData.check == 'PAR COORDINATION')
          {
              if(this.svData.refCatService > 0)
              {
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                  // `${this.apiBaseURL}/insert_Global_FichePaie`,
                  `${this.apiBaseURL}/insert_Global_Paie_Salaire`,
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
              else
              {
                this.showError("Veillez sélectionner la Coordination ou la division svp");
              }
          }
          if(this.svData.check == 'PAR SERVICE')
          {
            if(this.svData.refServicePerso > 0)
            {
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                // `${this.apiBaseURL}/insert_Global_FichePaie`,
                `${this.apiBaseURL}/insert_Global_Paie_Salaire`,
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
            else
            {
              this.showError("Veillez sélectionner le service svp");
            }
              
          } 

        }

      }
    },
    showPaiementSalaire(refFichePaie, name) {

        if (refFichePaie != '') {

          this.$refs.PaiementSalaire.$data.etatModal = true;
          this.$refs.PaiementSalaire.$data.refFichePaie = refFichePaie;
          this.$refs.PaiementSalaire.$data.svData.refFichePaie = refFichePaie;
          this.$refs.PaiementSalaire.fetchDataList();
          this.$refs.PaiementSalaire.fetchListAgent();
          this.fetchDataList();
          
          this.$refs.PaiementSalaire.$data.titleComponent =
            "Paiement Salaire pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_FichePaie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.montant = item.montant;
            this.svData.refAnne = item.refAnne;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_FichePaie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_FichePaie?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_annee2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.anneeList = donnees;

        }
      );
    },
    fetchListMois() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mois`).then(
        ({ data }) => {
          var donnees = data.data;
          this.moisList = donnees;
        }
      );
    },
    showEntetePaiementSalaire(refFichePaie, name) {

      if (refFichePaie != '') {

        this.$refs.EntetePaiementSalaire.$data.etatModal = true;
        this.$refs.EntetePaiementSalaire.$data.refFichePaie = refFichePaie;
        this.$refs.EntetePaiementSalaire.$data.svData.refFichePaie = refFichePaie;
        this.$refs.EntetePaiementSalaire.fetchDataList();
        this.$refs.EntetePaiementSalaire.fetchListSelection();
        this.fetchDataList();

        this.$refs.EntetePaiementSalaire.$data.titleComponent =
          "Paiement Salaire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    fetchListCategorie() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_service_personnel_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.CategorieServList = donnees;

        }
      );
    },
    fetchListServiceForCategorie(refCatService) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel_categorie/${refCatService}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.ServiceList = donnees;

        }
      );
    },
    async get_mode_Paiement() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.ModeList = chart;
          } else {
            this.ModeList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
      async get_Banque(nom_mode) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.BanqueList = chart;
              } else {
                  this.BanqueList = [];
              }
              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tperso_fiche_paie';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression de la fiche de Paiement en date du : "+noms+" par l'utilisateur "+user_name+"" ;

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
  
  