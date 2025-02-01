<template>
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

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" dense
                        item-text="name_service" item-value="id" outlined v-model="svData.service_id">
                    </v-autocomplete>
                  </div>
                </v-flex>              
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Designation Archive" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.name_archive">
                    </v-text-field>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Description Archive" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.description_archive">
                    </v-text-field>
                  </div>
                </v-flex> 

                <v-flex xs12 sm12 md12 lg12 class="mb-2">
                  <input class="form-control" type="file" id="photo_input" @change="onImageChange" required />
                  <br />
                  <img :style="{ height: style.height }" id="output" />
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
            <v-flex md12>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                clearable></v-text-field>
            </v-flex>
            <hr />      
            <hr />
            <hr />
            <hr />
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
                <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" dense
                        item-text="name_service" item-value="id" outlined v-model="svData.service_id">
                    </v-autocomplete>
              </v-flex> 
             
              <hr />
              <hr />
              <hr />
              <v-flex md4>
                <v-btn color="blue" dark :loading="loading" @click="fetchDataListFilter">
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
                      <th class="text-left">Designation</th>
                      <th class="text-left">Description</th>
                      <th class="text-left">Service</th>
                      <th class="text-left">Division</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">Date</th>
                      <th class="text-left">N°PDF</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.name_archive }}</td>
                      <td>{{ item.description_archive }}</td>
                      <td>{{ item.name_service }}</td>
                      <td>{{ item.name_division }}</td>
                      <td>{{ item.name_categorie }}</td>
                      <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>
                      <td>{{ item.fichier_archive }}</td>
                      <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="printBill(item.fichier_archive)">
                              <v-list-item-icon>
                                <v-icon color="  blue">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Voir Annexe</v-list-item-title>
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
        style: {
          height: "0px",
        },
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author
        svData: {
          id: '',          
          service_id: 0,
          name_archive: '',
          description_archive: '',
          author: "",
          date1:'',
          date2:''
        },
        fetchData: [],
        serviceList: [],
        image: "",
        editor: ClassicEditor,
        don: [],
        query: ""
  
      }
    },
    created() {       
      this.fetchDataList();
      this.fetchListServices();
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
          this.svData.author = this.userData.name;
          axios
            .post(`${this.apiBaseURL}/update_archivages`, formData, config)
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
          this.svData.author = this.userData.name;
          axios
            .post(`${this.apiBaseURL}/insert_archivages`, formData, config)
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
    fetchDataListFilter() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_service_filter_archivages?date1=` + this.svData.date1 + "&date2=" + this.svData.date2 + "&service_id=" + this.svData.service_id + "&page=");
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
        fetchListServices() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_archivage2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                    //serviceList
                }
            );
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
        window.open(`${this.apiBaseURL}/downloadfile/${filenamess}`);
      },
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_archivages/${id}`).then(
          ({ data }) => {
            this.titleComponent = "modification des informations";
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_archivages/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      }, 
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_all_archivages?page=`);
        //
      },
      desactiverData(valeurs,user_created,date_entree,noms) {
  //
        var tables='tperso_dependant';
        var user_name=this.userData.name;
        var user_id=this.userData.id;
        var detail_information="Suppression de la fiche des dependants de l'agent : "+noms+" par l'utilisateur "+user_name+"" ;
  
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
    
    