<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1200px">
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
              <!--   -->
              <v-flex md12>

                <!-- modal  -->
                <avatarAvatar ref="avatarAvatar" />
                <!-- fin modal -->

                <AvatarProfil ref="avatarPhoto" />

                <v-dialog v-model="dialog" max-width="900px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Annexe <v-spacer></v-spacer>
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
                              <v-text-field label="Heure de Sortie" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureSortie">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Heure de retour Prévue" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureRetourPrevue">
                              </v-text-field>
                            </div>
                          </v-flex>

                          
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date de Sortie" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSortie">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Motif de Sortie" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motif">
                              </v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date de Retour" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateRetour">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Heure de Retour" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureRetour">
                              </v-text-field>
                            </div>
                          </v-flex>


                         
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field label="Annexe justificatif si Necessaire" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelleannexe">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6 class="mb-2">
                            <input class="form-control" type="file" id="photo_input" @change="onImageChange" required />
                            <br />
                            <img :style="{ height: style.height }" id="output" />
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le RH" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_agent" item-value="noms_agent" dense outlined v-model="svData.AG"
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
                          <span>Ajouter une Annexe</span>
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
                                <th class="text-left">Agent</th>
                                <th class="text-left">DateSortie</th>
                                <th class="text-left">HeureSortie</th>
                                <th class="text-left">DateRetour</th>
                                <th class="text-left">HeureRetour</th>
                                <th class="text-left">Annexe</th>
                                <th class="text-left">N°PDF</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.dateSortie }}</td>
                                <td>{{ item.heureSortie }}</td>
                                <td>{{ item.dateRetour }}</td>
                                <td>{{ item.heureRetour }}</td>
                                <td>{{ item.libelleannexe }}</td>
                                <td>{{ item.annexeSortie }}</td>
                                <td>

                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="printBill(item.annexeSortie)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Voir Annexe</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="printFiche(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bon de Sortie</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item    link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item   link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  red">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Annuler</v-list-item-title>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from '../Patients/AvatarProfil.vue';
import avatarAvatar from '../Patients/AvatarAction.vue';
export default {
  components: {
    AvatarProfil,
    avatarAvatar,
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
      style: {
        height: "0px",
      },
      //id,refAffectation,heureSortie,heureRetourPrevue,dateSortie,motif,heureRetour,
      //dateRetour,annexeSortie,libelleannexe,viseBRH,author
      svData: {
        id: '',        
        refAffectation: 0,
        heureSortie: '',
        heureRetourPrevue: "",
        dateSortie: '',
        motif:'',
        heureRetour: '',
        dateRetour:'',
        libelleannexe:'',
        viseBRH: '',
        author: ""
      },
      fetchData: [],
      image: "",
      medecinList: [],
      editor: ClassicEditor,
      don: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    //this.fetchDataList();
    //this.fetchListSelection();
  },
  computed: {
    ...mapGetters(["categoryList", "ListeEdition", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),

    updatePhoto() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("data", JSON.stringify(this.svData));
      formData.append("image", this.image);

      if (this.edit == true) {
        this.svData.refAffectation = this.refAffectation;
        this.svData.author = this.userData.name;
        axios
          .post(`${this.apiBaseURL}/update_sortieAgent`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.showMsg(data.data);

            this.fetchDataList();
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);

            this.dialog = false;

            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
      }
      else {
        this.svData.refAffectation = this.refAffectation;
        this.svData.author = this.userData.name;
        axios
          .post(`${this.apiBaseURL}/insert_sortieAgent`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.showMsg(data.data);

            this.fetchDataList();
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.dialog = false;

            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
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

    validate() {
      if (this.$refs.form.validate()) {
        // this.isLoading(true);

        if (this.edit) {
          this.updatePhoto();
          this.dialog = false;
        } else {
          this.updatePhoto();
          this.dialog = false;
        }
      }
    },

    onImageChange(e) {
      this.image = e.target.files[0];
      let output = document.getElementById("output");
      output.src = URL.createObjectURL(e.target.files[0]);
      output.onload = function () {
        URL.revokeObjectURL(output.src);
        this.style.height = "240px"; // free memory
      };
    },

    showProfileModal(id, name, created) {

      if (id != null) {

        this.$refs.avatarPhoto.$data.dialog = true;
        this.$refs.avatarPhoto.$data.svData.id = id;
        this.$refs.avatarPhoto.$data.svData.created = created;
        this.$refs.avatarPhoto.display_profile(id);

        this.$refs.avatarPhoto.$data.titleComponent =
          "Détail du Profile  ";

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showProfileModalclient(id, name) {

      if (id != null) {

        this.$refs.avatarAvatar.$data.dialog = true;
        this.$refs.avatarAvatar.$data.svData.id = id;
        this.$refs.avatarAvatar.display_profile(id);

        this.$refs.avatarAvatar.$data.titleComponent =
          "Détail du Profile de " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    printBill(filenamess) {
      window.open(`${this.apiBaseURL}/downloadfile_imagerie/${filenamess}`);
    },

    printFiche(id) {
      window.open(`${this.apiBaseURL}/pdf_bon_sortie_agent?id=` + id);
    },
//libelleannexe
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_sortieAgent/${id}`).then(
        ({ data }) => {
          var donnees = data.data;  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.motif;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_sortieAgent/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_sortieAgent/${this.refAffectation}?page=`);
      //
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

        }
      );

    },
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tperso_sortie_agent';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression de la fiche de demande de sortie de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;

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
<style scoped>
.mb-2 {
  margin-top: 10px;
}

.form-control {
  display: block;
  width: 100%;
  height: calc(1.5em + .75rem + 2px);
  padding: .375rem .75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}
</style>
  
  