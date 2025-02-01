<template>
    <v-layout>
        <v-flex md12>

            <!-- modal  -->
            <avatarAvatar ref="avatarAvatar" />
            <!-- fin modal Stages  TaxePaiement-->

            <AvatarProfil ref="avatarPhoto" />
            <TaxePaiement ref="TaxePaiement" />



            <v-dialog v-model="dialog" max-width="900px" hide-overlay transition="dialog-bottom-transition">
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
                            </v-tooltip>
                        </v-card-title>
                        <v-card-text max-height="1500px" background-color: white>
                            <v-layout row wrap>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Nom de l'Entreprise" prepend-inner-icon="draw" dense
                                            outlined v-model="svData.colNom_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Code de l'Entreprise" prepend-inner-icon="draw" dense
                                            outlined v-model="svData.colId_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Idientification Nationale" prepend-inner-icon="draw" dense
                                            outlined v-model="svData.colIdNat_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="RCCM" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.colRCCM_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Raisons sociales" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.colRaisonSociale_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Forme Juridique" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.colFormeJuridique_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie de Taxe"
                                            prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="categorietaxeList" item-text="designation" item-value="id" dense
                                            outlined v-model="svData.ColRefCat" chips clearable>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Propriètaire" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.colProprietaire_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList"
                                            item-text="nomPays" item-value="id" dense outlined v-model="svData.idPays"
                                            chips clearable @change="get_data_tug_pays(svData.idPays)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.provinceList" item-text="nomProvince" item-value="id"
                                            dense outlined v-model="svData.idProvince" clearable chips
                                            @change="get_data_tug_province(svData.idProvince)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.villeList"
                                            item-text="nomVille" item-value="id" dense outlined v-model="svData.idVille"
                                            clearable chips @change="get_data_tug_commune(svData.idVille)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la commune" prepend-inner-icon="push_pin"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.communeList" item-text="nomCommune" item-value="id" dense
                                            outlined v-model="svData.idCommune" clearable
                                            @change="get_data_tug_quartier(svData.idCommune)" chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.quartierList" item-text="nomQuartier" item-value="id"
                                            dense outlined v-model="svData.ColRefQuartier" clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Avenue (N° Maison)" prepend-inner-icon="draw" dense
                                            outlined v-model="svData.colAdresseEntreprise_Ese">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Téléphone1" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.entreprisePhone1">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Téléphone2" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.entreprisePhone2">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse Mail" prepend-inner-icon="draw" dense outlined
                                            v-model="svData.entrepriseMail">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6class="mb-2">
                                    <input class="form-control" type="file" id="photo_input" @change="onImageChange"
                                        required />
                                    <br />
                                    <img :style="{ height: style.height }" id="output" />
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
                <v-layout>

                    <v-flex md12></v-flex>

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
                            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                                hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                        </v-flex>

                        <v-flex md6></v-flex>

                        <v-flex md1>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showModal" fab color="blue" dark>
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
                                            <th class="text-left">NomEse</th>
                                            <th class="text-left">IdNatEse</th>
                                            <th class="text-left">RCCMEse</th>
                                            <th class="text-left">Catégorie</th>
                                            <th class="text-left">Propriètaire</th>
                                            <th class="text-left">Province</th>
                                            <th class="text-left">Ville et Commune</th>
                                            <th class="text-left">Quartier</th>
                                            <th>Mise à jour</th>
                                            <!-- categorietaxe -->
                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>
                                                <!-- image -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photo == null
                                                        ? `${baseURL}/fichier/avatar.png`
                                                        : `${baseURL}/fichier/` + item.photo
                                                    " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.colNom_Ese }}</td>
                                            <td>{{ item.colIdNat_Ese }}</td>
                                            <td>{{ item.colRCCM_Ese }}</td>
                                            <td>{{ item.categorietaxe }}</td>
                                            <td>{{ item.colProprietaire_Ese }}</td>
                                            <td>{{ item.nomProvince }}</td>
                                            <td>{{ item.nomVille + "-" + item.nomCommune }}</td>
                                            <td>{{ item.nomQuartier }}</td>
                                            <td>
                                                {{ item.created_at | formatDate }}
                                                {{ item.created_at | formatHour }}
                                            </td>

                                            <td>
                                                <v-menu bottom rounded offset-y transition="scale-transition">
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on" small fab depressed text>
                                                            <v-icon>more_vert</v-icon>
                                                        </v-btn>
                                                    </template>

                                                    <v-list dense width="">
                                                        <v-list-item link
                                                            @click="showTaxePaiement(item.id, item.colNom_Ese)">
                                                            <v-list-item-icon>
                                                                <v-icon>description</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Enregistrer les Paiements des Taxes</v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item link @click="editData(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Modifier
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item link @click="clearP(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="red">delete</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Supprimer
                                                            </v-list-item-title>
                                                        </v-list-item>


                                                        <v-list-item link @click="printBill(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon>print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">PDF Agent
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <!-- <v-divider></v-divider>
                                                        <v-subheader>Autres Services</v-subheader>
                                                        <v-divider></v-divider> -->

                                                    </v-list>
                                                </v-menu>


                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                            <hr />

                            <v-pagination color="blue" v-model="pagination.current" :length="pagination.total"
                                :total-visible="7" @input="onPageChange"></v-pagination>
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
import AvatarProfil from '../Patients/AvatarProfil.vue';
import avatarAvatar from '../Patients/AvatarAction.vue';
import CheckList from "./CheckList.vue";
import TaxePaiement from "./TaxePaiement.vue";


