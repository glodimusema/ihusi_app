<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
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
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker v-model="dates" range color="  blue"></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showListeClient" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS LISTE DES CLIENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                             <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailSortieByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                             <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteVenteDetteByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES DETTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailEntreeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES APPROVISONNEMENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailRequisitionByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES REQUISITIONS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> 

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementFactureCommandeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PAIEMENTS FOURNISSEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> 
                            <br>

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>                           
                            <br> -->
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockUniteByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/CAISSE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>                           
                            <br> -->
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie Client" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                                        item-text="designation" item-value="id" dense outlined v-model="svData.refCategorie" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                            <!-- <br> -->

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_Categorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES/CATEGORIE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList"
                                        item-text="designation" item-value="id" dense outlined v-model="svData.refProduit" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>

                            <!-- <br> -->

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_Produit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie Produit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieProList"
                                        item-text="designation" item-value="id" dense outlined v-model="svData.idCategorie" clearable
                                        chips>
                                        <!-- serviceList -->
                                        </v-autocomplete>
                                    </div>
                                </v-flex>                           

                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Categorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/CATEGORIE PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                                <!-- showFicheStockByDate_CategorieUnite -->
                            </v-tooltip>                          
                            
                            
                            
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_CategorieUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/CAISSE/CATEGORIE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                                <!-- showFicheStockByDate_CategorieUnite -->
                            </v-tooltip>                             
                            
                            <br>
                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez service" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                        item-text="nom_service" item-value="id" dense outlined v-model="svData.idService" clearable
                                        chips>
                                        <!-- showDetailVenteByDate_Service --> 
                                        </v-autocomplete>
                                    </div>
                                </v-flex>  
                                <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelDetailVenteService" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE/EXCEL
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_ServiceByProduit" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES VENTES/SERVICE/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_ServiceByCategorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> VENTES/SERVICE/CAT.PROD.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailUsageByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> SORTIE/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailUsageByDate_ServiceByCategorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> SORTIE/SERVICE/CATEGORIE PROD
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- showMouvementProduitByDate_ServiceByProduit -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailUsageByDate_ServiceByProduit" block color="  blue" dark>
                                            <v-icon>print</v-icon> SORTIE/SERVICE/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- showMouvementProduitByDate_ServiceByProduit -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showMouvementProduitByDate_ServiceByProduit" block color="  blue" dark>
                                            <v-icon>print</v-icon> RELEVE MOUVEMENT/SERVICE/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>                                
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailTransfertByDate_Service_Source" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES TRANSFERTS/SERVICE SOURCE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>                                
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailTransfertByDate_Service_Destination" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES TRANSFERTS/SERVICE RECEPTEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>                                
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailCuisineByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> LES COMMANDES CUISINES/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service_SansPrix" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERV./SANS PRIX
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Produit Vendable" :items="[
                                { designation: 'OUI' },
                                { designation: 'NON' }
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.statut">
                            </v-autocomplete>
                            <!-- <br>showFicheStockByDate_Service_Vendable_cmup -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service_Vendable" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERV./VENDABLE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service_Vendable_cmup" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERV./VENDABLE/CMUP
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service_Cout" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/COUT/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showInventaireByDate_Service" block color="  blue" dark>
                                            <v-icon>print</v-icon> INVENTAIRE STOCK/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_ServiceUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERVICE PIVOT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showInventaireByDate_ServiceUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> INVENTAIRE DE STOCK/SERVICE PIVOT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_ServiceByCategorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/CATEGORIE PROD.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showInventaireByDate_ServiceByCategorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> INVENTAIRE/SERVICE/CATEGORIE PROD.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_ServiceByCategorieUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/CATEGORIE PIVOT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showInventaireByDate_ServiceByCategorieUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> INVENTAIRE/SERVICE/CATEGORIE PIVOT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_ServiceByCategorieUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> SORTIE/SERVICE/CATEGORIE PIVOT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>                            
                            <br>
                            <v-autocomplete label="Type Sortie" :items="[
                                { designation: 'Casse' },
                                { designation: 'Usage Service' },
                                { designation: 'Peertes deverses' }
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.type_sortie">
                            </v-autocomplete>
                            <!-- <br> -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailUsageByDate_ServiceByTypeSortie" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT SORTIE/SERVICE/TYPE SORTIE.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Etat de la Facture" :items="[
                                { designation: 'Cash' },
                                { designation: 'Compte Maison' },
                                { designation: 'Chambre' },
                                { designation: 'Crédit' },
                                { designation: 'Location' }
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.etat_facture">
                            </v-autocomplete>
                            <!-- <br>showDetailSortieByDate_EtatFactureService -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_EtatFacture" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS VENTES/ETAT FACT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                              <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteVenteByDate_EtatFacture" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES FACTURES/ETAT FACT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_EtatFacture" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS FACTURE/ETAT FACT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_EtatFactureService" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS VENTES/ETAT FACT/SERVICE.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serveurList"
                                        item-text="noms_agent" item-value="id" dense outlined v-model="svData.serveur_id" clearable
                                        chips>
                                    </v-autocomplete>
                                </div>
                            </v-flex>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteVenteByDate_Serveur_EtatFacture" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS FACTURE/AGENT/ETAT FACT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                             <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteVenteDetteByDate_Serveur" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES DETTES/AGENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-autocomplete label="Selectionnez le Fournisseur" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="fournisseurList" item-text="noms" item-value="id"
                                    outlined dense v-model="svData.refFournisseur">
                            </v-autocomplete>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailEntreeByDate_Fss" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS ENTREE/FOURNISSEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailCommandeByDate_Fss" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS COMMANDE/FOURNISSEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
<!-- showSoldeFactureCommandeByDate -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showSoldeFactureCommandeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> SOLDES DES FOURNISSEURS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteFactureCommandeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> FACTURE DES FOURNISSEURS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelEnteteCommande" block color="  blue" dark>
                                            <v-icon>print</v-icon> FACTURES DES FOURNISSEURS/EXCEL
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelDetailCommande" block color="  blue" dark>
                                            <v-icon>print</v-icon> DETAILS DES FACTURES DES FSS./EXCEL
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteFactureCommandeByDate_Fss" block color="  blue" dark>
                                            <v-icon>print</v-icon> FACTURE DES FOURNISSEURS/FOURNISSEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPaiementFactureCommandeByDate_Fss" block color="  blue" dark>
                                            <v-icon>print</v-icon> PAIEMENTS DES FOURNISSEURS/FOURNISSEUR
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailEntreeByDate_Fss_Produit" block color="  blue" dark>
                                            <v-icon>print</v-icon> ENTREE/FOURNISSEUR/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailCommandeByDate_Fss_Produit" block color="  blue" dark>
                                            <v-icon>print</v-icon>COMMANDE/FOURNISSEUR/PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- exportToExcelFicheStockServiceSansPrix -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockService" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/EXCEL.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- exportToExcelFicheStockServiceSansPrix  -->
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockServiceSansPrix" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/SANS PRIX/EXCEL.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockServiceCategorie" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/CATEGORIE/EXCEL.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>



                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockServiceUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERVICE/EXCEL PIVOT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="exportToExcelFicheStockServiceCategorieUnite" block color="  blue" dark>
                                            <v-icon>print</v-icon> FICHE STOCK/SERV./CATEGORIE/EXCEL PIVOT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>


                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheSyntheseCompteByDate_Service_Vente" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT SYNTHESE COMPTES/VENTE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheSyntheseCompteByDate_Service_Approv" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORT SYNTHESE COMPTES/APPROV.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>


    

                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>                 

                
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import axios from 'axios';
import * as XLSX from 'xlsx';
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Rapport component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",                
                refProduit: "", 
                refCategorie:0,
                idCategorie:0,
                idService:0,
                statut : '',
                etat_facture : '',
                type_sortie : '',
                serveur_id : 0               
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            categorieList: [],
            fournisseurList: [],
            categorieProList: [],
            serviceList: [],
            produitList: [],
            serveurList: [],
            organisationList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        //
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            
        },
    fetchListFournisseur() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
        ({ data }) => {
          var donnees = data.data;
          this.fournisseurList = donnees;

        }
      );
    },
    fetchListServeur() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.serveurList = donnees;

        }
      );
    },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        
        onPageChange() {           
           
        },      
      fetchListCategorieClient() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_categorie_client_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieList = donnees;

          }
        );
      },      
      fetchListCategorieProduit() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_categorie_produit_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieProList = donnees;
          }
        );
      },      
      fetchListServiceVente() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_vente_services_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.serviceList = donnees;
          }
        );
      }
      ,
     
      async GetProduit() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_produit_2`)
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
              //fetch_pdf_rapport_detailentree_date
      },
        showDetailDetailEntreeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_entree_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailSortieByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailRequisitionByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_cmd_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate() {

            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }

       },
        showFicheStockUniteByDate() {

            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_unite?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }

       },
        showDetailSortieByDate_Categorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date_categorie?date1=` + date1+"&date2="+date2+"&refCategorie="+this.svData.refCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_EtatFacture() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_date_etat_facture?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },

        
        showEnteteVenteByDate_EtatFacture() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_client_date_etat_facture?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteVenteByDate_Serveur_EtatFacture() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture !="" && this.svData.serveur_id !="" )
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_client_date_etat_facture_agent?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture+"&serveur_id="+this.svData.serveur_id);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteVenteDetteByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
              window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_dette_client_date?date1=` + date1+"&date2="+date2);               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteVenteDetteByDate_Serveur() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.serveur_id !="" )
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_dette_client_date_agent?date1=` + date1+"&date2="+date2+"&serveur_id="+this.svData.serveur_id);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showListeClient() {
            window.open(`${this.apiBaseURL}/fetch_rapport_liste_client`); 
        },


        showDetailSortieByDate_EtatFactureService() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                //fetch_rapport_detailvente_date_etat_facture_service
                if(this.svData.etat_facture!="" && this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_date_etat_facture_service?date1=` + date1+"&date2="+date2+"&etat_facture="+this.svData.etat_facture+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner l'etat de la facture svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Categorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_categorie?date1=` + date1+"&date2="+date2+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_CategorieUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_categorie_unite?date1=` + date1+"&date2="+date2+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service_SansPrix() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_by_sans_prix?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service_Vendable() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="" && this.svData.statut != "")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_by_vendable?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&statut="+this.svData.statut);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service_Vendable_cmup() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="" && this.svData.statut != "")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_by_vendable_cmup?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&statut="+this.svData.statut);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service_Cout() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_cout_vente_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }
                else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showInventaireByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_inventaire_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_ServiceUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_fiche_stock_vente_service_unite?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showInventaireByDate_ServiceUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_inventaire_vente_service_unite?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_ServiceByCategorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_bycategorie?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_ServiceByCategorieUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_fiche_stock_vente_service_bycategorie_unite?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showInventaireByDate_ServiceByCategorieUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_inventaire_service_bycategorie_unite?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showInventaireByDate_ServiceByCategorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_inventaire_service_bycategorie?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailUsageByDate_ServiceByTypeSortie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.type_sortie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailusage_date_service_type?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&type_sortie="+this.svData.type_sortie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailUsageByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailusage_date_service_byproduit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showMouvementProduitByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_mouvement_produit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailUsageByDate_ServiceByCategorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailusage_date_service_bycategorie?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_ServiceByCategorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_date_service_bycategorie?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_ServiceByCategorieUnite() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_fiche_stock_vente_service_bycategorie_unite?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date_produit?date1=` + date1+"&date2="+date2+"&refProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le Produit svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailEntreeByDate_Fss() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailentree_date_fss?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailCommandeByDate_Fss() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailcmd_date_fss?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteFactureCommandeByDate_Fss() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="") 
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_date_fournisseur?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPaiementFactureCommandeByDate_Fss() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_commande_date_fournisseur?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPaiementFactureCommandeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_paiementfacture_commande_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteFactureCommandeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_entete_facture_cmd_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showSoldeFactureCommandeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_solde_facture_date_fournisseur?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailEntreeByDate_Fss_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="" && this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailentree_date_fss?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur+"&idProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailCommandeByDate_Fss_Produit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refFournisseur!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailcmd_date_fss?date1=` + date1+"&date2="+date2+"&refFournisseur="+this.svData.refFournisseur+"&idProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },       

        rechargement()
        {
            this.onPageChange();
            
        },
        showDetailUsageByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailusage_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailTransfertByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailtransfert_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailCuisineByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detail_cuisine_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailTransfertByDate_Service_Source() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailtransfert_date_service_source?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailTransfertByDate_Service_Destination() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailtransfert_date_service_destination?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },

        // =================== PARTIE EXCEL ==========================================================================================

        async exportToExcelFicheStockServiceCategorie() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!=""  && this.svData.idCategorie!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_bycategorie_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelFicheStockService() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelFicheStockServiceSansPrix() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_sans_prix_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelFicheStockServiceCategorie() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!=""  && this.svData.idCategorie!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_bycategorie_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelDetailCommande() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                        const response = await axios.get(`${this.apiBaseURL}/pdf_detail_commande_fournisseur_excel?date1=` + date1+"&date2="+date2);
                        let detail_commande = response.data; // Changez const en let

                        console.log('Réponse de API:', detail_commande); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(detail_commande)) {
                            // C'est déjà un tableau
                        } else if (detail_commande.data && Array.isArray(detail_commande.data)) {
                            detail_commande = detail_commande.data; // Accéder au tableau
                        } else if (detail_commande.products && Array.isArray(detail_commande.products)) {
                            detail_commande = detail_commande.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(detail_commande);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'detail_commande');

                        XLSX.writeFile(workbook, 'RapportDetaisFactureFournisseur.xlsx');                               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelEnteteCommande() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                        const response = await axios.get(`${this.apiBaseURL}/pdf_entete_commande_fournisseur_excel?date1=` + date1+"&date2="+date2);
                        let entete_commande = response.data; // Changez const en let

                        console.log('Réponse de API:', entete_commande); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(entete_commande)) {
                            // C'est déjà un tableau
                        } else if (entete_commande.data && Array.isArray(entete_commande.data)) {
                            entete_commande = entete_commande.data; // Accéder au tableau
                        } else if (entete_commande.products && Array.isArray(entete_commande.products)) {
                            entete_commande = entete_commande.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(entete_commande);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'entete_commande');

                        XLSX.writeFile(workbook, 'RapportEnteteFactureFournisseur.xlsx');                               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelEnteteCommandeFournisseur() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {                        

                        const response = await axios.get(`${this.apiBaseURL}/pdf_entete_commande_fournisseur_excel?date1=` + date1+"&date2="+date2);
                        let entete_commande = response.data; // Changez const en let

                        console.log('Réponse de API:', entete_commande); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(entete_commande)) {
                            // C'est déjà un tableau
                        } else if (entete_commande.data && Array.isArray(entete_commande.data)) {
                            entete_commande = entete_commande.data; // Accéder au tableau
                        } else if (entete_commande.products && Array.isArray(entete_commande.products)) {
                            entete_commande = entete_commande.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(entete_commande);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'entete_commande');

                        XLSX.writeFile(workbook, 'RapportEnteteFactureFournisseur.xlsx');                               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },



        async exportToExcelFicheStockServiceCategorieUnite() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!=""  && this.svData.idCategorie!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_bycategorie_unite_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idCategorie="+this.svData.idCategorie);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        async exportToExcelFicheStockServiceUnite() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_fiche_stock_vente_service_unite_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let users = response.data; // Changez const en let

                        console.log('Réponse de API:', users); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(users)) {
                            // C'est déjà un tableau
                        } else if (users.data && Array.isArray(users.data)) {
                            users = users.data; // Accéder au tableau
                        } else if (users.products && Array.isArray(users.products)) {
                            users = users.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(users);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');

                        XLSX.writeFile(workbook, 'fichestockServiceCategorie.xlsx');
                    }
                    else
                    {
                        this.showError("Veillez selectionner le servic et Categorie svp");
                    }               

                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        showFicheSyntheseCompteByDate_Service_Vente() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_mouvement_comptes?date1=` + date1+"&date2="+date2+"&refService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheSyntheseCompteByDate_Service_Approv() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_mouvement_comptes_entree?date1=` + date1+"&date2="+date2+"&refService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        async exportToExcelDetailVenteService() {
            try {
                var date1 =  this.dates[0] ;
                var date2 =  this.dates[1] ;

                if (date1 <= date2) {

                    if(this.svData.idService!="")
                    {
                        const response = await axios.get(`${this.apiBaseURL}/pdf_detail_vente_service_excel?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                        let detail_vente_service = response.data; // Changez const en let

                        console.log('Réponse de API:', detail_vente_service); // Vérifiez la structure des données

                        // Adapter l'accès aux données en fonction de la structure
                        if (Array.isArray(detail_vente_service)) {
                            // C'est déjà un tableau
                        } else if (detail_vente_service.data && Array.isArray(detail_vente_service.data)) {
                            detail_vente_service = detail_vente_service.data; // Accéder au tableau
                        } else if (detail_vente_service.products && Array.isArray(detail_vente_service.products)) {
                            detail_vente_service = detail_vente_service.products; // Accéder au tableau
                        } else {
                            throw new Error('Les données récupérées ne sont pas un tableau');
                        }

                        const worksheet = XLSX.utils.json_to_sheet(detail_vente_service);
                        const workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, 'detail_vente_service');

                        XLSX.writeFile(workbook, 'RapportDetailVenteService.xlsx');                               

                    }
                    else
                    {
                        this.showError("Veillez selectionner le service svp");
                    } 

                        
                } 
                else {
                  this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
                }

            } 
            catch (error) {
                console.error("Erreur lors de l'exportation : ", error);
            }
        },
        showDetailVenteByDate_ServiceByProduit() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!=""  && this.svData.refProduit!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_detailvente_date_service_byproduit?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService+"&idProduit="+this.svData.refProduit);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detail_vente_date_service?date1=` + date1+"&date2="+date2+"&idService="+this.svData.idService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        }

       


    },
    created() {
        this.fetchListCategorieClient();
        this.fetchListCategorieProduit();
        this.fetchListServiceVente();
        this.fetchListFournisseur();
        this.fetchListServeur();
        this.GetProduit();
        this.showDate=true;
    },
};
</script>