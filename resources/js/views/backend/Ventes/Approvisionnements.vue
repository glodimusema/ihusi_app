<template>
    
    <v-layout>
        <v-flex md12>

            <VenteDetailEntrees ref="VenteDetailEntrees" />
            <BonEntree ref="BonEntree" />
            <ModelFournisseur ref="ModelFournisseur" />



            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>  
                
                
            <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="refService" dense outlined v-model="svData.refService" chips clearable 
                             @change="get_produit_for_service(svData.refService)">
                        </v-autocomplete>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Requisition" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateEntree">
                        </v-text-field>
                    </div>
                </v-flex>



                <v-flex xs12 sm12 md4 lg4>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms"
                            item-value="id" outlined dense v-model="svData.refFournisseur"
                             @change="fetchListCommande(svData.refFournisseur)">
                        </v-autocomplete>
                    </div>
                </v-flex> 
                <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="refreshData()" color="primary" :loading="loading"
                                        dark x-small fab depressed>
                                        <v-icon dark>refresh</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Recharger la liste</span>
                        </v-tooltip>

                    </div>
                </v-flex>
                <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="
                                        showFournisseur()
                                        " fab x-small color="primary" dark>
                                        <v-icon>add</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une avenue</span>
                        </v-tooltip>
                    </div>
                </v-flex>                
                <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                <v-autocomplete label="Selectionnez la Commande" prepend-inner-icon="home"
                    :items="this.CmdList" item-text="designationCommande" item-value="id" dense outlined v-model="svData.refRecquisition"
                    chips clearable>
                    </v-autocomplete>
                    </div>
                </v-flex>



                <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                <v-text-field label="Transporteur" prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.transporteur">
                </v-text-field>                   
                </div>
            </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                        </v-text-field>
                    </div>
                </v-flex>


                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez la Devise" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="deviseList" item-text="designation"
                            item-value="designation" dense outlined v-model="svData.devise" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>
                

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Unité</th>
                        <th>Qté Dispo</th>
                        <th>Qté</th>
                        <th>Pu</th>
                        <th>Reduction</th>
                        <th>TVA</th>
                        <th>PT</th>
                        <th>TVA(%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="long-cell">
                            <v-autocomplete v-model="item.idStockService" :items="produitList"
                                label="Selectionnez le Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designation" item-value="id"
                                @change="updateProduct(index)">
                            </v-autocomplete>
                        </td>
                        <td class="medium-cell">
                            <v-autocomplete v-model="item.refDetailUnite" :items="item.uniteList"
                                label="Selectionnez l'unité" item-text="nom_unite" item-value="id"
                                @change="updateUnite(index)">
                            </v-autocomplete>
                        </td>
                        <!-- <td class="short-cell">
                            <v-text-field v-model="item.nom_unite" label="Unité" readonly></v-text-field>
                        </td> -->
                        <td class="short-cell">
                            <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.qteEntree" type="number" label="Qté" :rules="[rules.required]"
                                required></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.puEntree" type="number" label="PU" :rules="[rules.required]"
                                required ></v-text-field>
                        </td>                      
                        <td class="short-cell">
                            <v-text-field v-model="item.montantreduction" type="number" label="Reduction"
                                ></v-text-field>
                        </td>
                        <td class="medium-cell">
                            <v-autocomplete v-model="item.id_tva" :items="item.tvaList"
                                label="Selectionnez la TVA" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="libelle_tva" item-value="id" @change="updateTVA(index)"
                                ></v-autocomplete>                            
                        </td>
                        <td>{{ item.pt }}</td>
                        <td>{{ item.tva }}</td>
                        <td>
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <div style="text-align: right; margin-top: 20px;"><strong>Total HT : {{ svData.totalInvoice }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>TVA(%) : {{ svData.totalTVA }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>Total TTC : {{ svData.totalTTC }} $</strong></div>

            <table>
                <tr>
                    <td>
                        <!-- <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div> -->
                    </td>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>   
                        <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>                    
                    </td>
                </tr>
            </table>

            

            <v-flex md12>
                <!-- <v-layout>
                    <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                        rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                        <span>Ajouter un Produit</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">Action</th>
                                <th class="text-left">N°BE</th>
                                <th class="text-left">DateEntrée</th>
                                <th class="text-left">Fournisseur</th>
                                <th class="text-left">Module</th>
                                <th class="text-left">Service</th>
                                <th class="text-left">Téléphone</th>
                                <th class="text-left">Libellé</th>
                                <th class="text-left">Montant</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Created_at</th> 
                                <!-- <th class="text-left">Observ.</th>                           -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                                <td>
                            <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense width="">


                                <v-list-item link @click="editDataTransfert(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Tranferer le Stock
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showDetailEntree(item.id, item.noms)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Entrée
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                <v-list-item-icon>
                                  <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon d'Entree
                                </v-list-item-title>
                              </v-list-item>

                               

                                <!-- <v-list-item    link @click="editData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="  blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                                </v-list-item> -->

                                <v-list-item   link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Suppression
                                </v-list-item-title>
                                </v-list-item>

                            </v-list>
                            </v-menu>

                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.dateEntree | formatDate }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.nom_module }}</td>
                        <td>{{ item.nom_service }}</td>
                        <td>{{ item.contact }}</td>
                        <td>{{ item.libelle }}</td>
                        <td>{{ item.montant }}$</td>
                        <td>{{ item.author }}</td>
                        <td>
                            {{ item.created_at | formatDate }}
                            {{ item.created_at | formatHour }}
                        </td> 
                        <!-- <td>
                            
                            <v-btn
                                  elevation="2"
                                  x-small
                                  class="white--text"
                                  :color="item.active =='OUI' ? '#3DA60C' : '#F13D17'"
                                  depressed                            
                                >
                                  {{ item.active =='OUI' ?  'à Tranférer' : 'Déjà Tranféré' }}
                            </v-btn>                         
                            
                        </td>   -->
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

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import BonEntree from '../Rapports/Finances/BonEntree.vue';
import VenteDetailEntrees from './VenteDetailEntrees.vue';
import ModelFournisseur from './ModelFournisseur.vue'

