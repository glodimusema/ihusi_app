<template>
    
    <v-layout>
        <v-flex md12>

            <GazDetailVente ref="GazDetailVente" />
            <GazPaiementVenteByFacture ref="GazPaiementVenteByFacture" />
            <FactureVente ref="FactureVente" />
            <ModelClient ref="ModelClient" />

            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>                
                <v-flex xs12 sm12 md4 lg4>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Client" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="noms"
                            item-value="id" outlined dense v-model="svData.refClient">
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
                                        showClient()
                                        " fab x-small color="primary" dark>
                                        <v-icon>add</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une Client</span>
                        </v-tooltip>
                    </div>
              </v-flex> 
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
                        <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateVente">
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
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Serveur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serveurList" item-text="noms_agent"
                            item-value="id" dense outlined v-model="svData.serveur_id" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>


                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="Etat de Facture" :items="[
                            { designation: 'Cash' },
                            { designation: 'Compte Maison' },
                            // { designation: 'Chambre' },
                            { designation: 'Crédit' },
                            // { designation: 'Location' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.etat_facture">
                        </v-select>
                    </div>
                </v-flex>
                

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nbr</th>
                        <th>Kit</th>
                        <th>Produit</th>
                        <th>Unité</th>
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
                    <tr>                        
                        <td class="long-cell">
                            <v-autocomplete v-model="svData.idStockService" :items="kitList"
                                label="Selectionnez le Kit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="nom_lot" item-value="id"
                            ></v-autocomplete>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="svData.qte_kit" label="Quantité" 
                             @change="getPrice(svData.idStockService, svData.qte_kit)"></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="svData.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                        </td>
                        
                    </tr>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="short-cell">
                            <v-text-field v-model="item.idParamLot" label="Id" readonly></v-text-field>
                        </td>
                        <td class="long-cell">
                            <v-text-field v-model="item.qte_kit" label="Kit" readonly></v-text-field>
                        </td>
                        <td class="long-cell">
                            <v-text-field v-model="item.code_lot" label="Kit" readonly></v-text-field>
                        </td>
                        <td class="long-cell">
                            <v-text-field v-model="item.produit_param" label="Produit" readonly></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.nom_unite" label="Unité" readonly></v-text-field>
                        </td>                       
                        <td class="short-cell">
                            <v-text-field v-model="item.qteVente" type="number" label="Qté" :rules="[rules.required]"
                                required></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.puVente" type="number" label="PU" :rules="[rules.required]"
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
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                        <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>
                    </td>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate2" color="success">Payer Cash</v-btn></div>  
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
                            <th class="text-left">N°FAC</th>
                            <th class="text-left">DateVente</th>
                            <th class="text-left">Service</th>
                            <th class="text-left">Client</th>
                            <th class="text-left">Téléphone</th>
                            <th class="text-left">Libellé</th>
                            <th class="text-left">Solde</th>
                            <th class="text-left">Etat</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Created_at</th>  
                            <th class="text-left">Facture</th>                        
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

                                <v-list-item link @click="showDetailVente(item.id, item.noms,item.refService)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Vente
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="payer_cash(item.id, item.dateVente)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cards</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Payer Cash
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showGazPaiementVenteByFacture(item.id, item.noms,item.totalFacture,item.totalPaie,item.RestePaie)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Paiement Facture
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showFacture(item.id,item.noms,'Ventes')">
                                <v-list-item-icon>
                                    <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer la Facture
                                </v-list-item-title>
                                </v-list-item> 
                                
                                

                                <!-- <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item   
                                link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler la Facture
                                </v-list-item-title>
                                </v-list-item> -->

                            </v-list>
                            </v-menu>
                            </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.dateVente | formatDate }}</td>
                            <td>{{ item.nom_service }}</td>
                            <td>{{ item.noms }}</td>
                            <td>{{ item.contact }}</td>
                            <td>{{ item.libelle }}</td>
                            <td>{{ item.RestePaie }}$</td>
                            <td>{{ item.etat_facture }}</td>
                            <td>{{ item.author }}</td>
                            <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                            </td>  
                            <td>
                                <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="showFacture(item.id,item.noms,'Ventes')" fab small><v-icon
                                              color="blue">print</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Imprimer Bon</span>
                                    </v-tooltip>
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

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import FactureVente from '../Rapports/Finances/FactureVente.vue';
import GazDetailVente from './GazDetailVente.vue';
import GazPaiementVenteByFacture from './GazPaiementVenteByFacture.vue';
import ModelClient from '../Ventes/ModelClient.vue'

