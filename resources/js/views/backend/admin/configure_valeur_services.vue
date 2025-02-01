<template>
    <v-layout>
      <v-flex md12>
        <v-dialog
          v-model="dialog"
          max-width="600px"
          hide-overlay
          transition="dialog-bottom-transition"
          
        >
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                {{ titleComponent }} <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip></v-card-title
              >
              <v-card-text max-height="1000px">
                <v-container>
                  <v-layout row wrap>
                    <v-flex xs12 md12 sm12 lg12>
  
                      <v-flex xs12 md12 sm12 lg12>
                          <v-text-field
                          label="Le nom"
                          prepend-inner-icon="edit_note"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined
                          v-model="svData.nom"
                          ></v-text-field>
                      </v-flex>

                      <v-flex xs12 md12 sm12 lg12>
                        <v-text-field
                          label="Le titre"
                          prepend-inner-icon="draw"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined
                          v-model="svData.titre"
                        ></v-text-field>
                      </v-flex>

                      <v-flex xs12 md12 sm12 lg12>
                        <!-- <v-textarea
                          label="Description"
                          rows="1"
                          prepend-inner-icon="history_edu"
                          outlined
                          v-model="svData.description"
                          :rules="[(v) => !!v || 'Ce champ est requis']"

                        ></v-textarea>  -->
  
                         <ckeditor
                          label="Description"
                          :editor="editor"
                          v-html="svData.description"
                          v-model="svData.description"
                          :config="editorConfig"
                        ></ckeditor>
                      </v-flex>
                      
                      
                      </v-flex>
                      
  
                    
  
                    <v-flex xs12 md12 sm12 lg12 class="mb-2">
                      <input
                        class="form-control"
                        type="file"
                        id="photo_input"
                        @change="onImageChange"
                        required
                      />
                      <br />
                      <img :style="{ height: style.height }" id="output" />
  
                    
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="primary" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <br /><br />
        <v-layout>
          <v-layout>
            <v-flex md1></v-flex>
            <v-flex md10></v-flex>
            <v-flex md1></v-flex>
          </v-layout>
  
          <v-flex md12>
            <!-- bande -->
            <v-layout>
              <v-flex md1>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn :loading="loading" fab @click="onPageChange">
                        <v-icon>autorenew</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Initialiser</span>
                </v-tooltip>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  append-icon="search"
                  label="Recherche..."
                  single-line
                  solo
                  outlined
                  rounded
                  hide-details
                  v-model="query"
                  @keyup="searchMember"
                  clearable
                ></v-text-field>
              </v-flex>
  
              <v-flex md6></v-flex>
  
              <v-flex md1>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="showModal" fab color="primary">
                        <v-icon>add</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Ajouter une opération</span>
                </v-tooltip>
              </v-flex>
            </v-layout>
            <!-- bande -->
  
            <br />
            <v-card :loading="loading" :disabled="isloading">
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th class="text-left">Nom</th>
                        <th class="text-left">Titre</th>
                        <th class="text-left">Description</th>
                        
                        <th>Mise à jour</th>
  
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>
                          
                          <!-- image -->
                          <img
                            style="border-radius: 50px; width: 50px; height: 50px"
                            :src="
                              item.photo == null
                                ? `${baseURL}/fichier/avatar.png`
                                : `${baseURL}/fichier/` + item.photo
                            "
                          />
                          <!-- images -->
                        </td>
                        <td>{{ item.nom | subStrLong2 }}</td>
                        <td>{{ item.titre | subStrLong2 }}</td>
                        <td>{{ item.description | subStrLong2 }}</td>
                       
                        <td>
                          {{ item.created_at | formatDate }}
                          {{ item.created_at | formatHour }}
                        </td>
  
                        <td>
                          <v-tooltip top color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="editData(item.id)" fab small
                                  ><v-icon color="primary">edit</v-icon></v-btn
                                >
                              </span>
                            </template>
                            <span>Modifier</span>
                          </v-tooltip>
  
                          <v-tooltip top color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="clearP(item.id)" fab small
                                  ><v-icon color="red">delete</v-icon></v-btn
                                >
                              </span>
                            </template>
                            <span>Supprimer</span>
                          </v-tooltip>
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <hr />
  
                <v-pagination
                  color="primary"
                  v-model="pagination.current"
                  :length="pagination.total"
                  @input="onPageChange"
                ></v-pagination>
              </v-card-text>
            </v-card>
            <!-- les composants -->
  
            <!-- fin des composants -->
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </template>
  
  <script>
  import { mapGetters, mapActions } from "vuex";
  import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
  
  export default {
    components: {},
    data() {
      return {
        header: "crud operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        style: {
          height: "0px",
        },
        svData: {
          id: "",
          nom: "",
          titre:"",
          description: "",
          
        },
        fetchData: null,
        titreModal: "",
        image: "",
        editor: ClassicEditor,
        editorConfig: {
          // The configuration of the editor.
          //  toolbar: [ 'bold', 'italic', '|', 'link' ]
        },
      };
    },
  
    computed: {
      ...mapGetters(["basicList", "isloading"]),
    },
    methods: {
      ...mapActions(["getBasic"]),
  
     
      showModal() {
        this.dialog = true;
        this.titleComponent = "Paramètrage services de l'entreprise ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de services de l'entreprise ";
          this.style.height = "0px";
        } else {
          this.titleComponent = "Paramètrage services de l'entreprise ";
          this.style.height = "0px";
        }
      },
  
      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_valeur_service?page=`);
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
  
      updatePhoto() {
        const config = {
          headers: { "content-type": "multipart/form-data" },
        };
  
        let formData = new FormData();
        formData.append("data", JSON.stringify(this.svData));
        formData.append("image", this.image);
  
        if (this.edit == true) {
          axios
            .post(`${this.apiBaseURL}/update_valeur_service`, formData, config)
            .then(({ data }) => {
              this.image = "";
              this.showMsg(data.data);
  
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
  
              this.dialog = false;
  
              // setTimeout(() => window.location.reload(), 2000);
              document.getElementById("photo_input").value = "";
              document.getElementById("output").src = "";
            })
            .catch((err) => this.svErr());
        } else {
          axios
            .post(`${this.apiBaseURL}/insert_valeur_service`, formData, config)
            .then(({ data }) => {
              this.image = "";
              this.showMsg(data.data);
  
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
              this.dialog = false;
  
              // setTimeout(() => window.location.reload(), 2000);
              document.getElementById("photo_input").value = "";
              document.getElementById("output").src = "";
            })
            .catch((err) => this.svErr());
        }
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          if (this.edit) {
            this.updatePhoto();
          } else {
            this.updatePhoto();
          }
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_valeur_service/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.svData.id = item.id;
              this.titleComponent = "modification de services de l'entreprise ";
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_valeur_service/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
      editTitleModal(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_valeur_service/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.titleComponent = "modification de services de l'entreprise";
            });
          }
        );
      },
    },
    created() {
      this.onPageChange();
      this.testTitle();
      this.onPageChange();
    },
  };
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