export default {
    components:{
    VenteDetailEntrees,
    BonEntree,
    ModelFournisseur
  },
    data() {
        return {

            title: "Liste des Approvisionnements",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refFournisseur: 0,
                refService: 0,
                refRecquisition:0,
                dateEntree: "",
                libelle: "Approvisionnements du Stock",
                transporteur : '',
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                indexEncours:0,
                devise: "",
               

                detailData: [{
                    qteDisponible: 0,
                    qteEntree: 0,
                    puEntree: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    nom_unite : '',
                    
                    uniteList: [],
                    tvaList: [],
                }],                
            },
            fetchData: [],
            produitList: [],
            fournisseurList: [],
            moduleList: [],
            serviceList: [],
            CmdList: [],  
            deviseList: [],
     

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListFournisseur();
        this.fetchListModule();
        this.fetchListService();
        this.fetchListDevise();
        this.fetchListTVA();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        refreshData()
        {
            this.fetchListFournisseur();
            this.get_produit_for_service(this.svData.refService);
        },
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                qteDisponible: 0,
                qteEntree: 0,
                puEntree: 0,
                devise: "",
                montantreduction: 0,
                idStockService : 0,
                pt:0,
                tva:0,
                montant_tva:0,
                id_tva:0,
                nom_unite : '',

                uniteList: [],
                tvaList: [],
            });
            this.fetchListTVA();
        },
        async get_produit_for_service(refService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_stock_data_byservice/${refService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    this.produitList = chart;
                } else {
                    this.produitList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async updateTVA(index)
            {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_tva/${this.svData.detailData[index].id_tva}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].montant_tva = donnees[0].montant_tva; // Update price per unit
                        this.svData.detailData[index].pt = ((this.svData.detailData[index].puEntree *this.svData.detailData[index].qteEntree) - this.svData.detailData[index].montantreduction); // Dummy price
                        this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100)
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        updatePT(index) {
            this.updateTVA(index);
            this.svData.detailData[index].pt = ((this.svData.detailData[index].puEntree *this.svData.detailData[index].qteEntree) - this.svData.detailData[index].montantreduction); // Dummy price
            this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100);

            // this.updateTotal(index);
        },
        updateTotal() {          

            this.svData.totalInvoice = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.pt;
            }, 0);

            this.svData.totalTVA = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.tva;
            }, 0);

            this.svData.totalTTC = this.svData.totalInvoice + this.svData.totalTVA;           
        },
        removeItem(index) {
            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].pt;
            this.svData.totalTVA = this.svData.totalTVA - this.svData.detailData[index].tva;
            this.svData.totalTTC = this.svData.totalTTC - this.svData.detailData[index].pt - this.svData.detailData[index].tva;
            this.indexEncours = this.indexEncours - index;

            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    qteDisponible: 0,
                    qteEntree: 0,
                    puEntree: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    nom_unite : '',
            }];
            this.$refs.form.reset(); // Reset the form validation state            
            this.fetchListTVA();
        },
        validate() {

            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement
                if (this.$refs.form.validate()) {
                    this.isLoading(true);
                    this.svData.author = this.userData.name;
                        this.svData.refUser = this.userData.id;
                        this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_vente_global_entree`,
                        JSON.stringify(this.svData)
                        )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                            this.resetForm();
                            this.svData.libelle="Approvisionnements du Stock";
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
            
                    }
                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }




        },
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vente_entete_entree?page=`);
        },
        fetchListModule() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.moduleList = donnees;
                }
            );
        },
        fetchListService() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_magasin_user_by_user/${this.userData.id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                }
            );
        },
        fetchListDevise() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.deviseList = donnees;
                }
            );
        },
        fetchListFournisseur() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.fournisseurList = donnees;
                }
            );
        },
        fetchListTVA() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tva_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        tvaList: donnees // Update 
                    }));
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_entree/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_entree/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailEntree(refEnteteEntree, name) {

        if (refEnteteEntree != '') {

            this.$refs.VenteDetailEntrees.$data.etatModal = true;
            this.$refs.VenteDetailEntrees.$data.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.$data.svData.refEnteteEntree = refEnteteEntree;
            this.$refs.VenteDetailEntrees.fetchDataList();
            this.$refs.VenteDetailEntrees.fetchListProduit();
            this.$refs.VenteDetailEntrees.fetchListTVA();
            this.fetchDataList();

            this.$refs.VenteDetailEntrees.$data.titleComponent =
            "Detail Entree pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },
    showFournisseur() {
      this.$refs.ModelFournisseur.$data.etatModal = true;
      this.$refs.ModelFournisseur.testTitle();
      this.$refs.ModelFournisseur.onPageChange();
      this.$refs.ModelFournisseur.fetchListCompte();
      this.fetchListFournisseur();

      this.$refs.ModelFournisseur.$data.titleComponentss =
        "Un nouveau Fournisseur";
      },
      showBonEntree(refEnteteEntree, name,ServiceData) {

      if (refEnteteEntree != '') {

        this.$refs.BonEntree.$data.dialog2 = true;
        this.$refs.BonEntree.$data.refEnteteEntree = refEnteteEntree;
        this.$refs.BonEntree.$data.ServiceData = ServiceData;
        this.$refs.BonEntree.showModel(refEnteteEntree);
        this.fetchDataList();

        this.$refs.BonEntree.$data.titleComponent =
          "Bon d'Entree pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

      },          
        fetchListCommande(refFournisseur) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_commande_data_by_fournisseur/${refFournisseur}`).then(
            ({ data }) => {
              var donnees = data.data;
              this.CmdList = donnees;
            }
          );
        },
        async get_unite_for_produit(idStockService) {
            // Initialize TempuniteList as an empty array
            const TempuniteList = []; 
            try {
                // Fetch data from the API
                const { data } = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_prod_stock_service/${idStockService}`);
                
                const donnees = data.data;

                // Update svData.detailData with the fetched data
                this.svData.detailData = this.svData.detailData.map(item => ({
                    ...item, // Spread existing properties
                    TempuniteList: donnees // Update TempuniteList
                }));
                // Populate TempuniteList with fetched data
                TempuniteList.push(...donnees);
            } catch (error) {
                console.error('Error fetching unit details:', error);
                // Handle error appropriately, e.g., show a notification
            }

            return TempuniteList; // Return the populated TempuniteList
        },
        async updateProduct(index) {
            try {
                // Fetch the unit list for the specified product reference
                const uniteList = await this.get_unite_for_produit(this.svData.detailData[index].idStockService);                    
                // Populate the uniteList in detailData for the specified index
                this.svData.detailData[index].uniteList = uniteList; // Replace or push as needed

            } catch (error) {
                console.error('Error updating product:', error);
                // Handle error appropriately, e.g., show a notification
            }
        },
        async updateUnite(index) {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_detailunite_stockdispo_service?refDetailUnite=` + this.svData.detailData[index].refDetailUnite+"&idStockService="+this.svData.detailData[index].idStockService);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        // this.svData.detailData[index].puEntree = donnees[0].puUnite; // Update price per unit
                        this.svData.detailData[index].qteDisponible = donnees[0].Qtedispo; // Update available quantity
                        this.svData.detailData[index].refProduit = donnees[0].refProduit;
                        this.svData.detailData[index].puEntree = donnees[0].cmupData;
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification 
                } 
        },


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 150px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>