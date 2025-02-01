<template>
  <v-row justify="center">

    <CongeAnnuel ref="CongeAnnuel" />
    <CongeFamillial ref="CongeFamillial" />
    <CongeMaternite ref="CongeMaternite" />
    <MaladieConge ref="MaladieConge" />
    <AutresConge ref="AutresConge" />

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
                        Entete Conge <v-spacer></v-spacer>
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
                              <v-text-field type="date" label="Date jour d'Absence" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateJourAbsent">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date dernier Jour" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateDernierJour">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Retour" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateRetour">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'année" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList"
                                item-text="name_annee" item-value="id" dense outlined v-model="svData.refAnne"
                                chips clearable>
                              </v-autocomplete>
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
                              <v-autocomplete label="Selectionnez le Remplacant" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.remplacement"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Chef de Service" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.chefService"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le chef Hierarchique" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.hierarchie"
                                chips clearable>
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
                                <th class="text-left">Année</th>
                                <th class="text-left">DateAbsence</th>
                                <th class="text-left">DateRetour</th>
                                <th class="text-left">Controle</th>
                                <th class="text-left">Remplancant</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.name_serv_perso }}</td>
                                <td>{{ item.name_annee }}</td>
                                <td>{{ item.dateJourAbsent }}</td>  
                                <td>{{ item.dateRetour }}</td>
                                <td>{{ item.controle }}</td>
                                <td>{{ item.remplacement }}</td>                              
                                <td>

                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link @click="showCongeAnnuel(item.id, item.noms_agent)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Congé annuel
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showCongeFamillial(item.id, item.noms_agent)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Congé de circontance(Famille)
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showCongeMaternite(item.id, item.noms_agent)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Congé de Maternité
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showMaladieConge(item.id, item.noms_agent)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Congé de Maladie
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showAutresConge(item.id, item.noms_agent)">
                                      <v-list-item-icon>
                                        <v-icon color="  blue">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Autres Congés
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
import AutresConge from './AutresConge.vue';
import CongeAnnuel from './CongeAnnuel.vue';
import CongeFamillial from './CongeFamillial.vue';
import CongeMaternite from './CongeMaternite.vue';
import MaladieConge from './MaladieConge.vue';

export default {
  components:{
    CongeAnnuel,
    CongeFamillial,
    CongeMaternite,
    MaladieConge,
    AutresConge
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
      refAffectation: 0,

      //id,refAffectation,refAnne,dateJourAbsent,dateDernierJour,dateRetour,controle,agent,remplacement,chefService,hierarchie,author

      svData: {
        id: '',
        refAffectation: 0,
        refAnne: '',
        dateJourAbsent:'',
        dateDernierJour:'',
        dateRetour:'',
        agent:'',
        remplacement:'',
        chefService:'',
        hierarchie:'',
        author: ''
      },
      fetchData: [],
      anneeList: [],
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
    // this.fetchListAnnee();
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
          this.svData.refAffectation = this.refAffectation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_EnteteConge/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_EnteteConge`,
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
      fetchAccess() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_crud_access_roles_one/${this.userData.id_role}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
          this.inserer = item.insert;
          this.modifier = item.update;
          this.supprimer = item.delete;
          this.chargement = item.load;
        });

          console.log(donnees);
        }
      );
    },
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

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
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_EnteteConge/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAffectation = item.refAffectation;
            this.svData.refAnne = item.refAnne;
            this.svData.dateDernierJour = item.dateDernierJour;
            this.svData.dateJourAbsent = item.dateJourAbsent;
            this.svData.dateRetour = item.dateRetour;
            this.svData.remplacement = item.remplacement;
            this.svData.agent = item.agent;
            this.svData.chefService = item.chefService;
            this.svData.hierarchie = item.hierarchie;            
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_EnteteConge/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_EnteteConge/${this.refAffectation}?page=`);
    },
    showCongeAnnuel(refEnteteConge, name) {

        if (refEnteteConge != '') {

          this.$refs.CongeAnnuel.$data.etatModal = true;
          this.$refs.CongeAnnuel.$data.refEnteteConge = refEnteteConge;
          this.$refs.CongeAnnuel.$data.svData.refEnteteConge = refEnteteConge;
          this.$refs.CongeAnnuel.fetchDataList();
          // this.$refs.CongeAnnuel.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.CongeAnnuel.$data.titleComponent =
            "Congé annuel pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showCongeFamillial(refEnteteConge, name) {

        if (refEnteteConge != '') {

          this.$refs.CongeFamillial.$data.etatModal = true;
          this.$refs.CongeFamillial.$data.refEnteteConge = refEnteteConge;
          this.$refs.CongeFamillial.$data.svData.refEnteteConge = refEnteteConge;
          this.$refs.CongeFamillial.fetchDataList();
          this.$refs.CongeFamillial.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.CongeFamillial.$data.titleComponent =
            "Congé de Circonstance pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showCongeMaternite(refEnteteConge, name) {

        if (refEnteteConge != '') {

          this.$refs.CongeMaternite.$data.etatModal = true;
          this.$refs.CongeMaternite.$data.refEnteteConge = refEnteteConge;
          this.$refs.CongeMaternite.$data.svData.refEnteteConge = refEnteteConge;
          this.$refs.CongeMaternite.fetchDataList();
          // this.$refs.CongeMaternite.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.CongeMaternite.$data.titleComponent =
            "Congé de Maternité pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showMaladieConge(refEnteteConge, name) {

        if (refEnteteConge != '') {

          this.$refs.MaladieConge.$data.etatModal = true;
          this.$refs.MaladieConge.$data.refEnteteConge = refEnteteConge;
          this.$refs.MaladieConge.$data.svData.refEnteteConge = refEnteteConge;
          this.$refs.MaladieConge.fetchDataList();
          // this.$refs.MaladieConge.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.MaladieConge.$data.titleComponent =
            "Congé de Maladie pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showAutresConge(refEnteteConge, name) {

        if (refEnteteConge != '') {

          this.$refs.AutresConge.$data.etatModal = true;
          this.$refs.AutresConge.$data.refEnteteConge = refEnteteConge;
          this.$refs.AutresConge.$data.svData.refEnteteConge = refEnteteConge;
          this.$refs.AutresConge.fetchDataList();
          // this.$refs.AutresConge.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.AutresConge.$data.titleComponent =
            "Autres Congés pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tperso_entete_conge';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression de la fiche d'entete congé de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;

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

    // <!-- CongeAnnuel,
    // CongeFamillial,
    // CongeMaternite,
    // MaladieConge,
    // AutresConge -->

  }
}
</script>
  
  