export default {
    components:{
    GazDetailVente,
    GazPaiementVenteByFacture,
    FactureVente,
    ModelClient
  },
    data() {
        return {

            title: "Liste des Ventes",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refClient: 0,
                refService: 0,
                dateVente: "",
                libelle: "Ventes des Gaz et Accessoires",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                sommePU : 0,
                indexEncours:0,
                devise: "",
                serveur_id : 0,
                etat_facture : "",

                qteDisponible : 0,
                id_kit : 0,
                qte_kit : 0,

                detailData: [{                    
                    qteVente: 0,
                    puVente: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    code_lot : '',
                    nom_unite : '',
                    qte_kit : 0,

                    idParamLot : 0,
                    produit_param : "",
                    
                    
                    uniteList: [],
                    tvaList: [],
                }],                
            },
            fetchData: [],
            lotList: [],
            kitList: [],
            clientList: [],
            moduleList: [],
            serviceList: [],
            CmdList: [],  
            deviseList: [],
            serveurList: [],
        

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
        this.fetchListClient();
        this.fetchListModule();
        this.fetchListService();
        this.fetchListDevise();
        this.fetchListTVA();
        this.fetchListServeur();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                qteDisponible: 0,
                qteVente: 0,
                puVente: 0,
                devise: "",
                montantreduction: 0,
                idStockService : 0,
                code_lot : '',
                pt:0,
                tva:0,
                montant_tva:0,
                id_tva:0,
                nom_unite : '',
                idParamLot : 0,
                produit_param : "",
                qte_kit : 0,

                uniteList: [],
                tvaList: [],
            });
            this.fetchListTVA();
        },
       refreshData()
        {
            this.fetchListClient();
            this.get_produit_for_service(this.svData.refService);
        },
        async get_produit_for_service(refService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_gaz_stock_data_byservice/${refService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    //this.lotList = chart;
                    this.kitList = chart;
                } else {
                    //this.lotList = [];
                    this.kitList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async updateUnite(index) { 
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_service_stock/${this.svData.detailData[index].idStockService}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].nom_unite = donnees[0].unite_lot; // Update price per unit
                        this.svData.detailData[index].puVente = donnees[0].cmup_lot; // Update price per unit
                        this.svData.detailData[index].qteDisponible = donnees[0].qte_lot; // Update available quantity
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                } 
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
                        this.svData.detailData[index].pt = ((this.svData.detailData[index].puVente *this.svData.detailData[index].qteVente) - this.svData.detailData[index].montantreduction); // Dummy price
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
            this.svData.detailData[index].pt = ((this.svData.detailData[index].puVente *this.svData.detailData[index].qteVente) - this.svData.detailData[index].montantreduction); // Dummy price
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
                    qteVente: 0,
                    puVente: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    code_lot :'',
                    nom_unite : '',
                    idParamLot : 0,
                    produit_param : "",
                    qte_kit : 0,
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
                    `${this.apiBaseURL}/insert_gaz_globale_vente`,
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
                        this.svData.libelle="Ventes des Gaz et Accessoires";
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
        validate2() {

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
                        `${this.apiBaseURL}/insert_gaz_globale_vente_cash`,
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
        this.fetch_data(`${this.apiBaseURL}/fetch_gaz_entete_vente_encours?page=`);
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_pointvente_user_by_user/${this.userData.id}`).then(
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
        fetchListClient() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.clientList = donnees;
                }
            );
        },
        fetchListTVA() {
        //
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
        fetchListServeur() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serveurList = donnees;
                }
            );
        },
        fetchListKit() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_gaz_lot_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.kitList = donnees;
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_entete_vente/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_gaz_entete_vente/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailVente(refEnteteVente, name, refService) {

        if (refEnteteVente != '') { 

            this.$refs.GazDetailVente.$data.etatModal = true;
            this.$refs.GazDetailVente.$data.refEnteteVente = refEnteteVente;
            this.$refs.GazDetailVente.$data.refService = refService;
            this.$refs.GazDetailVente.$data.svData.refEnteteVente = refEnteteVente;
            this.$refs.GazDetailVente.fetchDataList();
            this.$refs.GazDetailVente.fetchListDevise();
            this.$refs.GazDetailVente.get_produit_for_service(refService);
            this.$refs.GazDetailVente.fetchListTVA();
            this.fetchDataList();

            this.$refs.GazDetailVente.$data.titleComponent =
            "Detail Vente pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }
        // 

        },
        showFacture(refEnteteVente, name,ServiceData) {

        if (refEnteteVente != '') {

            this.$refs.FactureVente.$data.dialog2 = true;
            this.$refs.FactureVente.$data.refEnteteSortie = refEnteteVente;
            this.$refs.FactureVente.$data.ServiceData = ServiceData;
            this.$refs.FactureVente.showModel(refEnteteVente);
            this.fetchDataList();

            this.$refs.FactureVente.$data.titleComponent =
            "La Facture pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },
        showGazPaiementVenteByFacture(refEnteteVente, name,totalFacture,totalPaie,RestePaie) {

        if (refEnteteVente != '') {

            this.$refs.GazPaiementVenteByFacture.$data.etatModal = true;
            this.$refs.GazPaiementVenteByFacture.$data.refEnteteVente = refEnteteVente;
            this.$refs.GazPaiementVenteByFacture.$data.totalFacture = totalFacture;
            this.$refs.GazPaiementVenteByFacture.$data.totalPaie = totalPaie;
            this.$refs.GazPaiementVenteByFacture.$data.RestePaie = RestePaie;
            this.$refs.GazPaiementVenteByFacture.$data.svData.refEnteteVente = refEnteteVente;
            this.$refs.GazPaiementVenteByFacture.fetchDataList();
            this.$refs.GazPaiementVenteByFacture.get_mode_Paiement();
            this.$refs.GazPaiementVenteByFacture.getInfoFacture();
            this.fetchDataList();

            this.$refs.GazPaiementVenteByFacture.$data.titleComponent =
            "Detail Paiement pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },    
        payer_cash(code,datavente) 
        {
            this.isLoading(true);
            this.svData.id=code;
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.dateVente = datavente;
            this.insertOrUpdate(
                `${this.apiBaseURL}/insert_gaz_cash_vente/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;                
                this.resetObj(this.svData);
                this.fetchDataList();
                })
                .catch((err) => {
                this.svErr(), this.isLoading(false);
                });
        },
        showClient() {
        this.$refs.ModelClient.$data.etatModal = true;
        this.$refs.ModelClient.testTitle();
        this.$refs.ModelClient.onPageChange();
        this.$refs.ModelClient.fetchListCompte();
        this.fetchListClient();

        this.$refs.ModelClient.$data.titleComponentss =
            "Un nouveau Client";

        },
          getPrice(idStockService, qte_kit) {
              this.editOrFetch(`${this.apiBaseURL}/fetch_single_gaz_service_stock/${idStockService}`).then(
                  ({ data }) => {
                      var donnees = data.data;
                      donnees.map((item) => {
                        this.svData.qteDisponible = item.qte_lot;
                      });  
                      
                       if(this.svData.qteDisponible >= qte_kit)
                       {
                           this.fetchListDataKit(idStockService, qte_kit);
                       }
                       else
                       {
                           this.showError("La quantité demandée est supérieur à la quantité disponible en stock !!!!");
                           this.svData.qte_kit = 0;
                       }
                  }                  
              );
            
              
          },
          
       async getDataProduct(idStockService, qte_kit)
       {
         this.getPrice(idStockService);
         this.fetchListDataKit(idStockService, qte_kit)
       }
       ,
    //    async fetchListDataKit(idStockService, qte_kit) {        

    //     // if(this.svData.qteDisponible >= qte_kit)
    //     // {
    //         try { 
    //             // Vérifier si les données de ce lot existent déjà
    //             const existeDeja = this.svData.detailData.some(row => row.idStockService === idStockService);
    //             if (existeDeja) {
    //                 alert('Les données de ce Kit ont déjà été ajoutées.');
    //                 return;
    //                 // console.error('Les données de ce lot ont déjà été ajoutées.');
    //             }
    //             else
    //             {
    //                 const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_data_gaz_parametre_byLotStockService/${idStockService}`);
    //                 const { data } = response;

    //                 // Vérifiez si les données existent
    //                 if (data && data.data) {
    //                     const donnees = data.data;
    //                     this.svData.detailData = [
    //                         ...this.svData.detailData.filter(row => row && row.produit_param),
    //                         ...donnees.map((item) => ({
    //                             ...item,
    //                             qteVente: item.qte_param * qte_kit,
    //                             puVente: item.pu_param,
    //                             devise: item.devise,
    //                             montantreduction: 0,
    //                             idStockService,
    //                             code_lot: item.code_lot,
    //                             pt: (item.qte_param * qte_kit) * item.pu_param,
    //                             tva: 0,
    //                             montant_tva: 0,
    //                             nom_unite: item.uniteBase,
    //                             idParamLot: item.id,
    //                             produit_param: item.designation
    //                           }))
    //                         ];
    //                         this.fetchListTVA();

    //                 } else {
    //                     console.error('Aucune donnée trouvée dans la réponse API.');
    //                 }   
    //             }

    //         } 
    //         catch (error) {
    //             console.error('Erreur lors de la récupération des données:', error.message || error);
    //         }

    //     // }
    //     // else
    //     // {
    //     //     this.showError("La quantité demandée est supérieur à la quantité disponible en stock !!!!");
    //     //     this.svData.detailData[index].qteVente = 0;
    //     // }
    //    },
        async fetchListDataKit(idStockService, qte_kit) {
        try {
            const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_data_gaz_parametre_byLotStockService/${idStockService}`);
            const { data } = response;

            if (data && data.data) {
            const donnees = data.data;

            // Filtrer les lignes valides (supprimer les lignes vides avant tout)
            this.svData.detailData = this.svData.detailData.filter(row => row && row.produit_param);

            donnees.forEach(item => {
                const index = this.svData.detailData.findIndex(
                row => row.idStockService === idStockService && row.idParamLot === item.id
                );

                const newRow = {
                ...item,
                    qteVente: item.qte_param * qte_kit,
                    puVente: item.pu_param,
                    devise: item.devise,
                    montantreduction: 0,
                    idStockService,
                    code_lot: item.code_lot,
                    pt: (item.qte_param * qte_kit) * item.pu_param,
                    tva: 0,
                    montant_tva: 0,
                    nom_unite: item.uniteBase,
                    idParamLot: item.id,
                    produit_param: item.designation,
                    qte_kit : qte_kit
                };

                if (index !== -1) {this.svData.detailData.splice(index, 1, newRow); // mettre à jour
                } else {
                this.svData.detailData.push(newRow); // ajouter
                }
            });

            this.fetchListTVA();
            } else {
            console.error('Aucune donnée trouvée dans la réponse API.');
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des données:', error.message || error);
        }
        }
       ,
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