export default {
    components: {
        AvatarProfil,
        avatarAvatar,
        TaxePaiement,
        CheckList
    },
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
                colId_Ese :"",
                colIdNat_Ese: "",
                colRCCM_Ese: "",
                colNom_Ese: "",
                colRaisonSociale_Ese: "",
                colFormeJuridique_Ese: "",
                ColRefCat: 0,
                ColRefQuartier: 0,
                colAdresseEntreprise_Ese: "",
                colProprietaire_Ese: "",
                entreprisePhone1 :"",
                entreprisePhone2:"",
                entrepriseMail:"",
                author: "",
                idPays: "",
                idProvince: "",
                idVille: "",
                idCommune: ""
            },
            stataData: {
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList: [],
                quartierList: []
            },
            fetchData: null,
            titreModal: "",
            image: "",
            categorietaxeList: [],
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''
        };
    },

    computed: {
        ...mapGetters(["basicList", "paysList",
            "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic", "getPays",
            "getProvince", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement Agent";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification Agent";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Client ";
                this.style.height = "0px";
            }
        },

        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_contribuable?page=`);
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
        fetchListSelectionCattaxe() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_Taxe2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorietaxeList = donnees;

                }
            );
        },
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
                    .post(`${this.apiBaseURL}/update_contribuable`, formData, config)
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
                this.svData.author = this.userData.name;
                axios
                    .post(`${this.apiBaseURL}/insert_contribuable`, formData, config)
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
                // this.isLoading(true);

                if (this.edit) {
                    this.updatePhoto();
                } else {
                    this.updatePhoto();
                }
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_contribuable/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;


                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification des Informations";
                        this.get_data_tug_pays(item.idPays);
                        this.get_data_tug_province(item.idProvince);
                        this.get_data_tug_commune(item.idVille);
                        this.get_data_tug_quartier(item.idCommune);
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_contribuable/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_agent/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification du Medecin";
                    });
                }
            );
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

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.villeList = chart;
                    } else {
                        this.stataData.villeList = [];
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

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.communeList = chart;
                    } else {
                        this.stataData.communeList = [];
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

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_quartier_tug_commune/${idCommune}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.quartierList = chart;
                    } else {
                        this.stataData.quartierList = [];
                    }

                    this.isLoading(false);

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
        //
        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_fiche_agent?id=` + id);
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
        showTaxePaiement(refEse, name) {

            if (refEse != '') {

                this.$refs.TaxePaiement.$data.etatModal = true;
                this.$refs.TaxePaiement.$data.refEse = refEse;
                this.$refs.TaxePaiement.$data.svData.refEse = refEse;
                this.$refs.TaxePaiement.fetchDataList();
                this.$refs.TaxePaiement.fetchListAgent();
                this.onPageChange();

                this.$refs.TaxePaiement.$data.titleComponent =
                    "Les Paiements de taxe pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }
        },
        desactiverData(valeurs, user_created, date_entree, noms) {
            //
            var tables = 'tagent';
            var user_name = this.userData.name;
            var user_id = this.userData.id;
            var detail_information = "Suppression d'un patient au nom de : " + noms + " par l'utilisateur " + user_name + "";

            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },


    },
    created() {

        this.onPageChange();
        this.testTitle();
        this.getPays();
        this.fetchListSelectionCattaxe();
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