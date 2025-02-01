<template>
    <v-layout>
        <v-flex md12>

            <!-- modal  -->
            <avatarAvatar ref="avatarAvatar" />
            <!-- fin modal -->
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
                        <v-card-text max-height="600px" background-color: white>
                            <v-layout row wrap>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Nom complet" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.nom_org">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse complète" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.adresse_org">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.contact_org">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse mail" prepend-inner-icon="draw" dense :rules="[
                                            (v) => !!v || 'Ce champ est requis',
                                            (v) =>
                                                /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                                        ]" outlined v-model="svData.mail_org"></v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="RCCM" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.rccm_org">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Id Nat" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.idnat_org">
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
                                            <th class="text-left">Nom</th>
                                            <th class="text-left">Contact</th>
                                            <th class="text-left">Mail</th>
                                            <th class="text-left">RCCM</th>
                                            <th class="text-left">IdNat</th>
                                            <th class="text-left">Adresse</th>
                                            <th>Mise à jour</th>

                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>

                                                <!-- image -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="
                                                    item.photo == null
                                                        ? `${baseURL}/fichier/avatar.png`
                                                        : `${baseURL}/fichier/` + item.photo
                                                " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.nom_org }}
                                            </td>
                                            <td>
                                                {{ item.contact_org }}
                                            </td>
                                            <td>

                                                {{ item.mail_org }}

                                            </td>
                                            <td>{{ item.rccm_org }}</td>
                                            <td>{{ item.idnat_org }}</td>
                                            <td>{{ item.adresse_org }}</td>                                          

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


                                                        <v-list-item    link @click="editData(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Modifier
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item   link @click="clearP(item.slug)">
                                                            <v-list-item-icon>
                                                                <v-icon color="red">delete</v-icon>
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

export default {
    components: {
        AvatarProfil,
        avatarAvatar,
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

            //'id','nom_org', 'adresse_org', 'contact_org', 'rccm_org', 'idnat_org', 'author', 'photo'
            svData: {
                id: "",
                nom_org: "",
                adresse_org: "",
                contact_org: "",
                mail_org: "",                
                rccm_org: "",
                idnat_org: "",
                author: "Admin"
            },
            stataData: {
            },
            fetchData: null,
            titreModal: "",
            image: "",
            clientList: [],
            fonctionList: [],
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
        };
    },

    computed: {
        ...mapGetters(["basicList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement Bailleur";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification Bailleur";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Bailleur";
                this.style.height = "0px";
            }
        },

        onPageChange() {
            //var connected = this.userData.id;
            this.fetch_data(`${this.apiBaseURL}/fetch_perso_partenaire?page=`);
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
                this.svData.author = this.userData.name;
                axios
                    .post(`${this.apiBaseURL}/update_perso_partenaire`, formData, config)
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
                    .post(`${this.apiBaseURL}/insert_perso_partenaire`, formData, config)
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_partenaire/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification des Informations";
                    });
                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                var connected = this.userData.id;
                this.delGlobal(`${this.apiBaseURL}/delete_perso_partenaire/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_partenaire/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification du Medecin";
                    });
                }
            );
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

    printBill(slug) {
        window.open(`${this.apiBaseURL}/pdf_client_data?slug=` + slug);
    },
    desactiverData(valeurs,user_created,date_entree,noms) {
      var tables='tagent';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un patient au nom de : "+noms+" par l'utilisateur "+user_name+"" ;

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