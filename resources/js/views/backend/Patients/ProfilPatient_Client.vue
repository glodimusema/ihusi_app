<template>
    <v-layout>
        <v-flex md12>

            <RapportMedical_Client ref="RapportMedical_Client" />
            <RDVPatient_Client ref="RDVPatient_Client" />
            <avatarAvatar ref="avatarAvatar" />
            <AvatarProfil ref="avatarPhoto" />
            <!-- RDVPatient -->

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

                                <v-flex xs12 sm12 md12 lg12>
                                    <v-text-field label="Nom complet" prepend-inner-icon="draw" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                        v-model="svData.noms_profil"></v-text-field>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Sexe *" :items="[
                                            { designation: 'M' },
                                            { designation: 'F' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.sexe_profil"></v-select>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Naissance" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.datenaissance_profil">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Groupe Sanguin *" :items="[
                                            { designation: 'O+' },
                                            { designation: 'A+' },
                                            { designation: 'B+' },
                                            { designation: 'AB+' },
                                            { designation: 'O-' },
                                            { designation: 'A-' },
                                            { designation: 'B-' },
                                            { designation: 'AB-' },
                                            { designation: 'En attente' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.groupesanguin"></v-select>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Expiration Carte" prepend-inner-icon="event"
                                            dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.dateExpiration">
                                        </v-text-field>
                                    </div>
                                </v-flex>




                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse Complète" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.adresse_profil">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.telephone_profil">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Code Secret" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.codeSecret">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6 class="mb-2">
                                    <div class="mr-1">
                                        <input class="form-control" type="file" id="photo_input" @change="onImageChange"
                                            required />
                                        <br />
                                        <img :style="{ height: style.height }" id="output" />
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field readonly label="Adresse mail" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.mail_profil">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <div id="app" class="web-camera-container">
                                            <div class="camera-button">
                                                <button type="button" class="button is-rounded"
                                                    :class="{ 'is-primary': !isCameraOpen, 'is-danger': isCameraOpen }"
                                                    @click="toggleCamera">
                                                    <span v-if="!isCameraOpen">Open Camera</span>
                                                    <span v-else>Close Camera</span>
                                                </button>
                                            </div>

                                            <div v-show="isCameraOpen && isLoading2" class="camera-loading">
                                                <ul class="loader-circle">
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                </ul>
                                            </div>

                                            <div v-if="isCameraOpen" v-show="!isLoading2" class="camera-box"
                                                :class="{ 'flash': isShotPhoto }">

                                                <div class="camera-shutter" :class="{ 'flash': isShotPhoto }"></div>

                                                <video v-show="!isPhotoTaken" ref="camera" :width="450" :height="337.5"
                                                    autoplay></video>

                                                <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="450"
                                                    :height="337.5"></canvas>
                                            </div>

                                            <div v-if="isCameraOpen && !isLoading2" class="camera-shoot">
                                                <button type="button" class="button" @click="takePhoto">
                                                    <img
                                                        src="https://img.icons8.com/material-outlined/50/000000/camera--v2.png">
                                                </button>
                                            </div>

                                            <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
                                                <a id="downloadPhoto" download="my-photo.jpg" class="button" role="button"
                                                    @click="downloadImage">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
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
                        <!-- {{ JSON.stringify(userData.email) }} -->
                        <!-- this.email_user -->
                        <v-flex md4>
                            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                                hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                        </v-flex>

                        <v-flex md6></v-flex>

                        <!-- <v-flex md1>
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
                        </v-flex> -->
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
                                            <th class="text-left">Sexe</th>
                                            <th class="text-left">Age</th>
                                            <th class="text-left">GroupeS.</th>
                                            <th class="text-left">Telephone</th>
                                            <th class="text-left">E-mail</th>
                                            <th class="text-left">N°Carte</th>
                                            <th class="text-left">DateExp.</th>
                                            <th>Mise à jour</th>

                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>

                                                <!-- image  -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photo_profil == null
                                                    ? `${baseURL}/fichier/avatar.png`
                                                    : `${baseURL}/fichier/` + item.photo_profil
                                                    " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.noms_profil }}</td>
                                            <td>{{ item.sexe_profil }}</td>
                                            <td>{{ item.age_profil }}</td>
                                            <td>{{ item.groupesanguin }}</td>
                                            <td>{{ item.telephone_profil }}</td>
                                            <td>{{ item.mail_profil }}</td>
                                            <td>{{ item.numeroCarte }}</td>
                                            <td>{{ item.dateExpiration }}</td>

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

                                                        <v-list-item  link @click="editData(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Modifier</v-list-item-title>
                                                        </v-list-item>

                                                        <!-- <v-list-item link @click="clearP(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="red">delete</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Supprimer</v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item link @click="printBill(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Imprimer Carte
                                                                Medicale</v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-divider></v-divider>
                                                        <v-subheader>Deroulement</v-subheader>
                                                        <v-divider></v-divider>

                                                        <v-list-item link
                                                            @click="showRapportMedical(item.numeroCarte, item.noms_profil)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Données Medicales
                                                            </v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item link
                                                            @click="showRDVPatient(item.numeroCarte, item.noms_profil)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Les Rendez-vous
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
import RapportMedical_Client from './RapportMedical_Client.vue';
import RDVPatient_Client from './RDVPatient_Client.vue';
import uploadImage from '../admin/photo.vue';
import AvatarProfil from "./AvatarProfil.vue"
import avatarAvatar from './AvatarAction.vue'


//import uploadImage from "./photo";

export default {
    components: {
        RapportMedical_Client,
        RDVPatient_Client,
        uploadImage,
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

            isCameraOpen: false,
            isPhotoTaken: false,
            isShotPhoto: false,
            isLoading2: false,
            link: '#',

            style: {
                height: "0px",
            },
            svData: {
                id: "",
                refUser: "",
                dateExpiration: "",
                codeSecret: "",
                noms_profil: "",
                adresse_profil: "",
                telephone_profil: "",
                datenaissance_profil: "",
                groupesanguin: "",
                sexe_profil: "",
                mail_profil: ""
            },
            fetchData: null,
            titreModal: "",
            image: "",
            clientList: [],
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },
            maladeList: [],
            etatSearch: false,
            email_user:""
        };
    },

    computed: {
        ...mapGetters(["basicList", "paysList",
            "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement du Malade ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        onPageTexteSearch(text) {
            if (text != "") {

                this.editOrFetch(`${this.apiBaseURL}/searchMaladeTeste?query=${text}`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.maladeList = donnees;

                        this.etatSearch = true;

                    }
                );

            } else {

            }

        },

        setNom(text) {
            this.svData.noms = text;
            this.etatSearch = false;

        },
      fetchAccess() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_user/${this.userData.id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
          this.email_user = item.email;
        });

          console.log(donnees);
        }
      );
    },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification du Malade ";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Client ";
                this.style.height = "0px";
            }
        },
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/showCarte_Compte/${this.email_user}?page=`);
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
                    .post(`${this.apiBaseURL}/update_carte_profil`, formData, config)
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
                    .post(`${this.apiBaseURL}/insert_carte_malade`, formData, config)
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_carte_malade/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;


                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification de  du Patient ";
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
                this.delGlobal(`${this.apiBaseURL}/delete_carte_malade/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_carte_malade/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification de  client de l'entreprise";
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

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_carte_medicale?id=` + id);
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

        showRapportMedical(refPatient, name) {

            if (refPatient != '') {

                this.$refs.RapportMedical_Client.$data.etatModal = true;
                this.$refs.RapportMedical_Client.$data.refPatient = refPatient;
                this.$refs.RapportMedical_Client.$data.svData.refPatient = refPatient;
                this.$refs.RapportMedical_Client.fetchDataList();

                this.$refs.RapportMedical_Client.$data.titleComponent =
                    "Les Données médicales de  " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },

        showRDVPatient(numeroCarte, name) {

            if (numeroCarte != '') {

                this.$refs.RDVPatient_Client.$data.etatModal = true;
                this.$refs.RDVPatient_Client.$data.numeroCarte = numeroCarte;
                this.$refs.RDVPatient_Client.$data.svData.numeroCarte = numeroCarte;
                this.$refs.RDVPatient_Client.fetchDataList();

                this.$refs.RDVPatient_Client.$data.titleComponent =
                    "Les Rendez-vous de  " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },





        //MaladieChronique

        // PARTIE CAPTURE IMAGERIE 


        toggleCamera() {
            if (this.isCameraOpen) {
                this.isCameraOpen = false;
                this.isPhotoTaken = false;
                this.isShotPhoto = false;
                this.stopCameraStream();
            } else {
                this.isCameraOpen = true;
                this.createCameraElement();
            }
        },

        createCameraElement() {
            this.isLoading2 = true;

            const constraints = (window.constraints = {
                audio: false,
                video: true
            });


            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(stream => {
                    this.isLoading2 = false;
                    this.$refs.camera.srcObject = stream;
                })
                .catch(error => {
                    this.isLoading2 = false;
                    alert("May the browser didn't support or there is some errors.");
                });
        },

        stopCameraStream() {
            let tracks = this.$refs.camera.srcObject.getTracks();

            tracks.forEach(track => {
                track.stop();
            });
        },

        takePhoto() {
            if (!this.isPhotoTaken) {
                this.isShotPhoto = true;

                const FLASH_TIMEOUT = 50;

                setTimeout(() => {
                    this.isShotPhoto = false;
                }, FLASH_TIMEOUT);
            }

            this.isPhotoTaken = !this.isPhotoTaken;

            const context = this.$refs.canvas.getContext('2d');
            context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
        },
        downloadImage() {
            const download = document.getElementById("downloadPhoto");
            const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg")
                .replace("image/jpeg", "image/octet-stream");
            download.setAttribute("href", canvas);
        }


    },
    created() {        
        //this.fetchAccess(); 
        this.email_user=this.userData.email;       
        this.testTitle();
        this.onPageChange();
    },
};
</script>
<style lang="scss">   //  @import url('../../cssimage/image.scss');
</style>  
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

#etatSearch {
    width: 100%;
    height: 250px;
    max-height: 250vh;
    border: 1px bisque;
    border-radius: 20%;
}
</style>