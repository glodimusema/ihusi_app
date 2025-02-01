<template>
  <v-layout>
    
    <v-flex md12>
      <v-flex md12>
        <!-- modal -->
        <v-dialog
          v-model="dialog"
          max-width="700px"
          transition="dialog-bottom-transition"
          fullscreen
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
              <v-card-text>
                <v-layout row wrap>
                  

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le CEO" prepend-inner-icon="mdi-map" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="name" item-value="id"
                        outlined v-model="svData.ceo">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Nom de l'entreprise"
                        prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.nomEntreprise"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Email de l'entreprise"
                        type="email"
                        prepend-inner-icon="mail"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.emailEntreprise"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="N° Téléphone de l'entreprise"
                        prepend-inner-icon="perm_phone_msg"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.telephoneEntreprise"
                      ></v-text-field>
                    </div>
                  </v-flex>

                   <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Adresse domicile de l'entreprise"
                        prepend-inner-icon="push_pin"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.adresseEntreprise"
                      ></v-text-field>
                    </div>
                  </v-flex>

                   <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="N° RCCM de l'entreprise"
                        prepend-inner-icon="moving"
                        outlined
                        dense
                        v-model="svData.rccm"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-select
                        :items="ListeNBREmploye"
                        label="Nombre d'employé"
                        prepend-inner-icon="group"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        chips
                        dense
                        item-text="text"
                        item-value="designation"
                        v-model="svData.nbremploye"
                      ></v-select>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-select
                        :items="ListeEdition"
                        label="Selectionnez l'édition"
                        prepend-inner-icon="tips_and_updates"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        chips
                        dense
                        item-text="text"
                        item-value="designation"
                        v-model="svData.edition"
                      ></v-select>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete
                        label="Selectionnez la forme juridique "
                        prepend-inner-icon="local_post_office"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        :items="formeJuridiqueList"
                        item-text="nomForme"
                        item-value="id"
                        dense
                        outlined
                        v-model="svData.idforme"
                        clearable
                        chips
                      >
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete
                        label="Selectionnez le secteur d'activité "
                        prepend-inner-icon="local_laundry_service"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        :items="secteurList"
                        item-text="nomSecteur"
                        item-value="id"
                        dense
                        outlined
                        v-model="svData.idsecteur"
                        clearable
                        chips
                      >
                      </v-autocomplete>
                    </div>
                  </v-flex>
                 

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete
                        label="Selectionnez le Pays"
                        prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        :items="paysList"
                        item-text="nomPays"
                        item-value="id"
                        dense
                        outlined
                        v-model="svData.idPays"
                        chips
                        clearable
                        @change="get_data_tug_pays(svData.idPays)"
                      >
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete
                        label="Selectionnez la province"
                        prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        :items="stataData.provinceList"
                        item-text="nomProvince"
                        item-value="id"
                        dense
                        outlined
                        v-model="svData.idProvince"
                        clearable
                        chips
                       
                      >
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Page facebook de l'entreprise"
                        type="url"
                        prepend-inner-icon="language"
                        outlined
                        dense
                        v-model="svData.facebook"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Page twitter de l'entreprise"
                        type="url"
                        prepend-inner-icon="language"
                        outlined
                        dense
                        v-model="svData.twitter"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Page linkedin de l'entreprise"
                        type="url"
                        prepend-inner-icon="language"
                        outlined
                        dense
                        v-model="svData.linkedin"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Site web de l'entreprise"
                        type="url"
                        prepend-inner-icon="language"
                        outlined
                        dense
                        v-model="svData.siteweb"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Investissement Personnel de l'entreprise"
                        type="number"
                        min="0"
                        prepend-inner-icon="paid"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.invPersonnel"
                      ></v-text-field>
                    </div>
                  </v-flex>

                   <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Investissement au compte de l'entreprise"
                        type="number"
                        min="0"
                        prepend-inner-icon="paid"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.invHub"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Investissement Recheché"
                        type="number"
                        min="0"
                        prepend-inner-icon="payments"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.invRecherche"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                      <v-text-field
                        label="Chiffre d'affaire annuel généré par l'entreprise "
                        type="number"
                        min="0"
                        prepend-inner-icon="attach_money"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        dense
                        v-model="svData.chiffreAffaire"
                      ></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                       <v-textarea
                            label="Description de l'entreprise "
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            rows="1"
                            prepend-inner-icon="description"
                            outlined
                            dense
                            v-model="svData.descriptionEntreprise"
                        ></v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm6 md6 lg6>
                    <div class="mr-1">
                       <v-textarea
                            label="La solution proposée par l'entreprise "
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            rows="1"
                            prepend-inner-icon="emoji_objects"
                            outlined
                            dense
                            v-model="svData.solutionEntreprise"
                        ></v-textarea>
                    </div>
                  </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <input
                                class="form-control"
                                type="file"
                                id="photo_input"
                                @change="onImageChange"
                            
                            /> 
                            <br />
                            <img :style="{ height: style.height }" id="output" />
                        </div>
                    </v-flex>

                   
                        



                  
                </v-layout>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn
                  color="primary"
                  dark
                  :loading="loading"
                  @click="validate"
                >
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        
        <!-- fin modal -->

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
          <v-flex md5>
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

          <v-flex md5></v-flex>

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
                    <th class="text-left">Logo</th>
                    <th class="text-left">Nom de l'entreprise</th>
                    <th class="text-left">Nom de la province</th>
                    <th class="text-left">Etat</th>
                    <th class="text-left">Edition</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>
                        <!-- <v-avatar color="red">
                          <span class="white--text text-h5">
                            {{ item.nomEntreprise | subStr }}
                          </span>
                        </v-avatar> -->

                        <!-- image -->
                        <img
                          style="border-radius: 50px; width: 50px; height: 50px"
                          :src="
                            item.logo == null
                              ? `${baseURL}/images/logo.png`
                              : `${baseURL}/images/` + item.logo
                          "
                        />
                        <!-- images -->
                    </td>
                    <td>{{ item.nomEntreprise }}</td>
                    <td>{{ item.nomProvince }}</td>
                    <td>
                        <v-badge
                          bordered
                          color="primary"
                          icon="home"
                          overlap
                        >
                          <v-btn
                            elevation="2"
                            x-small
                            class="white--text"
                            :color="item.etat == 1 ? 'success' : 'error'"
                            depressed
                            @click="operationEtat(item.id, item.etat)"
                          >
                            {{ item.etat == 1 ? "Activée " : "Non activée" }}
                          </v-btn>
                        </v-badge>
                      </td>
                    <td>{{ item.edition }}</td>
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

                      <v-menu
                            bottom
                            rounded
                            offset-y
                            transition="scale-transition"
                        >
                            <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                            </template>

                            <v-list dense width="">
                                <v-list-item
                                    link
                                    :to="'/admin/entreprise_detail/' + item.slug"
                                >
                                    <v-list-item-icon>
                                    <v-icon>description</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px"
                                    >Detail de l'entreprise</v-list-item-title
                                    >
                                </v-list-item>


                                <v-list-item
                                    
                                    link
                                    @click="printBill(item.slug)"
                                    
                                >
                                    <v-list-item-icon>
                                        <v-icon>print</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px"
                                    >PDF Rapport</v-list-item-title
                                    >
                                </v-list-item>

                               
                            </v-list>
                        </v-menu>

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
              :total-visible="7"
              @input="onPageChange"
            ></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
   
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Pays component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        ceo: "",
        nomEntreprise: "",
        descriptionEntreprise: "",
        emailEntreprise: "",
        telephoneEntreprise: "",
        solutionEntreprise: "",
        rccm: "",
        idsecteur: "",
        idforme: "",
        idPays: "",
        idProvince: "",
        edition: "",
        facebook: "",
        linkedin: "",
        twitter: "",
        siteweb: "",
        invPersonnel: "",
        invHub: "",
        invRecherche: "",
        chiffreAffaire: "",
        nbremploye: "",
       

      },

      image:"",
      logo:"",
      style: {
        height: "0px",
      },

      //les datas
      stataData: {

        user2List: [],
        paysList: [],
        provinceList: [],
        formeJuridiqueList: [],
        secteurList: [],

      },
      agentList: [],
      fetchData: null,
      titreModal: "",

    };
  },
  computed: {
    ...mapGetters([
        "isloading",
        "paysList",
        "provinceList",
        "user2List",
        "formeJuridiqueList",
        "secteurList",
        "ListeEdition",
        "ListeNBREmploye",
    ]),
  },
  methods: {
    ...mapActions([
        "getPays",
        "getProvince",
        "getUser2",
        "getFormejuridique",
        "getSecteurList"
    ]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Entreprise ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nomPays;
      } else {
        this.titleComponent = "Ajout Entreprise";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entreprise?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
      
        if (this.edit) {
          this.updatePhoto();
        } else {
          this.updatePhoto();
        }
      }
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
          .post(`${this.apiBaseURL}/insert_entreprise`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.logo = "";
            this.showMsg(data.data);

            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();
            
            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
      } else {
        axios
          .post(`${this.apiBaseURL}/insert_entreprise`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.logo = "";
            this.showMsg(data.data);

            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);

            this.onPageChange();
            
            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
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


    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entreprise/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          this.initialisation();

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nomEntreprise;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entreprise/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    //les operation commence
    //fultrage de donnees
    async get_data_tug_pays(id_pays) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_province_tug_pays/${id_pays}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.provinceList = chart;
          } else {
            this.stataData.provinceList = [];
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

     //visualisation de
    async fetch_province_2() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_province_2`)
        .then((res) => {
          this.isLoading(false);
          var chart = res.data.data;

          if (chart) {
            this.stataData.provinceList = chart;
          } else {
            this.stataData.provinceList = [];
          }
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

    initialisation() {
      this.fetch_province_2();
    },

    operationEtat(id, etat) {
      if (id != "" && etat != "") {
        // alert("id:"+id+" etat:"+etat);

        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_entreprise/${id}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      } else {
        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_entreprise/${id}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      }
    },

    printBill(slug) {
      window.open(`${this.apiBaseURL}/pdf_entreprise_morale?slug=` + slug);
    },
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_user_all`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;

        }
      );
    },

    



  },
  created() {

    this.fetchListAgent();
    this.getPays();
    this.getUser2();

    this.getFormejuridique();
    this.getSecteurList();
    
    this.testTitle();
    this.onPageChange();
  },
};
</script>